<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'resident') {
    header("Location: index.html"); // Redirect to login page if not logged in
    exit();
}

// Get the logged-in resident's name from the session
$full_name = $_SESSION['full_name'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Facility Reservation</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"
        rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="resident_dashboard.php">Peninsula Garden</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
                class="fas fa-bars"></i></button>
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
                            <div class="sb-nav-link-icon"><i class="fas fa-history"></i></div>
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
                    <h1 class="mt-4">Reservation Request</h1>
                    <ol class="breadcrumb mb=4">
                        <li class="breadcrumb-item"><a href="resident_dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Reservation Request</li>
                    </ol>
                    <div class="card mb-6">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-lg-5">
                                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                                        <div class="card-header">
                                            <h3 class="text-center font-weight-light my-4">Reservation</h3>
                                        </div>
                                        <div class="card-body">
                                        <form id="reservationForm" action="process_reservation.php" method="post">
                                                <div class="form-floating mb-3">
                                                    <input class="form-control" id="inputEmail" name="inputEmail" type="email" placeholder="email@example.com" required />
                                                    <label for="inputEmail">Email Address</label>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="inputDate">Date:</label>
                                                    <input type="text" class="form-control" id="inputDate" name="inputDate" readonly required>
                                                </div>

                                                <!-- Preferred Time Inputs -->
                                                <div class="form-group mb-3">
                                                    <label for="startTime">Preferred Start Time:</label>
                                                    <select class="form-control" id="startTime" name="startTime" required>
                                                        <!-- Options will be populated by JavaScript -->
                                                    </select>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="endTime">Preferred End Time:</label>
                                                    <select class="form-control" id="endTime" name="endTime" required>
                                                        <!-- Options will be populated by JavaScript -->
                                                    </select>
                                                </div>


                                                <div class="form-group mb-3">
                                                    <label for="inputActivity">Activity:</label>
                                                    <select class="form-control" id="inputActivity" name="inputActivity" required>
                                                        <option value="">Choose Activity</option>
                                                        <option value="Swimming Pool">Swimming Pool</option>
                                                        <option value="Gym">Gym</option>
                                                        <option value="Multi-purpose Court">Multi-purpose Court</option>
                                                    </select>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="accompanyingPeople">Add People Accompanying You:</label>
                                                    <div id="peopleList">
                                                        <div class="row g-2">
                                                            <div class="col">
                                                                <input type="text" class="form-control" placeholder="Name" name="people[]">
                                                            </div>
                                                            <div class="col">
                                                                <input type="email" class="form-control" placeholder="Email" name="contacts[]">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button type="button" class="btn btn-secondary mt-2" id="addPerson">Add Another Person</button>
                                                </div>


                                                <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                    <button class="btn btn-primary" type="submit">Reserve</button>
                                                </div>
                                            </form>

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
                        <div>
                            <a href="#">Privacy Policy</a> &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script>
$(document).ready(function () {
    const availableTimes = [
        { hour: 9, period: 'AM' },
        { hour: 10, period: 'AM' },
        { hour: 11, period: 'AM' },
        { hour: 12, period: 'PM' },
        { hour: 1, period: 'PM' },
        { hour: 2, period: 'PM' },
        { hour: 3, period: 'PM' },
        { hour: 4, period: 'PM' },
        { hour: 5, period: 'PM' },
        { hour: 6, period: 'PM' },
        { hour: 7, period: 'PM' },
        { hour: 8, period: 'PM' }
    ];

    function populateTimeOptions(selectElement) {
        let options = '<option value="" disabled selected>Select time</option>';  // Placeholder option
        options += availableTimes.map(time => {
            const formattedTime = `${time.hour} ${time.period}`;
            return `<option value="${formattedTime}">${formattedTime}</option>`;
        }).join('');
        $(selectElement).html(options);  // Populate the dropdown
    }

    function updateEndTimeOptions(selectedStartTime) {
        const startIndex = availableTimes.findIndex(time => `${time.hour} ${time.period}` === selectedStartTime);
        
        if (startIndex !== -1) {
            let filteredTimes = '<option value="" disabled selected>Select end time</option>';  // Placeholder for end time
            filteredTimes += availableTimes.slice(startIndex + 1).map(time => {
                const formattedTime = `${time.hour} ${time.period}`;
                return `<option value="${formattedTime}">${formattedTime}</option>`;
            }).join('');
            $('#endTime').html(filteredTimes);  // Update endTime options
        }
    }

    // Initially populate the startTime and endTime selects
    populateTimeOptions('#startTime');
    populateTimeOptions('#endTime');

    // When the start time changes, update the end time options
    $('#startTime').on('change', function () {
        const selectedStartTime = $(this).val();
        updateEndTimeOptions(selectedStartTime);
    });

    // Form submission check for valid start and end times
    $('#reservationForm').submit(function (event) {
        event.preventDefault();  // Prevent the default form submission

        // Gather form data
        var formData = $(this).serialize();  // Serialize the form data for AJAX

        $.ajax({
            url: 'process_reservation.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    // If the reservation is successful, show the modal
                    $('#reservationModal').modal('show');
                } else {
                    // Handle failure (e.g., show an alert with the error message)
                    alert(response.message);
                }
            },
            error: function () {
                // Handle general errors (e.g., network issues)
                alert('There was an error processing your reservation. Please try again later.');
            }
        });
    });


    // Add a new accompanying person row
        $('#addPerson').click(function () {
            $('#peopleList').append(`
                <div class="row g-2 mt-2">
                    <div class="col">
                        <input type="text" class="form-control" placeholder="Name" name="people[]">
                    </div>
                    <div class="col">
                        <input type="email" class="form-control" placeholder="Email" name="contacts[]">
                    </div>
                </div>
            `);
        });


    // Datepicker for selecting date
    $('#inputDate').datepicker({
        format: 'yyyy-mm-dd',
        startDate: '0d',
        autoclose: true
    });
});

    </script>
<!-- Modal for reservation completion -->
<div class="modal fade" id="reservationModal" tabindex="-1" aria-labelledby="reservationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reservationModalLabel">Reservation Complete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Your reservation has been submitted! Please wait for the admin to confirm your request.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

</body>

</html>
