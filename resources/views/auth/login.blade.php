<!DOCTYPE html>
<html lang="en" class="default-style layout-fixed layout-navbar-fixed">
<head>
    <title>broadlive · ash harmony login</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="broadlive Hosting Platform - clean ash login" />
    <meta name="keywords" content="broadlive, login, ash theme">
    <meta name="author" content="broadlive" />
    
    <!-- Google fonts (clean) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* 🌫️ ash & neutral palette */
        :root {
            --ash-50: #f8fafc;
            --ash-100: #f1f5f9;
            --ash-200: #e2e8f0;
            --ash-300: #cbd5e1;
            --ash-400: #94a3b8;
            --ash-500: #64748b;
            --ash-600: #475569;
            --ash-700: #334155;
            --ash-800: #1e293b;
            --ash-900: #0f172a;
            --soft-pink: #f1dbe8;      /* barely there blush accent */
            --accent-ash: #8b7e8b;       /* muted taupe-ash for hover */
            --card-bg: rgba(255, 255, 255, 0.85);
            --backdrop-blur: blur(12px);
            --border-light: rgba(203, 213, 225, 0.5);
            --shadow-ash: 0 20px 35px -8px rgba(51, 65, 85, 0.15), 0 1px 3px rgba(0,0,0,0.02);
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--ash-100); 
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.2rem;
            margin: 0;
            background-image: radial-gradient(circle at 10% 20%, rgba(226, 232, 240, 0.7) 0%, transparent 30%),
                              radial-gradient(circle at 90% 70%, rgba(203, 213, 225, 0.6) 0%, transparent 35%);
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            margin: 0 auto;
        }

        /* main card – ash with subtle pink warmth */
        .login-card {
            background: var(--card-bg);
            backdrop-filter: var(--backdrop-blur);
            -webkit-backdrop-filter: var(--backdrop-blur);
            border-radius: 2rem;
            box-shadow: var(--shadow-ash);
            overflow: hidden;
            border: 1px solid var(--border-light);
            transition: all 0.25s ease;
        }

        .login-card:hover {
            box-shadow: 0 25px 40px -12px rgba(71, 85, 105, 0.25);
        }

        /* header – ash gradient (no pink dominance) */
        .card-header {
            background: linear-gradient(115deg, #e4eaf1 0%, #d6dfe9 100%);
            padding: 2rem 1.5rem 1.8rem;
            text-align: center;
            color: var(--ash-800);
            border-bottom: 1px solid rgba(255,255,255,0.6);
        }

        .logo-container {
            width: 92px;
            height: 92px;
            margin: 0 auto 1rem;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 18px var(--ash-300);
            border: 2px solid white;
        }

        .logo-container img {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            object-fit: cover;
            filter: grayscale(10%) brightness(1.02);
        }

        .card-header h1 {
            font-size: 1.9rem;
            font-weight: 600;
            letter-spacing: -0.02em;
            margin-bottom: 0.2rem;
            color: var(--ash-800);
        }

        .card-header p {
            font-size: 0.9rem;
            color: var(--ash-600);
            font-weight: 400;
        }

        .card-body {
            padding: 2rem 1.8rem;
        }

        /* form elements – clean ash */
        .form-group {
            margin-bottom: 1.6rem;
            position: relative;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--ash-700);
            font-size: 0.9rem;
            letter-spacing: -0.01em;
        }

        .input-group {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--ash-500);
            font-size: 1.1rem;
            z-index: 2;
            transition: color 0.15s;
        }

        .form-control {
            width: 100%;
            padding: 0.9rem 1rem 0.9rem 2.8rem;
            border: 1.5px solid var(--ash-200);
            border-radius: 1.2rem;
            font-size: 1rem;
            font-weight: 400;
            background: white;
            transition: all 0.2s;
            color: var(--ash-800);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--ash-400);
            background: white;
            box-shadow: 0 4px 12px rgba(148, 163, 184, 0.15);
        }

        .form-control::placeholder {
            color: var(--ash-400);
            font-weight: 300;
            font-size: 0.95rem;
        }

        .password-toggle {
            position: absolute;
            right: 1.2rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--ash-500);
            cursor: pointer;
            z-index: 3;
            font-size: 1.1rem;
            transition: color 0.15s;
        }

        .password-toggle:hover {
            color: var(--ash-700);
        }

        .options-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 1.2rem 0 2rem;
            font-size: 0.9rem;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            color: var(--ash-600);
        }

        .remember-me input[type="checkbox"] {
            width: 1.1rem;
            height: 1.1rem;
            accent-color: var(--ash-600);
            border-radius: 0.3rem;
        }

        .forgot-password {
            color: var(--ash-600);
            text-decoration: none;
            font-weight: 500;
            border-bottom: 1px dashed var(--ash-300);
        }

        .forgot-password:hover {
            color: var(--ash-800);
            border-bottom-color: var(--ash-600);
        }

        /* ash login button – no pink */
        .login-btn {
            display: block;
            width: 100%;
            padding: 0.9rem;
            background: var(--ash-700);
            color: white;
            border: none;
            border-radius: 2rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s, box-shadow 0.2s, transform 0.1s;
            box-shadow: 0 6px 14px rgba(71, 85, 105, 0.2);
            letter-spacing: 0.3px;
        }

        .login-btn:hover {
            background: var(--ash-800);
            box-shadow: 0 10px 18px rgba(51, 65, 85, 0.25);
        }

        .login-btn:active {
            transform: scale(0.98);
            background: var(--ash-900);
        }

        .login-btn i {
            margin-left: 0.5rem;
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 2rem 0 1.5rem;
            color: var(--ash-500);
            font-size: 0.8rem;
            font-weight: 400;
        }

        .divider::before,
        .divider::after {
            content: "";
            flex: 1;
            height: 1px;
            background: var(--ash-200);
        }

        .divider::before {
            margin-right: 1rem;
        }

        .divider::after {
            margin-left: 1rem;
        }

        /* social buttons – ash circle */
        .social-login {
            display: flex;
            justify-content: center;
            gap: 1.2rem;
            margin-bottom: 1.8rem;
        }

        .social-btn {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
            color: var(--ash-600);
            text-decoration: none;
            font-size: 1.3rem;
            border: 1px solid var(--ash-200);
            transition: all 0.2s;
            box-shadow: 0 4px 10px rgba(0,0,0,0.02);
        }

        .social-btn:hover {
            background: var(--ash-100);
            color: var(--ash-800);
            border-color: var(--ash-400);
            transform: translateY(-3px);
            box-shadow: 0 10px 16px var(--ash-300);
        }

        .signup-link {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.9rem;
            color: var(--ash-600);
        }

        .signup-link a {
            color: var(--ash-700);
            text-decoration: none;
            font-weight: 600;
            border-bottom: 1px solid var(--ash-300);
        }

        .signup-link a:hover {
            color: var(--ash-900);
            border-bottom-color: var(--ash-700);
        }

        .footer {
            text-align: center;
            margin-top: 1.8rem;
            color: var(--ash-500);
            font-size: 0.75rem;
            font-weight: 400;
        }

        /* preloader minimal */
        .page-loader {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: var(--ash-50);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 999;
            transition: opacity 0.3s;
        }
        .page-loader .bg-primary {
            width: 40px;
            height: 40px;
            border: 3px solid var(--ash-200);
            border-top-color: var(--ash-600);
            border-radius: 50%;
            animation: spin 0.8s infinite linear;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* fully mobile tuned */
        @media (max-width: 480px) {
            body { padding: 0.8rem; }
            .card-body { padding: 1.8rem 1.2rem; }
            .card-header h1 { font-size: 1.7rem; }
            .logo-container { width: 80px; height: 80px; }
            .logo-container img { width: 62px; height: 62px; }
            .options-row { flex-direction: column; align-items: flex-start; gap: 0.7rem; }
            .forgot-password { align-self: flex-end; }
            .social-btn { width: 44px; height: 44px; font-size: 1.2rem; }
        }

        /* tiny extra small */
        @media (max-width: 360px) {
            .login-card { border-radius: 1.5rem; }
            .card-header { padding: 1.5rem 1rem; }
            .card-body { padding: 1.5rem 1rem; }
            .form-control { padding: 0.8rem 1rem 0.8rem 2.5rem; }
        }

        /* fade-in */
        .form-group, .options-row, .login-btn, .divider, .social-login, .signup-link {
            animation: fadeUp 0.4s ease-out forwards;
            opacity: 0;
        }
        @keyframes fadeUp {
            0% { opacity: 0; transform: translateY(8px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .form-group:nth-child(1) { animation-delay: 0.05s; }
        .form-group:nth-child(2) { animation-delay: 0.1s; }
        .options-row { animation-delay: 0.15s; }
        .login-btn { animation-delay: 0.2s; }
        .divider { animation-delay: 0.25s; }
        .social-login { animation-delay: 0.3s; }
        .signup-link { animation-delay: 0.35s; }
    </style>
</head>

<body>
    <!-- minimal preloader (ash) -->
    <div class="page-loader">
        <div class="bg-primary"></div>
    </div>

    <div class="login-container">
        <div class="login-card">
            <div class="card-header">
                <div class="logo-container">
                    <!-- logo stays subtle, you can replace with any neutral png -->
                    <img src="https://broadlive.xyz/store/profile/default.png" alt="broadlive mark">
                </div>
                <h1>broadlive</h1>
                <p>sign in · ash edition</p>
            </div>
            
            <div class="card-body">
                <form action="{{ route('login') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Email address</label>
                        <div class="input-group">
                            <i class="input-icon fa-regular fa-envelope"></i>
                            <input type="email" name="email" class="form-control" placeholder="e.g. name@domain.com" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <div class="input-group">
                            <i class="input-icon fa-regular fa-lock"></i>
                            <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required>
                            <i class="password-toggle fa-regular fa-eye" id="togglePassword"></i>
                        </div>
                    </div>
                    
                    <div class="options-row">
                        <div class="remember-me">
                            <input type="checkbox" id="remember" name="remember">
                            <label for="remember">Stay signed in</label>
                        </div>
                        <a href="#" class="forgot-password">forgot?</a>
                    </div>
                    
                    <button type="submit" class="login-btn">
                        Log in <i class="fa-regular fa-arrow-right-to-bracket"></i>
                    </button>
                </form>
                
                <div class="divider">or</div>
                
                <div class="social-login">
                    <a href="#" class="social-btn" aria-label="google"><i class="fa-brands fa-google"></i></a>
                    <a href="#" class="social-btn" aria-label="github"><i class="fa-brands fa-github"></i></a>
                    <a href="#" class="social-btn" aria-label="apple"><i class="fa-brands fa-apple"></i></a>
                </div>
                
                <div class="signup-link">
                    new here? <a href="#">create account</a>
                </div>
            </div>
        </div>
        
        <div class="footer">
            © 2025 broadlive · ash harmony · all cool
        </div>
    </div>

    <script>
        (function() {
            // toggle password visibility
            const togglePw = document.getElementById('togglePassword');
            const pwInput = document.getElementById('password');
            if (togglePw && pwInput) {
                togglePw.addEventListener('click', function() {
                    const type = pwInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    pwInput.setAttribute('type', type);
                    this.classList.toggle('fa-eye');
                    this.classList.toggle('fa-eye-slash');
                });
            }

            // gentle preloader hide
            window.addEventListener('load', function() {
                setTimeout(() => {
                    const loader = document.querySelector('.page-loader');
                    if (loader) loader.style.display = 'none';
                }, 400);
            });

            // very light front-end validation (no intrusive alert)
            document.querySelector('form')?.addEventListener('submit', function(e) {
                const email = this.querySelector('input[type="email"]')?.value.trim();
                const pass = this.querySelector('input[type="password"]')?.value.trim();
                if (!email || !pass) {
                    e.preventDefault();
                    // you could show a small toast, but we keep it subtle
                    alert('⌨️ both fields required (email & password)');
                }
            });
        })();
    </script>
</body>
</html>