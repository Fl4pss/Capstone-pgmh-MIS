<?php
// Check if a session already exists before starting one
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Database connection
$host = 'localhost';  
$dbname = 'residents_ticket'; 
$username = 'root';  
$password = '';  

// Create the connection
$db = new mysqli($host, $username, $password, $dbname);

// Check if connection is successful
if ($db->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Connection failed: ' . $db->connect_error]);
    exit();
}

// Fetch form data
$email = $_POST['adminEmail'] ?? '';
$password = $_POST['adminPassword'] ?? '';

// Validate required fields
if (!$email || !$password) {
    echo json_encode(['status' => 'error', 'message' => 'Please fill in all required fields.']);
    exit();
}

// Prepare and execute the SQL query to find the admin
$stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['status' => 'error', 'message' => 'Login failed: Invalid credentials.']);
    exit();
}

// Fetch the admin data
$admin = $result->fetch_assoc();

// Verify the password
if (!password_verify($password, $admin['password'])) {
    echo json_encode(['status' => 'error', 'message' => 'Login failed: Invalid credentials.']);
    exit();
}

// Set session variables, including the full name and user type
$_SESSION['admin_id'] = $admin['id'];
$_SESSION['admin_email'] = $admin['email'];
$_SESSION['full_name'] = $admin['full_name']; 
$_SESSION['user_type'] = $admin['user_type'];

// Redirect based on user type
if ($admin['user_type'] === 'admin') {
    header("Location: admin/admin_dashboard.php");
    exit();
} elseif ($admin['user_type'] === 'staff') {
    header("Location: admin/staff/staff_dashboard.php");
    exit();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid user type.']);
    exit();
}

// Close the statement and connection
$stmt->close();
$db->close();
?>
