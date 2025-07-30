<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'resident') {
    header("Location: ../index.html");
    exit();
}

$full_name = $_SESSION['full_name'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>User Settings</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="assets/css/main.min.css" />
    <link rel="stylesheet" href="assets/vendor/daterange/daterange.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
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
                    <?php echo htmlspecialchars($full_name); ?> <!-- Display the logged-in admin's name -->
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">User Settings</h1>
                    <ol class="breadcrumb mb=4">
                        <li class="breadcrumb-item"><a href="resident_dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">User Settings</li>
                    </ol>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="card mb-2">
                                        <div class="card-body">
                                            <!--put it in here-->
                                            <div class="custom-tabs-container">
                                                <ul class="nav nav-tabs" id="customTab2" role="tablist">
                                                    <li class="nav-item" role="presentation">
                                                        <a class="nav-link active" id="tab-oneA" data-bs-toggle="tab"
                                                            href="#oneA" role="tab" aria-controls="oneA"
                                                            aria-selected="true">General</a>
                                                    </li>
                                                    <li class="nav-item" role="presentation">
                                                        <a class="nav-link" id="tab-twoA" data-bs-toggle="tab"
                                                            href="#twoA" role="tab" aria-controls="twoA"
                                                            aria-selected="false">Settings</a>
                                                    </li>
                                                    <li class="nav-item" role="presentation">
                                                        <a class="nav-link" id="tab-threeA" data-bs-toggle="tab" href="#threeA" role="tab" aria-controls="threeA" aria-selected="false">Change Password</a>
                                                    </li>

                                                </ul>
                                                <div class="tab-content h-350">
                                                    <div class="tab-pane fade show active" id="oneA" role="tabpanel">
                                                        <!-- Row start -->
                                                        <div class="row gx-2">
                                                            <div class="row gx-2">
                                                                <div class="col-6">
                                                                    <!-- Form Field Start -->
                                                                    <div class="mb-3">
                                                                        <label for="fullName" class="form-label">Full Name</label>
                                                                        <input type="text" class="form-control" id="fullName" 
                                                                               value="<?php echo htmlspecialchars($full_name); ?>" 
                                                                               placeholder="Full Name" disabled />
                                                                    </div>

                                                                    <!-- Form Field Start -->
                                                                    <div class="mb-3">
                                                                        <label for="contactNumber" class="form-label">Contact</label>
                                                                        <input type="text" class="form-control" id="contactNumber" placeholder="Contact" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <!-- Form Field Start -->
                                                                    <div class="mb-3">
                                                                        <label for="emailId" class="form-label">Email</label>
                                                                        <input type="email" class="form-control" id="emailId" placeholder="Email ID" />
                                                                    </div>
                                                    
                                                                    <!-- Form Field Start -->
                                                                    <div class="mb-3">
                                                                        <label for="birthDay" class="form-label">Birthday</label>
                                                                        <div class="input-group">
                                                                            <input type="text" class="form-control datepicker" id="birthDay" placeholder="DD/MM/YYYY" />
                                                                            <span class="input-group-text">
                                                                                <i class="icon-calendar"></i>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                <div class="d-flex gap-2 justify-content-end">
                                                    <button type="button" class="btn btn-light">
                                                        Cancel
                                                    </button>
                                                    <button type="button" id="updateBtn"
                                                        class="btn btn-success">Update</button>
                                                </div>
                                                        </div>
                                                    </div>

                                                    <div class="tab-pane fade" id="twoA" role="tabpanel">
                                                        <div class="card-body">
                                                            <div class="row gx-2">
                                                                <div class="col-sm-6 col-12">
                                                                    <div class="card mb-2">
                                                                        <div class="card-body">
                                                                            <ul class="list-group">
                                                                                <li
                                                                                    class="list-group-item d-flex justify-content-between align-items-center">
                                                                                    Show desktop notifications
                                                                                    <div
                                                                                        class="form-check form-switch m-0">
                                                                                        <input class="form-check-input"
                                                                                            type="checkbox"
                                                                                            role="switch"
                                                                                            id="switchOne" />
                                                                                    </div>
                                                                                </li>
                                                                                <li
                                                                                    class="list-group-item d-flex justify-content-between align-items-center">
                                                                                    Show email notifications
                                                                                    <div
                                                                                        class="form-check form-switch m-0">
                                                                                        <input class="form-check-input"
                                                                                            type="checkbox"
                                                                                            role="switch" id="switchTwo"
                                                                                            checked />
                                                                                    </div>
                                                                                </li>
                                                                                <li
                                                                                    class="list-group-item d-flex justify-content-between align-items-center">
                                                                                    Show notifications
                                                                                    <div
                                                                                        class="form-check form-switch m-0">
                                                                                        <input class="form-check-input"
                                                                                            type="checkbox"
                                                                                            role="switch"
                                                                                            id="switchThree" />
                                                                                    </div>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                    <!-- Card end -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                        <div class="tab-pane fade" id="threeA" role="tabpanel">
                                                            <div class="card-body">
                                                                <form id="changePasswordForm" action="update_password.php" method="POST">
                                                                    <div class="mb-3">
                                                                        <label for="currentPassword" class="form-label">Current Password</label>
                                                                        <input type="password" class="form-control" id="currentPassword" name="currentPassword" placeholder="Enter current password" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="newPassword" class="form-label">New Password</label>
                                                                        <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="Enter new password" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="confirmPassword" class="form-label">Confirm New Password</label>
                                                                        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm new password" required>
                                                                    </div>
                                                                    <div class="d-flex gap-2 justify-content-end">
                                                                        <button type="reset" class="btn btn-light">Cancel</button>
                                                                        <button type="submit" id="changePasswordBtn" class="btn btn-success">Update Password</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>


                                                </div>

                                            </div>
                                        </div>
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
                        <div class="text-muted">Copyright &copy; PeninsulaGardenMidtownHomes 2024</div>
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
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/moment.min.js"></script>
    <script src="assets/vendor/daterange/daterange.js"></script>
    <script src="assets/vendor/daterange/custom-daterange.js"></script>
    <script src="js/scripts.js"></script>
    <script src="assets/js/custom.js"></script>
<!-- Add this modal to your user_setting.php -->
<div class="modal fade" id="confirmPasswordModal" tabindex="-1" aria-labelledby="confirmPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmPasswordModalLabel">Confirm Password Update</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to update your password?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" id="confirmPasswordUpdate" class="btn btn-danger">Proceed</button>
            </div>
        </div>
    </div>
</div>

<!-- Update the form submit button and logic -->
<script>
document.getElementById('changePasswordBtn').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent the form from submitting directly
    new bootstrap.Modal(document.getElementById('confirmPasswordModal')).show(); // Show the modal
});

document.getElementById('confirmPasswordUpdate').addEventListener('click', function() {
    document.getElementById('changePasswordForm').submit(); // Submit the form after confirmation
});
</script>

    
</body>

</html>