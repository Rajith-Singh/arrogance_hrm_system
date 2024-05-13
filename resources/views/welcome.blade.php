<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Our HR Management System</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }
        .welcome-container {
            text-align: center;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            width: 90%;
            max-width: 600px;
        }
        h1 {
            color: #333;
        }
        .navigation {
            margin-top: 20px;
        }
        a {
            display: inline-block;
            background-color: #ec1f27;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s, color 0.3s;
        }
        a:hover, a:focus-visible {
            background-color: #bf1a21;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="welcome-container">
        <h1>Welcome to Our HR Management System</h1>
        <p>Your one-stop solution for managing human resources effectively.</p>

        @if (Route::has('login'))
            <div class="navigation">
                @auth
                    <a href="{{ url('/home') }}">Dashboard</a>
                @else
                    <a href="{{ route('login') }}">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}">Register</a>
                    @endif
                @endauth
            </div>
        @endif
    </div>
</body>
</html>
