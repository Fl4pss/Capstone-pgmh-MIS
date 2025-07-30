<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "residents_ticket";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $current_password = $_POST['currentPassword'];
    $new_password = $_POST['newPassword'];

    // Fetch the existing password from the database
    $sql = "SELECT * FROM residents";
    $result = $conn->query($sql);

    $password_updated = false;
    while ($row = $result->fetch_assoc()) {
        if (password_verify($current_password, $row['password'])) {
            // Current password matched, proceed to update
            $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update_sql = "UPDATE residents SET password='$new_hashed_password' WHERE id='" . $row['id'] . "'";

            if ($conn->query($update_sql) === TRUE) {
                $password_updated = true;
                header("Location: resident_login.html");
                exit();
            } else {
                echo "Error updating password: " . $conn->error;
            }
        }
    }

    if (!$password_updated) {
        echo "Current password is incorrect.";
    }

    $conn->close();
}
?>
