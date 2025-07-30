<?php
// Check if the form is submitted
if (isset($_POST["submit"])) {
    // Database connection
    $servername = "localhost";
    $username = "u614894444_pdmh";
    $password = "P0531d0n321";
    $dbname = "u614894444_pgmhdb";
    
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if file was uploaded without errors
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $image = addslashes(file_get_contents($_FILES['image']['tmp_name'])); // Get the image data and add slashes for database insertion
        
        // Insert image data into the database
        $sql = "INSERT INTO img (image_data) VALUES ('$image')";
        if ($conn->query($sql) === TRUE) {
            echo "Image uploaded successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Error uploading image.";
    }

    $conn->close();
}
?>
