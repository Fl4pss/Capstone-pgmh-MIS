<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'resident') {
    header("Location: index.html");
    exit();
}

// Get the logged-in resident's data from the session
$full_name = $_SESSION['full_name'];
$unit_number = $_SESSION['unit_number'];
$email = $_SESSION['email']; // Retrieve the email from the session

// Save previously selected issue type in session for dynamic loading
if (isset($_SESSION['last_issue_type'])) {
    $last_issue_type = $_SESSION['last_issue_type'];
} else {
    $last_issue_type = '';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Tables - SB Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link href="quill/quill.core.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="resident_dashboard.php">Peninsula Garden</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
                class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..."
                    aria-describedby="btnNavbarSearch" />
                <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i
                        class="fas fa-search"></i></button>
                <a class="d-flex p-3 position-relative" href="mail.php">
                    <i class="fas fa-envelope"></i>
                    <span id="recentMailBadge"
                        class="badge bg-danger position-absolute top-80 start-50 translate-middle translate-middle-y">0</span>
                </a>
            </div>
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="user_settings.php">Settings</a></li>
                    <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="#!">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Core</div>
                        <a class="nav-link" href="resident_dashboard.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <div class="sb-sidenav-menu-heading">Interface</div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Request
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="facility.php">Facilities</a>
                                <a class="nav-link" href="maintenance.php">Maintenance</a>
                            </nav>
                        </div>
                        <a class="nav-link" href="history.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-question-circle"></i></div>
                            History
                        </a>
                        <a class="nav-link" href="faq.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-question-circle"></i></div>
                            FAQ
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    <?php echo htmlspecialchars($full_name); ?> <!-- Display resident's name -->
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Maintenance Request</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="resident_dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item active">Maintenance Request</li>
                </ol>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Maintenance Request</h3>
                                </div>
                                <div class="card-body">
                                    <form id="maintenanceRequestForm" enctype="multipart/form-data">
                                        <div class="form-floating mb-3">
                                            <textarea class="form-control" id="description" name="description" placeholder="Description" required></textarea>
                                            <label for="description">Description</label>
                                        </div>
                                        
                                        <div class="form-group mb-3">
                                            <label for="urgency">Urgency Level:</label>
                                            <select class="form-control" id="urgency" name="urgency" required>
                                                <option value="">Select Urgency</option>
                                                <option value="low">Low</option>
                                                <option value="moderate">Moderate</option>
                                                <option value="high">High</option>
                                            </select>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label>Type of Issue:</label><br>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" id="plumbing" name="type" value="plumbing" <?php if ($last_issue_type == 'plumbing') echo 'checked'; ?>>
                                                <label class="form-check-label" for="plumbing">Plumbing</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" id="electrical" name="type" value="electrical" <?php if ($last_issue_type == 'electrical') echo 'checked'; ?>>
                                                <label class="form-check-label" for="electrical">Electrical</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" id="pest" name="type" value="pest" <?php if ($last_issue_type == 'pest') echo 'checked'; ?>>
                                                <label class="form-check-label" for="pest">Pest Control</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" id="aircon" name="type" value="aircon" <?php if ($last_issue_type == 'aircon') echo 'checked'; ?>>
                                                <label class="form-check-label" for="aircon">Air Conditioning</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" id="other" name="type" value="other" <?php if ($last_issue_type == 'other') echo 'checked'; ?>>
                                                <label class="form-check-label" for="other">Other</label>
                                                <input class="form-control mt-1" id="otherIssue" name="otherIssue" type="text" placeholder="Specify Other Issue" style="display: none;">
                                            </div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="attachment">Upload Image:</label>
                                            <input class="form-control" id="attachment" name="attachment" type="file" accept="image/*">
                                        </div>

                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <button class="btn btn-primary" type="button" id="submitRequest">Submit Request</button>
                                        </div>
                                    </form>
                                    <div id="responseMessage" class="mt-3"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
 
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>

    <script>
$(document).ready(function () {
    // Show "Other Issue" input field if "Other" is selected
    $('#other').on('change', function () {
        $('#otherIssue').toggle(this.checked).attr('required', this.checked);
    });

    // Enforce image upload when high urgency is selected
    $('#urgency').on('change', function () {
        const isHighUrgency = $(this).val() === 'high';
        $('#attachment').attr('required', isHighUrgency);
        if (isHighUrgency) {
            alert('High urgency selected. Please provide an image to support your request.');
        }
    });

    // Validate the form on submission
    $('#submitRequest').on('click', function (e) {
        e.preventDefault();
        const urgency = $('#urgency').val();
        const attachment = $('#attachment').val();
        
        if (urgency === 'high' && !attachment) {
            alert('Image upload is required for high urgency requests.');
            return; // Stop form submission
        }

        // Get unit number from the session (stored in JavaScript)
        const unit_number = '<?php echo $_SESSION["unit_number"]; ?>';

        // Submit the form via AJAX if all validations pass
        var formData = new FormData($('#maintenanceRequestForm')[0]);
        formData.append('unit_number', unit_number); // Add unit_number to form data

        $.ajax({
            url: 'submit_maintenance_request.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                const result = JSON.parse(response);
                if (result.status === 'success') {
                    $('#responseMessage').html('<div class="alert alert-success">Request submitted successfully!</div>');
                    $('#maintenanceRequestForm')[0].reset();
                    $('#attachment').removeAttr('required'); // Reset required attribute
                } else {
                    $('#responseMessage').html('<div class="alert alert-danger">There was an error submitting your request. Please try again.</div>');
                }
            },
            error: function () {
                $('#responseMessage').html('<div class="alert alert-danger">There was an error submitting your request. Please try again.</div>');
            }
        });
    });
});

    </script>
    
</body>

</html>

