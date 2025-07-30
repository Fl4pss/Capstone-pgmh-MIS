<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$host = 'localhost'; 
$dbname = 'u614894444_pgmhdb'; 
$username = 'u614894444_pdmh'; 
$password = 'P0531d0n321';  

$db = new mysqli($host, $username, $password, $dbname);

// Check if connection is successful
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Fetch form data
$email = $_POST['loginEmail'] ?? '';
$password = $_POST['loginPassword'] ?? '';

// Validate required fields
if (!$email || !$password) {
    header("Location: index.html?error=missing_fields");
    exit();
}

// Prepare and execute the SQL query to find the user in the 'users' table
$stmt = $db->prepare("SELECT * FROM users WHERE email = ? AND user_type = 'resident'");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Check for resident login
if ($result->num_rows > 0) {
    $resident = $result->fetch_assoc();

    if (password_verify($password, $resident['password'])) {
        $_SESSION['user_id'] = $resident['id'];
        $_SESSION['role'] = 'resident';
        $_SESSION['full_name'] = $resident['full_name'];
        $_SESSION['unit_number'] = $resident['unit_number'];
        $_SESSION['email'] = $resident['email'];

        header("Location: userdashboard/resident_dashboard.php");
        exit();
    } else {
        // Redirect with error parameter if password is incorrect
        header("Location: index.html?error=invalid_credentials");
        exit();
    }
}

// Prepare and execute the SQL query to find the user in the 'admins' table
$stmt = $db->prepare("SELECT * FROM admins WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Check for admin or staff login
if ($result->num_rows > 0) {
    $admin = $result->fetch_assoc();

    if (isset($admin['access_role']) && password_verify($password, $admin['password'])) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_email'] = $admin['email'];
        $_SESSION['full_name'] = $admin['full_name'];
        $_SESSION['access_role'] = $admin['access_role'];
        $_SESSION['email'] = $admin['email'];

        if ($admin['access_role'] === 'admin') {
            header("Location: admin/admin_dashboard.php");
        } elseif ($admin['access_role'] === 'staff') {
            header("Location: admin/staff/staff_dashboard.php");
        }
        exit();
    } else {
        // Redirect with error parameter if password is incorrect
        header("Location: index.html?error=invalid_credentials");
        exit();
    }
}

// Redirect to login if credentials do not match
header("Location: index.html?error=invalid_credentials");
exit();

// Close the statement and connection
$stmt->close();
$db->close();
?>
