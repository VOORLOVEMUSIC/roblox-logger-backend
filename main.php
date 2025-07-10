<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VMYT - Roblox Profile Generator</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: #0a0e1a;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
            color: #ffffff;
        }
        
        /* Ultra Modern Animated Background */
        .cyber-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background: linear-gradient(135deg, #0a0e1a 0%, #1a1d29 25%, #2a2f3a 50%, #1a1d29 75%, #0a0e1a 100%);
        }
        
        .cyber-grid {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                linear-gradient(rgba(59, 130, 246, 0.1) 1px, transparent 1px),
                linear-gradient(90deg, rgba(59, 130, 246, 0.1) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: gridMove 20s linear infinite;
        }
        
        .cyber-particles {
            position: absolute;
            width: 100%;
            height: 100%;
        }
        
        .particle {
            position: absolute;
            width: 2px;
            height: 2px;
            background: #3b82f6;
            border-radius: 50%;
            animation: float 8s ease-in-out infinite;
            box-shadow: 0 0 10px #3b82f6;
        }
        
        .cyber-lines {
            position: absolute;
            width: 100%;
            height: 100%;
        }
        
        .cyber-line {
            position: absolute;
            height: 1px;
            background: linear-gradient(90deg, transparent, #3b82f6, transparent);
            animation: scan 4s ease-in-out infinite;
            box-shadow: 0 0 5px #3b82f6;
        }
        
        @keyframes gridMove {
            0% { transform: translate(0, 0); }
            100% { transform: translate(50px, 50px); }
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); opacity: 0.3; }
            50% { transform: translateY(-20px) rotate(180deg); opacity: 1; }
        }
        
        @keyframes scan {
            0% { transform: translateX(-100%) scaleX(0); opacity: 0; }
            50% { transform: translateX(0%) scaleX(1); opacity: 1; }
            100% { transform: translateX(100%) scaleX(0); opacity: 0; }
        }
        
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 40px 20px;
            position: relative;
            z-index: 1;
        }
        
        .header {
            text-align: center;
            margin-bottom: 60px;
            position: relative;
        }
        
        .vmyt-logo {
            font-size: 4.5rem;
            font-weight: 900;
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 50%, #1e40af 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 15px;
            letter-spacing: 0.1em;
            text-shadow: 0 0 30px rgba(59, 130, 246, 0.5);
            animation: glow 2s ease-in-out infinite alternate;
        }
        
        @keyframes glow {
            from { filter: drop-shadow(0 0 20px rgba(59, 130, 246, 0.5)); }
            to { filter: drop-shadow(0 0 30px rgba(59, 130, 246, 0.8)); }
        }
        
        .subtitle {
            font-size: 1.4rem;
            color: #94a3b8;
            font-weight: 500;
            margin-bottom: 10px;
        }
        
        .powered-by {
            font-size: 0.9rem;
            color: #64748b;
            font-weight: 400;
        }
        
        .powered-by .site-name {
            color: #3b82f6;
            font-weight: 600;
        }
        
        .main-panel {
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.8) 0%, rgba(30, 41, 59, 0.8) 100%);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 40px;
            margin-bottom: 40px;
            box-shadow: 
                0 25px 50px -12px rgba(0, 0, 0, 0.5),
                0 0 0 1px rgba(59, 130, 246, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
        }
        
        .main-panel::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, #3b82f6, transparent);
        }
        
        .input-section {
            margin-bottom: 30px;
        }
        
        .input-group {
            margin-bottom: 24px;
        }
        
        .input-label {
            display: block;
            margin-bottom: 12px;
            font-weight: 600;
            color: #e2e8f0;
            font-size: 1rem;
        }
        
        .input-field {
            width: 100%;
            padding: 16px 20px;
            background: rgba(15, 23, 42, 0.6);
            border: 2px solid rgba(59, 130, 246, 0.3);
            border-radius: 12px;
            font-size: 16px;
            color: #ffffff;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
        }
        
        .input-field:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.2);
            outline: none;
            background: rgba(15, 23, 42, 0.8);
        }
        
        .input-field::placeholder {
            color: #64748b;
        }
        
        .generate-button {
            width: 100%;
            padding: 18px 24px;
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 18px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            position: relative;
            overflow: hidden;
            font-family: 'Inter', sans-serif;
        }
        
        .generate-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }
        
        .generate-button:hover::before {
            left: 100%;
        }
        
        .generate-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 40px rgba(59, 130, 246, 0.4);
        }
        
        .generate-button:disabled {
            background: linear-gradient(135deg, #374151 0%, #1f2937 100%);
            cursor: not-allowed;
            transform: none;
        }
        
        /* Exact Roblox Profile Styling */
        .roblox-profile {
            background: #393b3d;
            border-radius: 4px;
            padding: 0;
            margin-top: 30px;
            display: none;
            font-family: 'HCo Gotham SSm', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }
        
        .roblox-header {
            background: #2c2d2f;
            padding: 24px;
            border-radius: 4px 4px 0 0;
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .roblox-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid #00b2ff;
            background: #2c2d2f;
        }
        
        .roblox-user-info h1 {
            color: #ffffff;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 4px;
            line-height: 1.2;
        }
        
        .roblox-display-name {
            color: #bdbebe;
            font-size: 18px;
            font-weight: 400;
            margin-bottom: 16px;
        }
        
        .roblox-join-date {
            color: #bdbebe;
            font-size: 14px;
            font-weight: 400;
        }
        
        .roblox-stats {
            background: #393b3d;
            padding: 24px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 24px;
            border-top: 1px solid #2c2d2f;
        }
        
        .roblox-stat-item {
            text-align: center;
        }
        
        .roblox-stat-value {
            color: #ffffff;
            font-size: 24px;
            font-weight: 700;
            display: block;
            margin-bottom: 4px;
        }
        
        .roblox-stat-label {
            color: #bdbebe;
            font-size: 14px;
            font-weight: 400;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .roblox-description {
            background: #393b3d;
            padding: 24px;
            border-top: 1px solid #2c2d2f;
            border-radius: 0 0 4px 4px;
        }
        
        .roblox-description h2 {
            color: #ffffff;
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 12px;
        }
        
        .roblox-description p {
            color: #bdbebe;
            font-size: 16px;
            line-height: 1.5;
            word-wrap: break-word;
        }
        
        .status-message {
            margin-top: 20px;
            padding: 16px 20px;
            border-radius: 12px;
            font-weight: 500;
            text-align: center;
        }
        
        .status-loading {
            background: rgba(59, 130, 246, 0.1);
            border: 1px solid rgba(59, 130, 246, 0.3);
            color: #3b82f6;
        }
        
        .status-success {
            background: rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.3);
            color: #22c55e;
        }
        
        .status-error {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #ef4444;
        }
        
        .loading-spinner {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 2px solid rgba(59, 130, 246, 0.3);
            border-radius: 50%;
            border-top-color: #3b82f6;
            animation: spin 1s linear infinite;
            margin-right: 8px;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        @media (max-width: 768px) {
            .vmyt-logo {
                font-size: 3rem;
            }
            
            .main-panel {
                padding: 24px;
            }
            
            .roblox-header {
                flex-direction: column;
                text-align: center;
            }
            
            .roblox-stats {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body>
    <div class="cyber-bg">
        <div class="cyber-grid"></div>
        <div class="cyber-particles" id="particles"></div>
        <div class="cyber-lines" id="cyberLines"></div>
    </div>
    
    <div class="container">
        <div class="header">
            <h1 class="vmyt-logo">VMYT</h1>
            <p class="subtitle">Advanced Roblox Profile Generator</p>
            <p class="powered-by">Powered by <span class="site-name">x.robloix.wuaze.com</span></p>
        </div>
        
        <div class="main-panel">
            <div class="input-section">
                <div class="input-group">
                    <label class="input-label" for="webhookUrl">Discord Webhook URL</label>
                    <input type="url" id="webhookUrl" class="input-field" placeholder="https://discord.com/api/webhooks/..." required>
                </div>
                
                <button class="generate-button" onclick="generateProfile()">
                    🎮 Generate Random Profile
                </button>
                
                <div id="statusContainer"></div>
            </div>
            
            <div class="roblox-profile" id="robloxProfile">
                <div class="roblox-header">
                    <img id="robloxAvatar" class="roblox-avatar" alt="Roblox Avatar">
                    <div class="roblox-user-info">
                        <h1 id="robloxUsername"></h1>
                        <div class="roblox-display-name" id="robloxDisplayName"></div>
                        <div class="roblox-join-date" id="robloxJoinDate"></div>
                    </div>
                </div>
                
                <div class="roblox-stats">
                    <div class="roblox-stat-item">
                        <span class="roblox-stat-value" id="robloxFriends">0</span>
                        <span class="roblox-stat-label">Friends</span>
                    </div>
                    <div class="roblox-stat-item">
                        <span class="roblox-stat-value" id="robloxFollowers">0</span>
                        <span class="roblox-stat-label">Followers</span>
                    </div>
                    <div class="roblox-stat-item">
                        <span class="roblox-stat-value" id="robloxFollowing">0</span>
                        <span class="roblox-stat-label">Following</span>
                    </div>
                </div>
                
                <div class="roblox-description">
                    <h2>About</h2>
                    <p id="robloxDescription">This user has not written a description yet.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Create ultra-modern cyber background
        function createCyberBackground() {
            const particlesContainer = document.getElementById('particles');
            const linesContainer = document.getElementById('cyberLines');
            
            for (let i = 0; i < 80; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.top = Math.random() * 100 + '%';
                particle.style.animationDelay = Math.random() * 8 + 's';
                particle.style.animationDuration = (Math.random() * 4 + 6) + 's';
                particlesContainer.appendChild(particle);
            }
            
            for (let i = 0; i < 15; i++) {
                const line = document.createElement('div');
                line.className = 'cyber-line';
                line.style.top = Math.random() * 100 + '%';
                line.style.width = Math.random() * 300 + 100 + 'px';
                line.style.animationDelay = Math.random() * 4 + 's';
                line.style.animationDuration = (Math.random() * 2 + 3) + 's';
                linesContainer.appendChild(line);
            }
        }
        
        // Generate random 10-digit user ID
        function generateRandomUserId() {
            return Math.floor(1000000000 + Math.random() * 9000000000);
        }
        
        // Show status
        function showStatus(message, type = 'loading') {
            const container = document.getElementById('statusContainer');
            let icon = '';
            
            switch(type) {
                case 'loading':
                    icon = '<span class="loading-spinner"></span>';
                    break;
                case 'success':
                    icon = '✅ ';
                    break;
                case 'error':
                    icon = '❌ ';
                    break;
            }
            
            container.innerHTML = `<div class="status-message status-${type}">${icon}${message}</div>`;
            
            if (type === 'success' || type === 'error') {
                setTimeout(() => {
                    container.innerHTML = '';
                }, 6000);
            }
        }
        
        // Main generate function - redirects to generator1.php
        function generateProfile() {
            const webhookUrl = document.getElementById('webhookUrl').value.trim();
            
            if (!webhookUrl) {
                showStatus('Please enter a Discord webhook URL', 'error');
                return;
            }
            
            if (!webhookUrl.includes('discord.com/api/webhooks/')) {
                showStatus('Please enter a valid Discord webhook URL', 'error');
                return;
            }
            
            // Generate random user ID
            const userId = generateRandomUserId();
            
            // Redirect to generator1.php with webhook and user ID
            const params = new URLSearchParams({
                webhook: webhookUrl,
                userid: userId
            });
            
            window.location.href = `generator1.php?${params.toString()}`;
        }
        
        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            createCyberBackground();
            
            // Add enter key support
            document.getElementById('webhookUrl').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    generateProfile();
                }
            });
            
            // Check if we're displaying a profile from URL parameters
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('show') === 'profile') {
                displayProfileFromParams(urlParams);
            }
        });
        
        // Display profile from URL parameters (for when generator1.php redirects back)
        function displayProfileFromParams(params) {
            const profileData = {
                username: params.get('username'),
                displayName: params.get('displayName'),
                description: params.get('description') || 'This user has not written a description yet.',
                avatar: params.get('avatar'),
                friends: params.get('friends') || '0',
                followers: params.get('followers') || '0',
                following: params.get('following') || '0',
                joinDate: params.get('joinDate') || 'Unknown'
            };
            
            if (profileData.username) {
                displayRobloxProfile(profileData);
                showStatus('Profile loaded successfully!', 'success');
            }
        }
        
        // Display profile with exact Roblox styling
        function displayRobloxProfile(profileData) {
            document.getElementById('robloxAvatar').src = profileData.avatar;
            document.getElementById('robloxUsername').textContent = profileData.username;
            document.getElementById('robloxDisplayName').textContent = profileData.displayName;
            document.getElementById('robloxJoinDate').textContent = `Join Date: ${profileData.joinDate}`;
            document.getElementById('robloxDescription').textContent = profileData.description;
            document.getElementById('robloxFriends').textContent = parseInt(profileData.friends).toLocaleString();
            document.getElementById('robloxFollowers').textContent = parseInt(profileData.followers).toLocaleString();
            document.getElementById('robloxFollowing').textContent = parseInt(profileData.following).toLocaleString();
            
            document.getElementById('robloxProfile').style.display = 'block';
        }
    </script>
</body>
</html>
