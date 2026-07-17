<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Access Verification - {{ $gameName ?? 'Game' }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            max-width: 500px;
            width: 100%;
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }

        .header h1 {
            font-size: 28px;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .header p {
            font-size: 14px;
            opacity: 0.9;
        }

        .content {
            padding: 40px 30px;
        }

        .status-box {
            background: #f5f7fa;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 30px;
            border-left: 4px solid #667eea;
        }

        .status-box.success {
            border-left-color: #10b981;
            background: #f0fdf4;
        }

        .status-box.warning {
            border-left-color: #f59e0b;
            background: #fffbf0;
        }

        .status-box.error {
            border-left-color: #ef4444;
            background: #fef2f2;
        }

        .status-icon {
            display: inline-block;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            text-align: center;
            line-height: 20px;
            font-size: 12px;
            font-weight: bold;
            margin-right: 10px;
            color: white;
        }

        .status-icon.success {
            background: #10b981;
        }

        .status-icon.warning {
            background: #f59e0b;
        }

        .status-icon.error {
            background: #ef4444;
        }

        .status-text {
            display: inline-block;
            font-size: 14px;
            font-weight: 500;
            color: #1f2937;
        }

        .status-box.success .status-text {
            color: #065f46;
        }

        .status-box.warning .status-text {
            color: #78350f;
        }

        .status-box.error .status-text {
            color: #7f1d1d;
        }

        .info-text {
            font-size: 13px;
            color: #6b7280;
            margin-top: 15px;
            line-height: 1.6;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 8px;
        }

        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
            font-family: 'Courier New', monospace;
        }

        .form-group input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-group input::placeholder {
            color: #9ca3af;
        }

        .form-group.hidden {
            display: none;
        }

        .button-group {
            display: flex;
            gap: 12px;
        }

        .btn {
            flex: 1;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            text-align: center;
            display: inline-block;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-secondary {
            background: #e5e7eb;
            color: #1f2937;
        }

        .btn-secondary:hover {
            background: #d1d5db;
        }

        .error-message {
            background: #fef2f2;
            border-left: 4px solid #ef4444;
            color: #7f1d1d;
            padding: 12px 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 13px;
        }

        .success-message {
            background: #f0fdf4;
            border-left: 4px solid #10b981;
            color: #065f46;
            padding: 12px 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 13px;
        }

        .footer-text {
            text-align: center;
            font-size: 12px;
            color: #9ca3af;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
        }

        .divider {
            text-align: center;
            margin: 30px 0;
            color: #d1d5db;
            font-size: 14px;
        }

        .divider::before,
        .divider::after {
            content: '';
            display: inline-block;
            width: 40%;
            height: 1px;
            background: #d1d5db;
            vertical-align: middle;
            margin: 0 5px;
        }

        @media (max-width: 480px) {
            .header {
                padding: 30px 20px;
            }

            .header h1 {
                font-size: 24px;
            }

            .content {
                padding: 30px 20px;
            }

            .button-group {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>ðŸŽ® {{ $gameName }}</h1>
            <p>Game Access Verification</p>
        </div>

        <div class="content">
            @if ($errors->any())
                <div class="error-message">
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- Package Status --}}
            <div class="status-box @if($packageDetected && $packageAllowed) success @elseif($packageDetected) warning @else error @endif">
                <span class="status-icon @if($packageDetected && $packageAllowed) success @elseif($packageDetected) warning @else error @endif">
                    @if($packageDetected && $packageAllowed)
                        âœ“
                    @else
                        !
                    @endif
                </span>
                <span class="status-text">
                    @if($packageDetected && $packageAllowed)
                        App Recognized - Access Granted
                    @elseif($packageDetected)
                        App Detected: {{ $packageDetected }}
                    @else
                        App Package Not Detected
                    @endif
                </span>

                @if(!($packageDetected && $packageAllowed))
                    <div class="info-text">
                        @if($packageDetected)
                            Your app ({{ $packageDetected }}) is not on the whitelist. Developer authentication required.
                        @else
                            Could not detect your app package. Developer authentication required.
                        @endif
                    </div>
                @else
                    <div class="info-text">
                        Your app is recognized and has been granted access. Proceeding to game...
                    </div>
                @endif
            </div>

            {{-- Auto-redirect if already verified --}}
            @if($packageDetected && $packageAllowed)
                <script>
                    // If package is already allowed, no password needed
                    // Just reload to trigger access grant
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                </script>
            @else
                {{-- Password Form --}}
                <div @if($packageDetected && $packageAllowed) class="hidden" @endif>
                    <div class="divider">Developer Access</div>

                    <form method="POST" action="{{ route('game-final.app-authenticate', ['gameCode' => $gameCode]) }}">
                        @csrf

                        <div class="form-group">
                            <label for="password">Developer Password</label>
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                placeholder="Enter developer password"
                                autocomplete="off"
                                required
                                value="{{ old('password') }}"
                            >
                            @if ($errors->has('password'))
                                <div class="error-message" style="margin-top: 8px;">
                                    {{ $errors->first('password') }}
                                </div>
                            @endif
                        </div>

                        <div class="button-group">
                            <button type="submit" class="btn btn-primary">
                                Verify & Play
                            </button>
                        </div>
                    </form>
                </div>
            @endif

            <div class="footer-text">
                Game Code: <strong>{{ $gameCode }}</strong>
                <br>
                All connections are secure and verified.
            </div>
        </div>
    </div>
</body>
</html>

