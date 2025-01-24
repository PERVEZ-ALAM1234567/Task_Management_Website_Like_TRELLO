<?php
// Start the session to manage user login session
session_start();

// Include the database connection file
include('../config.php'); // Ensure this file correctly connects to your database

// if ($_SERVER["REQUEST_METHOD"] === "POST") {
//     // Get user input from the login form
//     $fullname = $_POST['fullname']; 
//     $email = $_POST['email']; 
//     $password = $_POST['password']; 

//     // SQL query to check if the user exists in the database
//     $sql = "SELECT * FROM users_sign_up WHERE email = ?";
//     $stmt = $conn->prepare($sql); // Prepare statement to avoid SQL injection
//     $stmt->bind_param("s", $email); // Bind the email parameter to the query
//     $stmt->execute(); // Execute the query
//     $result = $stmt->get_result(); // Get the result of the query

//     // Check if the user exists
//     if ($result->num_rows > 0) {
//         $user = $result->fetch_assoc(); // Fetch the user's data from the database

//         // Verify the password (assuming passwords are stored hashed)
//         if (password_verify($password, $user['password'])) {
//             // If password is correct, start a session and log the user in
//             $_SESSION['user_id'] = $user['id'];    // Store user ID in session
//             $_SESSION['user_name'] = $user['fullname']; // Assuming `name` column exists in your table
//             $_SESSION['user_email'] = $user['email'];  // Store email in session

//             // Redirect to the dashboard page
//             header("Location: dashboard.php"); // Redirect to a protected page (dashboard)
//             exit(); // Stop further script execution
//         } else {
//             // header("Location: log-in.html");
//             echo "Invalid password"; // Incorrect password
//         }
//     } else {
//         echo "No user found with this email"; // No user with the provided email
//     }

//     $stmt->close();   // Close the prepared statement
//     $conn->close();   // Close the database connection
// }


// Start the session to manage user login session
// session_start();

// Include the database connection file
// include('config.php'); // Ensure this file correctly connects to your database

// Variable to store messages
$message = "";
$messageType = ""; // success or error

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get user input from the login form
    $fullname = $_POST['fullname']; 
    $email = $_POST['email']; 
    $password = $_POST['password']; 

    // SQL query to check if the user exists in the database
    $sql = "SELECT * FROM users_sign_up WHERE email = ?";
    $stmt = $conn->prepare($sql); // Prepare statement to avoid SQL injection
    $stmt->bind_param("s", $email); // Bind the email parameter to the query
    $stmt->execute(); // Execute the query
    $result = $stmt->get_result(); // Get the result of the query

    // Check if the user exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc(); // Fetch the user's data from the database

        // Verify the password (assuming passwords are stored hashed)
        if (password_verify($password, $user['password'])) {
            // If password is correct, start a session and log the user in
            $_SESSION['user_id'] = $user['id'];    // Store user ID in session
            $_SESSION['user_name'] = $user['fullname']; // Assuming `name` column exists in your table
            $_SESSION['user_email'] = $user['email'];  // Store email in session

            // Set success message
            $message = "Login successful! Redirecting to your main content.....";
            $messageType = "success";

            // Redirect after 3 seconds
            echo "<script>
                setTimeout(function() {
                    window.location.href = 'dashboard.php';
                }, 3000);
            </script>";
        } else {
            // Incorrect password
            $message = "Invalid password. Please try again.";
            $messageType = "error";
        }
    } else {
        $message = "No user found with this email. Please sign up.";
        $messageType = "error";
    }

    $stmt->close();   // Close the prepared statement
    $conn->close();   // Close the database connection
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UNIVERSITY</title>
    <link rel="stylesheet" href="log-in.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

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

    <div class="login-container">
        <div class="login-box">
            <h2>Welcome Back!</h2>
            <p>Log in to access your account</p>
            <form action="login.php" method="POST">
                <div class="input-group">
                    <label for="fullname">Full Name</label>
                    <input type="text" id="fullname" name="fullname" placeholder="Name" required>
                </div>
                <div class="input-group">
                    <label for="email">Email Address</label>
                    <input type="email" name="email" placeholder="Email Address" required>
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <div class="button-container">
                    <button type="reset" class="reset-btn">Reset</button>
                    <button type="submit" class="login-btn">Log In</button>
                </div>
                <!-- <p class="signup-link">Don't have an account? <a href="../pages/sign-up.html">Sign Up</a></p> -->
                <?php if (isset($_SESSION['user_id'])): ?>
                <p>Hello, <?php echo htmlspecialchars($_SESSION['user_name']); ?>! 
                
                    <a href="log-out.php">Log Out</a>
                </p>
                <?php else: ?>
                <p class="signup-link">Don't have an account? <a href="../pages/sign-up.html">Sign Up</a></p>                
                <?php endif; ?>
            </form>
        </div>
    </div>

    <style>
        /* Message styles */
        .message {
            width: 100%;
            padding: 15px;
            margin: 20px auto;
            border-radius: 5px;
            text-align: center;
            font-size: 18px;
            display: none; /* Initially hidden */
        }
        .message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        @keyframes fadeInOut {
            0% { opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { opacity: 0; }
        }
        .message.show {
            display: block;
            animation: fadeInOut 2s ease-in-out;
        }
    </style>
    </head>
        <!-- Message display -->
        <?php if ($message): ?>
            <div class="message <?php echo $messageType; ?> show">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>


    <!-- FOOTER STARTS HERE -->
  <footer>
    <p>&copy; ALL RIGHTS ARE RESERVED, TASK MANAGEMENT PLATFORM KANBAN STYLE</p>
  </footer> <!-- FOOTER ENDS HERE -->

    <script>
        function toggleMenu() {
        const navbar = document.querySelector('.navbar');
        navbar.classList.toggle('active');
        }
    </script>
</body>
</html>

    