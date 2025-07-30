<?php
session_start();

// Get the logged-in admin's name from the session
$full_name = $_SESSION['full_name'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Resident Tickets</title>
<!-- Stylesheets -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet">
<link href="../css/styles.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" rel="stylesheet">

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-rORqj5eS9bQ8JnmHcMa9u6T8Tx3h0rbkRUpNOaNOm+2MjHQOLVECe+V3WJ8Qbm8a" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>


    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="../admin_dashboard.php">Admin Dashboard</a>
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
            </div>
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Settings</a></li>
                    <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="../../index.html">Logout</a></li>
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
                        <a class="nav-link" href="../admin_dashboard.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <div class="sb-sidenav-menu-heading">Manage</div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            News & Announcements
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="../E-bulletin.php">Media</a>
                                <a class="nav-link" href="../Announcement_editor.php">Announcements</a>
                            </nav>
                        </div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages"
                            aria-expanded="false" aria-controls="collapsePages">
                            <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                            Tickets
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapsePages" aria-labelledby="headingTwo"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                    data-bs-target="#pagesCollapseAuth" aria-expanded="false"
                                    aria-controls="pagesCollapseAuth">
                                    Residents
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne"
                                    data-bs-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="../residents/mail.php">Mail</a>
                                        <a class="nav-link" href="facility_reservation.php">Facility</a>
                                        <a class="nav-link"
                                            href="maintenance_tickets/maintenance_tickets.php">Maintenance</a>
                                    </nav>
                                </div>
                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                    data-bs-target="#pagesCollapseError" aria-expanded="false"
                                    aria-controls="pagesCollapseError">
                                    Visitors
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne"
                                    data-bs-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="../visitors/visitor_ticket.php">Mail</a>
                                    </nav>
                                </div>
                            </nav>
                        </div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseUsers"
                            aria-expanded="false" aria-controls="collapseUsers">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            User Management
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseUsers" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link"
                                    href="residents_management/residents_registration.php">Registration</a>
                                <a class="nav-link" href="admin_management/admin_registration.php">Admin Registration</a>
                                <a class="nav-link" href="residents_management/resident_table.php">User
                                    Table</a>
                            </nav>
                        </div>
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
                    <h1 class="mt-4">Facility Reservation</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Facility Reservation</li>
                    </ol>
                    <div class="card mb-2">
                        <div class="card-body">
                            <div class="custom-tabs-container">
                                <ul class="nav nav-tabs" id="customTab2" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active" id="tab-oneA" data-bs-toggle="tab" href="#oneA"
                                            role="tab" aria-controls="oneA" aria-selected="true">Active Tickets</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="tab-twoA" data-bs-toggle="tab" href="#twoA" role="tab"
                                            aria-controls="twoA" aria-selected="false">Completed Tickets</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="tab-threeA" data-bs-toggle="tab" href="#threeA"
                                            role="tab" aria-controls="threeA" aria-selected="false">Archived Tickets</a>
                                    </li>
                                        <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="tab-fourA" data-bs-toggle="tab" href="#fourA" role="tab" aria-controls="fourA"
                                            aria-selected="false">Create Ticket</a>
                                    </li>
                                                                </ul>
                                <div class="tab-content h-350">
                                    <div class="tab-pane fade show active" id="oneA" role="tabpanel">
                                        <div class="card mb-4">
                                            <div class="card-header">
                                                <i class="fas fa-table me-1"></i>
                                                Pending Reservations
                                            </div>
                                            <div class="card-body">
                                                <table id="reservationDatatable" class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Name</th>
                                                            <th>Email</th>
                                                            <th>Date</th>
                                                            <th>Start Time</th>
                                                            <th>End Time</th>
                                                            <th>Activity</th>
                                                            <th>Guests</th>
                                                            <th>Created at</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="activeTableBody">
                                                        
                                                    </tbody>
                                                </table>
                                                    <!-- Print Button at Bottom Right -->
                                                <div style="text-align: right;">
                                                    <button class="btn btn-info" onclick="printTable('reservationDatatable')">Print Table</button>
                                                </div>
                                            </div>
                                        </div>    
                                    </div>
                                    <div class="tab-pane fade" id="twoA" role="tabpanel">
                                        <div class="card-body">
                                            <div class="card mb-4">
                                                <div class="card-header">
                                                    <i class="fas fa-table me-1"></i>
                                                    Completed Reservations
                                                </div>
                                                <div class="card-body">
                                                    <h2>Completed Tickets</h2>
                                                    <table id="completedDatatable" class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Ticket ID</th>
                                                                <th>Name</th>
                                                                <th>Email</th>
                                                                <th>Date</th>
                                                                <th>Start Time</th>
                                                                <th>End Time</th>
                                                                <th>Activity</th>
                                                                <th>Guests</th>
                                                                <th>Created at</th>
                                                                <th>Completed at</th>
                                                                <th>Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="completedTableBody">
                                                        </tbody>
                                                    </table>
                                                    <div style="text-align: right;">
                                                    <button class="btn btn-info" onclick="printTable('completedDatatable')">Print Table</button>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="threeA" role="tabpanel">
                                        <div class="card-body">
                                            <div class="card-header">
                                                <i class="fas fa-table me-1"></i>
                                                Archived Reservations
                                            </div>
                                            <div class="card-body">
                                                <h2>Archived Tickets</h2>
                                                <table id="archiveDatatable" class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Name</th>
                                                            <th>Email</th>
                                                            <th>Date</th>
                                                            <th>Start Time</th>
                                                            <th>End Time</th>
                                                            <th>Activity</th>
                                                            <th>Guests</th>
                                                            <th>Created At</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="archiveTableBody"></tbody>
                                                </table>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="fourA" role="tabpanel">
                                        <div class="card mb-4">
                                            <div class="card-header">
                                                <i class="fas fa-plus me-1"></i>
                                                Create New Ticket
                                            </div>
                                            <div class="card-body">
                                                <form id="reservationForm" action="process_reservation.php" method="post">
                                                    <div class="form-floating mb-3">
                                                        <input class="form-control" id="inputName" name="inputName" type="text" placeholder="John Doe" required />
                                                        <label for="inputName">Full Name</label>
                                                    </div>
                                                    <div class="form-floating mb-3">
                                                        <input class="form-control" id="inputEmail" name="inputEmail" type="email" placeholder="john.doe@example.com" required />
                                                        <label for="inputEmail">Email Address</label>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="inputDate">Date:</label>
                                                        <input type="text" class="form-control" id="inputDate" name="inputDate" readonly required>
                                                    </div>
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
                                                                    <input type="email" class="form-control" placeholder="Email Address" name="contacts[]">
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
    <script src="../js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
        <!-- Modal Structure -->
        <div class="modal fade" id="reasonModal" tabindex="-1" aria-labelledby="reasonModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reasonModalLabel">Reason for Time Change</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <textarea id="changeReason" class="form-control" rows="3"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="sendReasonBtn">Save</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Fetch data from data.php
    fetch('data.php')
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error(data.error);
                return;
            }

            // Populate Active Tickets table
            const activeTableBody = document.getElementById('activeTableBody');
            activeTableBody.innerHTML = ''; // Clear the table body first

            data.active.forEach(reservation => {
                const row = document.createElement('tr');

                // Format accompanying_people as a dropdown with labeled name and email
                let guestDropdown = '';
                if (reservation.accompanying_people && reservation.accompanying_people.length > 0) {
                    guestDropdown = `<div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton${reservation.id}" data-bs-toggle="dropdown" aria-expanded="false">
                            Show Guests (${reservation.accompanying_people.length})
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton${reservation.id}">`;

                    reservation.accompanying_people.forEach(guest => {
                        guestDropdown += ` 
                            <li class="dropdown-item">
                                <strong>Guest Name:</strong> ${guest.name}<br>
                                <strong>Email:</strong> ${guest.email}
                            </li>`;
                    });

                    guestDropdown += `</ul></div>`;
                } else {
                    guestDropdown = 'No guests';
                }

                // Create the row with start and end times from the database
                row.innerHTML = `
                    <td>${reservation.id}</td>
                    <td>${reservation.name}</td>
                    <td>${reservation.email}</td>
                    <td>${reservation.date}</td>
                    <td>
                        <span id="starttime-display-${reservation.id}">${reservation.start_time}</span>
                    </td>
                    <td>
                        <span id="endtime-display-${reservation.id}">${reservation.end_time}</span>
                    </td>
                    <td>${reservation.activity}</td>
                    <td>${guestDropdown}</td>
                    <td>${reservation.created_at}</td>
                    <td>${reservation.status}</td>
                    <td>
                        <div id="buttonContainer-${reservation.id}" class="button-container">
                            <button id="editTimeBtn-${reservation.id}" onclick="editTime(${reservation.id})">
                                <i class="fa-solid fa-pen-to-square"></i> <!-- Pen icon for edit -->
                            </button>
                            <button id="confirmBtn-${reservation.id}" onclick="confirmReservation(${reservation.id})">Confirm</button>
                            <button id="archiveBtn-${reservation.id}" onclick="archiveReservation(${reservation.id})">
                            <i class="fa-solid fa-trash"></i></button>
                            <button id="saveTimeBtn-${reservation.id}" onclick="saveTime(${reservation.id})" style="display: none;">Save</button>
                            <button id="cancelTimeBtn-${reservation.id}" onclick="cancelEditTime(${reservation.id})" style="display: none;">Cancel</button>
                        </div>
                    </td>
                `;

                activeTableBody.appendChild(row);
            });

            // Populate Completed Tickets table
            const completedTableBody = document.getElementById('completedTableBody');
            completedTableBody.innerHTML = ''; // Clear the completed table body first

            data.completed.forEach(reservation => {
                const row = document.createElement('tr');

                // Format accompanying_people as needed (similar to active)
                let guestDropdown = '';
                if (reservation.accompanying_people && reservation.accompanying_people.length > 0) {
                    guestDropdown = `<div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton${reservation.id}" data-bs-toggle="dropdown" aria-expanded="false">
                            Show Guests (${reservation.accompanying_people.length})
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton${reservation.id}">`;

                    reservation.accompanying_people.forEach(guest => {
                        guestDropdown += `
                            <li class="dropdown-item">
                                <strong>Guest Name:</strong> ${guest.name}<br>
                                <strong>Email:</strong> ${guest.email}
                            </li>`;
                    });

                    guestDropdown += `</ul></div>`;
                } else {
                    guestDropdown = 'No guests';
                }

                row.innerHTML = `
                    <td>${reservation.id}</td>
                    <td>${reservation.name}</td>
                    <td>${reservation.email}</td>
                    <td>${reservation.date}</td>
                    <td>
                        <span id="starttime-display-${reservation.id}">${reservation.start_time}</span>
                    </td>
                    <td>
                        <span id="endtime-display-${reservation.id}">${reservation.end_time}</span>
                    </td>
                    <td>${reservation.activity}</td>
                    <td>${guestDropdown}</td>
                    <td>${reservation.created_at}</td>
                    <td>${reservation.completed_at ? new Date(reservation.completed_at).toLocaleString() : 'Not completed yet'}</td>
                    <td>${reservation.status}</td>
                `;

                completedTableBody.appendChild(row);
            });
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
});
</script>


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

    // Add a new accompanying person row (change email input to contact input)
    $('#addPerson').click(function () {
        $('#peopleList').append(`
            <div class="row g-2 mt-2">
                <div class="col">
                    <input type="text" class="form-control" placeholder="Name" name="people[]">
                </div>
                <div class="col">
                    <input type="text" class="form-control" placeholder="Contact Number" name="contacts[]"> <!-- Changed to contact -->
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
<script>
function confirmReservation(reservationId) {
    fetch('data.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            id: reservationId,
            action: 'confirm'
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Reservation confirmed successfully!');

            // Update the status of the reservation
            document.getElementById(`status-display-${reservationId}`).innerText = 'Confirmed';

            // Find the confirmed reservation row in the Active Tickets table
            const confirmedRow = document.querySelector(`#activeTableBody tr[data-id="${reservationId}"]`);
            if (confirmedRow) {
                // Clone the row to transfer it to the Completed Tickets table
                const completedRow = confirmedRow.cloneNode(true);

                // Set the "Completed at" time
                completedRow.querySelector('.completed-at-cell').innerText = new Date().toLocaleString();

                // Append the row to the Completed Tickets table
                document.getElementById('completedTableBody').appendChild(completedRow);

                // Remove the original row from the Active Tickets table
                confirmedRow.remove();
            }
        } else {
            alert('Failed to confirm reservation.');
        }
    })
    .catch(error => console.error('Error confirming reservation:', error));
}
</script>

