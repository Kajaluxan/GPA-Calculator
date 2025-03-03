<!DOCTYPE html>
<html lang="en">

<head>
    <title>GPA TRACKER</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <!-- Sign In Form -->
        <div class="form-box" id="signin">
            <form method="post" action="register.php"> <!-- Fixed action URL for proper sign-in logic -->
                <h2>Sign In</h2>
                <div>
                    <label for="Email">Email</label>
                    <input type="email" id="Email" name="Email" required>
                </div>
                <div>
                    <label for="Password">Password</label>
                    <input type="password" id="Password" name="Password" required> <!-- Fixed to type "password" -->
                </div>
                <div class="link">
                    <a href="#">Forgot password?</a>
                </div>
                <div>
                    <button type="submit" id="SignInButton" name="SignInButton" >Sign in</button> <!-- Added type="submit" for clarity -->
                </div>
                <p>Don't have an account? <a href="#" id="showSignUp">Sign up</a></p>
            </form>
        </div>

        <!-- Sign Up Form -->
        <div class="form-box" id="signup" style="display: none;">
            <form method="post" action="register.php" id="signUpForm">
                <h2>Sign Up</h2>
                <div>
                    <label for="FirstName">First Name</label>
                    <input type="text" id="FirstName" name="FirstName" required>
                </div>
                <div>
                    <label for="LastName">Last Name</label>
                    <input type="text" id="LastName" name="LastName" required>
                </div>
                <div>
                    <label for="EmailSignUp">Email</label>
                    <input type="email" id="Email" name="Email" required>
                </div>
                <div>
                    <label for="PasswordSignUp">Password</label>
                    <input type="password" id="Password" name="Password" required>
                </div>
                <button type="submit" id="SignUpButton" name="SignUpButton">Sign up</button>
                <p>Already have an account? <a href="#" id="showSignIn">Sign in</a></p>
            </form>
        </div>

        <div id="popup" class="popup">Successfully Signed Up!</div>
    </div>

    <script src="script.js"></script>
</body>

</html>
