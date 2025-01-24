<?php
// // Include database connection file
// include('../config.php');

// // Check if form is submitted
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     // Get form data
//     $name = $_POST['name'];
//     $email = $_POST['email'];
//     $subject = $_POST['subject'];
//     $message = $_POST['message'];

//     // Prepare an SQL query to insert data
//     $sql = "INSERT INTO contact_feedback (name, email, subject, message) VALUES (?, ?, ?, ?)";
    
//     // Prepare statement
//     if ($stmt = $conn->prepare($sql)) {
//         // Bind parameters
//         $stmt->bind_param("ssss", $name, $email, $subject, $message);

//         // Execute the query
//         if ($stmt->execute()) {
//             echo "SUCCESSFULLY SUBMITTED !!!";
//         } else {
//             echo "Error: " . $stmt->error;
//         }

//         // Close statement
//         $stmt->close();
//     }

//     // Close connection
//     $conn->close();
// }
?>




<?php
// Include the database connection file
include('../config.php');

// Initialize message variable
$message = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $user_message = $_POST['message'];

    // Prepare an SQL query to insert data into the database
    $sql = "INSERT INTO contact (name, email, subject, message) VALUES (?, ?, ?, ?)";

    // Prepare statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters
        $stmt->bind_param("ssss", $name, $email, $subject, $user_message);

        // Execute the query
        if ($stmt->execute()) {
            $message = "SUCCESSFULLY SUBMITTED!!!"; // Set success message
        } else {
            $message = "Error: " . $stmt->error; // Set error message if query fails
        }

        // Close statement
        $stmt->close();
    } else {
        $message = "Error preparing the statement.";
    }
    // Close connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="contact.css">
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
    
    <!-- CONTACT FORM STARTS HERE -->
    <div class="contact-form-container">
        <h2>Contact Us</h2>

        <form action="" method="POST" class="contact-form">
            <label for="name">Your Name:</label>
            <input type="text" id="name" name="name" placeholder="Enter your name" required>
            
            <label for="email">Your Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>
            
            <label for="subject">Subject:</label>
            <input type="text" id="subject" name="subject" placeholder="Enter subject" required>
            
            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="5" placeholder="Write your message here..." required></textarea>
            
            <button type="submit">Send Message</button>
        </form>
    </div>
    <!-- CONTACT FORM ENDS HERE -->

    <!-- Display the success or error message -->
    <?php if (!empty($message)): ?>
        <p id="submissionMessage" style="
            color: #008000; /* Darker green for better contrast */
            font-weight: bold;
            font-size: 20px;
            margin: 5px auto; /* Center-align margin for balanced appearance */
            padding: 5px;
            background-color: #f9f9f9; /* Light gray for softer contrast */
            border: 2px solid #008000; /* Adding a green border for emphasis */
            border-radius: 10px; /* Rounded corners for modern look */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow for a pop-out effect */
            text-align: center; /* Center-align text inside the element */
            line-height: 1.5; /* Better readability with line spacing */
            font-family: 'Arial', sans-serif; /* Clean and professional font */
            "><?php echo $message; ?></p>
    <?php endif; ?>

    <!-- FOOTER STARTS HERE -->
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