<script>
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

function generateTimeOptions(selectedTime = '') {
    let options = '';
    availableTimes.forEach(time => {
        const timeValue = `${time.hour} ${time.period}`;
        const selected = (timeValue === selectedTime) ? 'selected' : '';
        options += `<option value="${timeValue}" ${selected}>${timeValue}</option>`;
    });
    return options;
}

function editTime(reservationId) {
    const startTimeDisplay = document.getElementById(`starttime-display-${reservationId}`);
    const endTimeDisplay = document.getElementById(`endtime-display-${reservationId}`);
    const currentStartTime = startTimeDisplay.innerText.trim();
    const currentEndTime = endTimeDisplay.innerText.trim();

    startTimeDisplay.dataset.originalValue = currentStartTime;
    endTimeDisplay.dataset.originalValue = currentEndTime;

    startTimeDisplay.innerHTML = `<select id="starttime-${reservationId}">${generateTimeOptions(currentStartTime)}</select>`;
    endTimeDisplay.innerHTML = `<select id="endtime-${reservationId}">${generateTimeOptions(currentEndTime)}</select>`;

    document.getElementById(`editTimeBtn-${reservationId}`).style.display = 'none';
    document.getElementById(`confirmBtn-${reservationId}`).style.display = 'none';
    document.getElementById(`saveTimeBtn-${reservationId}`).style.display = 'block';
    document.getElementById(`cancelTimeBtn-${reservationId}`).style.display = 'block';
}

