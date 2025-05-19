<?php
session_start();
include 'connection.php';  // your DB connection script

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Basic input validation
    if (empty($email) || empty($password)) {
        echo "<script>alert('Please enter email and password'); window.location.href='login.html';</script>";
        exit();
    }

    // Prepare statement to avoid SQL injection
    $stmt = $conn->prepare("SELECT email, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Assuming passwords are stored hashed - verify password
        // If plain text (not recommended), just compare directly
        // if (password_verify($password, $user['password'])) { ... }
        
        if ($password === $user['password']) {  // Use this only if passwords are plain text
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            switch ($user['role']) {
                case 'admin':
                    header("Location: admin.html?email=" . urlencode($user['email']));
                    break;
                case 'instructor':
                    header("Location: instructorDashboard.html?email=" . urlencode($user['email']));
                    break;
                case 'seller':
                    header("Location: sellerDashboard.html?email=" . urlencode($user['email']));
                    break;
                case 'learner':
                    header("Location: classroom.html?email=" . urlencode($user['email']));
                    break;
                case 'customer':
                    header("Location: customerDashboard.html?email=" . urlencode($user['email']));
                    break;
                default:
                    echo "<script>alert('Unknown user role'); window.location.href='login.html';</script>";
            }
            exit();

        } else {
            echo "<script>alert('Incorrect password'); window.location.href='login.html';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Email not found'); window.location.href='login.html';</script>";
        exit();
    }
} else {
    echo "Invalid request method.";
}
?>
