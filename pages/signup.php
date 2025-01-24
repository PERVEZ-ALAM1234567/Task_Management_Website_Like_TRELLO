<?php
// include 'config.php';

// if ($_SERVER["REQUEST_METHOD"] == "POST") {

//     $fullname = $_POST['fullname'];
//     $email = $_POST['email'];
//     // $address = $_POST['address'];
//     $password = $_POST['password'];
//     $confirmpassword = $_POST['confirmpassword'];

// // Validate if passwords match
// if ($password !== $confirmpassword) {
//     $message = "<div class='error-message'>Passwords do not match!</div>";
// } else {
//     // Hash the password
//     $hashed_password = password_hash($password, PASSWORD_BCRYPT);
// }
//     $sql = "INSERT INTO users_sign_up (fullname, email, password) VALUES ('$fullname', '$email', '$hashed_password')";
//     if ($conn->query($sql) === TRUE) {
//         echo "success";
//     } else {
//         echo "Error: " . $sql . "<br>" . $conn->error;
//     }

//     $conn->close();
// }

include '../config.php';

$message = ""; // Initialize message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmpassword = $_POST['confirmpassword'];

    // Validate if passwords match
    if ($password !== $confirmpassword) {
        $message = "<div class='error-message'>Passwords do not match!</div>";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Insert query
        $sql = "INSERT INTO users_sign_up (fullname, email, password) VALUES ('$fullname', '$email', '$hashed_password')";

        if ($conn->query($sql) === TRUE) {
            $message = "Registration successful! Welcome, $fullname";
        } else {
            $message = "<div class='error-message'>Error: " . $conn->error . "</div>";
        }
    }
    $conn->close();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TASK MANAGEMENT</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="sign-up.css">
</head>
<body>
    <!-- HEADER STARTS HERE -->
    <header>
        <div class="logo"><i class="fas fa-tasks"></i> TASK MANAGEMENT</div>
        <button class="toggle-btn" onclick="toggleMenu()">☰</button>
        <nav class="navbar">
        <ul>
                <li><a href="../index.html">Home</a></li>
                <li><a href="about.html">About us</a></li>
                <li><a href="service.html">Services</a></li>
                <li><a href="contact.html">Contact</a></li>
            </ul> 
        </nav>
    </header> <!-- HEADER ENDS HERE -->

    <!-- Display the success or error message -->
    <?php if (!empty($message)): ?>
        <p id="submissionMessage" style="
            color: #008000; /* Darker green for better contrast */
            font-weight: bold;
            font-size: 20px;
            margin-top: 36px; /* Center-align margin for balanced appearance */
            padding: 5px;
            background-color: #f9f9f9; /* Light gray for softer contrast */
            border: 2px solid #008000; /* Adding a green border for emphasis */
            border-radius: 10px; /* Rounded corners for modern look */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.9); /* Subtle shadow for a pop-out effect */
            text-align: center; /* Center-align text inside the element */
            line-height: 1.5; /* Better readability with line spacing */
            font-family: 'Arial', sans-serif; /* Clean and professional font */
            "><?php echo $message; ?></p>
    <?php endif; ?>

    <!-- Sign up START HERE -->
    <div class="signup-container">
        <div class="form-box">
            <h2>Create Your Account</h2>
            <p>Join us to explore more!</p>

            <form action="signup.php" method="POST">
                <!-- Full Name -->
                <div class="input-group">
                    <label for="fullname">Full Name</label>
                    <input type="text" id="fullname" name="fullname" placeholder="Enter your full name" required>
                </div>
                <!-- Email -->
                <div class="input-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <!-- Password -->
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>
                <!-- Confirm Password -->
                <div class="input-group">
                    <label for="confirm-password">Confirm Password</label>
                    <input type="password" id="confirmpassword" name="confirmpassword" placeholder="Confirm your password" required>
                </div>
                <!-- Terms and Conditions -->
                <div class="input-group terms">
                    <input type="checkbox" id="terms" name="terms" required>
                    <label for="terms">I agree to the <a href="#">Terms & Conditions</a></label>
                </div>
                <!-- Buttons -->
                <div class="button-container">                  
                    <button type="reset" class="reset-btn">Reset</button>
                    <button type="submit" class="signup-btn">Sign Up</button>
                </div>
                <!-- Additional Link -->
                <p class="login-link">Already have an account? <a href="../pages/log-in.html">Log In</a></p>
            </form>
        </div>
    </div>
    <!-- Sign up END HERE -->

    

    <!-- FOOTER STARTS HERE -->
  <footer>
    <p>&copy; ALL RIGHTS ARE RESERVED, TASK MANAGEMENT PLATFORM KANBAN STYLE</p>
  </footer> <!-- FOOTER ENDS HERE -->

    <script>
        function toggleMenu() {
        const navbar = document.querySelector('.navbar');
        navbar.classList.toggle('active');
        }

        // Hide the message after 3 seconds
        window.addEventListener('DOMContentLoaded', () => {
            const messageElement = document.getElementById('submissionMessage');
            if (messageElement) {
                setTimeout(() => {
                    messageElement.style.display = 'none';
                }, 2000);
            }
        });
    </script>
</body>
</html>




