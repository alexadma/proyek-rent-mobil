<!DOCTYPE html>
<html>

<head>
    <title>Menu Login</title>
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <!-- link icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body>
<div class="login-container">
    <h2>Rental Mobil</h2>
    <h2>DJVR</h2>
    <form action="{{ route('login') }}" method="post">
    @csrf
    <div class="login-form">
        <!-- Added the Font Awesome icon for the username -->
        <div class="input-container">
            <i class="fa-regular fa-user"></i>
            <input type="text" placeholder="Username" name="username" id="username">
        </div>

        <!-- Added the Font Awesome icon for the password -->
        <div class="input-container">
            <i class="fa-solid fa-lock"></i>
            <input type="password" placeholder="Password">
        </div>
                
                <button type="submit" class="signup-button">Login</button>
    </div>
    </form>
    
    <div class="additional-links">
        <a href="/register">Sign Up</a>
    </div>
</div>
</body>

</html>
