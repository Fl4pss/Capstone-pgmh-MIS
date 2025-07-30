<?php
// Check if a session already exists before starting one
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$host = 'localhost';  
$dbname = 'u614894444_pgmhdb'; 
$username = 'u614894444_pdmh'; 
$password = 'P0531d0n321';  

// Create the connection
$db = new mysqli($host, $username, $password, $dbname);

// Check if connection is successful
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Fetch form data
$full_name = $_POST['full_name'] ?? ''; // Ensure this is set
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$role = $_POST['role'] ?? '';
$new_admin_access_code = $_POST['new_admin_access_code'] ?? '';

// Validate required fields
if (!$full_name || !$email || !$password || !$role || !$new_admin_access_code) {
    die("Please fill in all required fields.");
}

// Hash the password
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

// Check if the email already exists in the admins table
$email_check_query = $db->prepare("SELECT * FROM admins WHERE email = ?");
$email_check_query->bind_param("s", $email);
$email_check_query->execute();
$email_check_query_result = $email_check_query->get_result();

if ($email_check_query_result->num_rows > 0) {
    // Email already exists, return an error message
    die("Registration failed: Email already exists.");
}

// Begin a transaction to ensure queries succeed or fail together
$db->begin_transaction();

try {
    // Prepare and execute the SQL query to insert the new admin into the admins table
    $stmt = $db->prepare("INSERT INTO admins (full_name, email, password, access_role, admin_code) 
                          VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $full_name, $email, $hashed_password, $role, $new_admin_access_code);
    
    if (!$stmt->execute()) {
        throw new Exception("Error inserting into admins table: " . $stmt->error);
    }

    // Determine user type based on role
    $user_type = ($role === 'admin') ? 'admin' : 'staff';

    // Prepare and execute the SQL query to insert into the users table
    $user_stmt = $db->prepare("INSERT INTO users (email, password, full_name, user_type, admin_code) 
                                VALUES (?, ?, ?, ?, ?)");
    $user_stmt->bind_param("sssss", $email, $hashed_password, $full_name, $user_type, $new_admin_access_code);

    if (!$user_stmt->execute()) {
        throw new Exception("Error inserting into users table: " . $user_stmt->error);
    }

    // If both inserts succeed, commit the transaction
    $db->commit();
    echo "New admin registered successfully and added to both the admins and users tables!";
} catch (Exception $e) {
    // If an error occurs, rollback the transaction
    $db->rollback();
    echo "Registration failed: " . $e->getMessage();
}

// Close the statements and the connection
$email_check_query->close();
$stmt->close();
$user_stmt->close(); // Close user_stmt as well
$db->close();
?>
