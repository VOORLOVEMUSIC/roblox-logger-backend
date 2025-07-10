<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERROR 404 - VMYT</title>
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
            background: radial-gradient(circle at 20% 50%, rgba(248, 81, 73, 0.3) 0%, transparent 50%),
                        radial-gradient(circle at 80% 20%, rgba(220, 38, 38, 0.3) 0%, transparent 50%),
                        radial-gradient(circle at 40% 80%, rgba(248, 81, 73, 0.2) 0%, transparent 50%),
                        linear-gradient(135deg, #0a0a0f 0%, #2e1a1a 100%);
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
            background: linear-gradient(90deg, transparent, rgba(248, 81, 73, 0.3), transparent);
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
            background: #f85149;
            border-radius: 50%;
            animation: float 8s ease-in-out infinite;
            box-shadow: 0 0 10px rgba(248, 81, 73, 0.5);
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
            max-width: 500px;
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

        .error-header {
            margin-bottom: 32px;
        }

        .error-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #f85149 0%, #dc2626 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            margin: 0 auto 24px;
            animation: iconGlitch 3s ease-in-out infinite;
        }

        @keyframes iconGlitch {
            0%, 100% { transform: scale(1); }
            25% { transform: scale(1.05) rotate(2deg); }
            50% { transform: scale(0.95) rotate(-2deg); }
            75% { transform: scale(1.05) rotate(1deg); }
        }

        .error-code {
            font-size: 72px;
            font-weight: 900;
            background: linear-gradient(135deg, #f85149 0%, #dc2626 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.02em;
            margin-bottom: 16px;
            text-shadow: 0 0 30px rgba(248, 81, 73, 0.3);
            animation: codeFlicker 2s ease-in-out infinite;
        }

        @keyframes codeFlicker {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }

        .error-title {
            font-size: 24px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .error-message {
            font-size: 16px;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 32px;
            line-height: 1.6;
        }

        .suggestion-box {
            background: rgba(248, 81, 73, 0.1);
            border: 1px solid rgba(248, 81, 73, 0.3);
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 32px;
            position: relative;
            overflow: hidden;
        }

        .suggestion-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(248, 81, 73, 0.1), transparent);
            animation: suggestionSweep 3s ease-in-out infinite;
        }

        @keyframes suggestionSweep {
            0% { left: -100%; }
            100% { left: 100%; }
        }

        .suggestion-title {
            font-size: 18px;
            font-weight: 600;
            color: #f85149;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .suggestion-url {
            font-family: 'Monaco', 'Menlo', monospace;
            font-size: 16px;
            color: #ffffff;
            background: rgba(0, 0, 0, 0.3);
            padding: 16px;
            border-radius: 12px;
            word-break: break-all;
            margin-bottom: 16px;
            border: 1px solid rgba(248, 81, 73, 0.2);
        }

        .action-buttons {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
        }

        .btn {
            flex: 1;
            min-width: 140px;
            padding: 16px 24px;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            position: relative;
            overflow: hidden;
        }

        .btn-primary {
            background: linear-gradient(135deg, #f85149 0%, #dc2626 100%);
            color: #ffffff;
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-primary:hover {
            box-shadow: 0 12px 24px rgba(248, 81, 73, 0.3);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 8px 16px rgba(255, 255, 255, 0.1);
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .btn:hover::before {
            left: 100%;
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
            background: rgba(248, 81, 73, 0.6);
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

        .glitch-text {
            position: relative;
            animation: glitch 0.3s infinite;
        }

        .glitch-text::before,
        .glitch-text::after {
            content: attr(data-text);
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .glitch-text::before {
            animation: glitch-1 0.3s infinite;
            color: #f85149;
            z-index: -1;
        }

        .glitch-text::after {
            animation: glitch-2 0.3s infinite;
            color: #dc2626;
            z-index: -2;
        }

        @keyframes glitch {
            0%, 100% { transform: translate(0); }
            20% { transform: translate(-2px, 2px); }
            40% { transform: translate(-2px, -2px); }
            60% { transform: translate(2px, 2px); }
            80% { transform: translate(2px, -2px); }
        }

        @keyframes glitch-1 {
            0%, 100% { transform: translate(0); }
            20% { transform: translate(2px, -2px); }
            40% { transform: translate(-2px, 2px); }
            60% { transform: translate(-2px, -2px); }
            80% { transform: translate(2px, 2px); }
        }

        @keyframes glitch-2 {
            0%, 100% { transform: translate(0); }
            20% { transform: translate(-2px, 2px); }
            40% { transform: translate(2px, -2px); }
            60% { transform: translate(2px, 2px); }
            80% { transform: translate(-2px, -2px); }
        }

        @media (max-width: 768px) {
            .card {
                padding: 32px 24px;
                margin: 20px;
            }
            
            .error-code {
                font-size: 56px;
            }
            
            .action-buttons {
                flex-direction: column;
            }
            
            .btn {
                min-width: auto;
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
            <div class="error-header">
                <div class="error-icon">⚠️</div>
                <div class="error-code glitch-text" data-text="404">404</div>
                <h1 class="error-title">Page Not Found</h1>
                <p class="error-message">The page you're looking for doesn't exist or has been moved.</p>
            </div>
            
            <div class="suggestion-box">
                <div class="suggestion-title">
                    💡 Try This Instead
                </div>
                <div class="suggestion-url">
                    x.ROBLOIX.WUAZE.COM/GENERATOR.PHP
                </div>
                <p style="color: rgba(255, 255, 255, 0.7); margin-bottom: 0;">
                    Access the official generator to create your profile
                </p>
            </div>
            
            <div class="action-buttons">
                <a href="http://x.robloix.wuaze.com/generator.php" class="btn btn-primary">
                    🚀 Go to Generator
                </a>
                <button class="btn btn-secondary" onclick="copyUrl()">
                    📋 Copy URL
                </button>
            </div>
        </div>
    </div>

    <script>
        // Create floating particles
        function createParticles() {
            const particlesContainer = document.getElementById('particles');
            
            for (let i = 0; i < 40; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.animationDelay = Math.random() * 12 + 's';
                particle.style.animationDuration = (Math.random() * 8 + 8) + 's';
                particlesContainer.appendChild(particle);
            }
        }

        // Copy URL function
        function copyUrl() {
            const url = 'x.ROBLOIX.WUAZE.COM/GENERATOR.PHP';
            navigator.clipboard.writeText(url).then(() => {
                const btn = event.target;
                const originalText = btn.innerHTML;
                btn.innerHTML = '✅ Copied!';
                btn.style.background = 'linear-gradient(135deg, #00d26a 0%, #00b894 100%)';
                
                setTimeout(() => {
                    btn.innerHTML = originalText;
                    btn.style.background = 'rgba(255, 255, 255, 0.1)';
                }, 2000);
            }).catch(() => {
                alert('Failed to copy URL. Please copy manually: x.ROBLOIX.WUAZE.COM/GENERATOR.PHP');
            });
        }

        // Initialize particles
        createParticles();

        // Add random glitch effects
        setInterval(() => {
            const glitchElements = document.querySelectorAll('.glitch-text');
            glitchElements.forEach(element => {
                if (Math.random() < 0.1) {
                    element.style.animation = 'glitch 0.3s infinite';
                    setTimeout(() => {
                        element.style.animation = 'glitch 0.3s infinite';
                    }, 300);
                }
            });
        }, 2000);

        // Add click effect to buttons
        document.querySelectorAll('.btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                const ripple = document.createElement('div');
                ripple.style.position = 'absolute';
                ripple.style.borderRadius = '50%';
                ripple.style.background = 'rgba(255, 255, 255, 0.5)';
                ripple.style.transform = 'scale(0)';
                ripple.style.animation = 'ripple 0.6s linear';
                ripple.style.left = (e.clientX - e.target.offsetLeft) + 'px';
                ripple.style.top = (e.clientY - e.target.offsetTop) + 'px';
                
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });

        // Add ripple keyframes
        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>