function cancelEditTime(reservationId) {
    const startTimeDisplay = document.getElementById(`starttime-display-${reservationId}`);
    const endTimeDisplay = document.getElementById(`endtime-display-${reservationId}`);

    startTimeDisplay.innerText = startTimeDisplay.dataset.originalValue;
    endTimeDisplay.innerText = endTimeDisplay.dataset.originalValue;

    document.getElementById(`editTimeBtn-${reservationId}`).style.display = 'inline-block';
    document.getElementById(`confirmBtn-${reservationId}`).style.display = 'inline-block';
    document.getElementById(`saveTimeBtn-${reservationId}`).style.display = 'none';
    document.getElementById(`cancelTimeBtn-${reservationId}`).style.display = 'none';
}

function saveTime(reservationId) {
    const startTime = document.getElementById(`starttime-${reservationId}`).value;
    const endTime = document.getElementById(`endtime-${reservationId}`).value;
    const defaultMessage = `The reservation time has been changed to start at ${startTime} and end at ${endTime}. Due to..`;

    const reasonInput = document.getElementById('changeReason');
    reasonInput.value = defaultMessage;

    const reasonModal = new bootstrap.Modal(document.getElementById('reasonModal'));
    reasonModal.show();

    document.getElementById('sendReasonBtn').onclick = function () {
        const reason = reasonInput.value.trim();

        if (!reason) {
            alert("Please enter a reason for the time change.");
            return;
        }

        fetch('data.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                id: reservationId,
                start_time: startTime,
                end_time: endTime,
                reason: reason
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Time updated successfully!');

                setTimeout(() => {
                    document.getElementById(`editTimeBtn-${reservationId}`).style.display = 'block';
                    document.getElementById(`confirmBtn-${reservationId}`).style.display = 'block';
                    document.getElementById(`saveTimeBtn-${reservationId}`).style.display = 'none';
                    document.getElementById(`cancelTimeBtn-${reservationId}`).style.display = 'none';

                    document.getElementById(`starttime-display-${reservationId}`).innerText = startTime;
                    document.getElementById(`endtime-display-${reservationId}`).innerText = endTime;

                    reasonModal.hide();
                }, 0);
            } else {
                alert('Failed to update time.');
            }
        })
        .catch(error => console.error('Error updating time:', error));
    };
}

function printTable(tableId) {
    const printContent = document.getElementById(tableId).outerHTML;

    const printWindow = window.open('', '', 'width=800,height=600');
    printWindow.document.write('<html><head><title>Print Table</title>');

    printWindow.document.write('<style>');
    printWindow.document.write('table { width: 100%; border-collapse: collapse; }');
    printWindow.document.write('table, th, td { border: 1px solid black; padding: 8px; text-align: left; }');
    printWindow.document.write('.guest-info { margin-top: 10px; padding: 5px; border-top: 1px solid #ddd; }');
    printWindow.document.write('.guest-info strong { display: inline-block; width: 100px; }');
    printWindow.document.write('</style></head><body>');

    const parsedContent = printContent.replace(/Show Guests \(\d+\)/g, 'Guests')
        .replace(/<li class="dropdown-item">/g, '<div class="guest-info">')
        .replace(/<\/li>/g, '</div>')
        .replace(/<ul class="dropdown-menu"[^>]*>/g, '')
        .replace(/<\/ul>/g, '');

    printWindow.document.write(parsedContent);
    printWindow.document.write('</body></html>');

    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
    printWindow.close();
}
</script>

