<?php
$servername = "localhost";
$username = "u614894444_pdmh";
$password = "P0531d0n321";
$dbname = "u614894444_pgmhdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Adjust the SQL query to fetch only active announcements
$sql = "SELECT * FROM announcements WHERE status = 'active'";
$result = $conn->query($sql);

if ($result === false) {
    echo "Error: " . $conn->error;
} else {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="accordion-item">
                    <h2 class="accordion-header" id="heading'.$row['id'].'">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse'.$row['id'].'" aria-expanded="true" aria-controls="collapse'.$row['id'].'">
                            '.$row['title'].'
                        </button>
                    </h2>
                    <div id="collapse'.$row['id'].'" class="accordion-collapse collapse" aria-labelledby="heading'.$row['id'].'" data-bs-parent="#accordionPanelsStayOpenExample">
                        <div class="accordion-body">
                            '.$row['content'].'
                        </div>
                    </div>
                </div>';
        }
    } else {
        echo "No active announcements available.";
    }
}

$conn->close();
?>
