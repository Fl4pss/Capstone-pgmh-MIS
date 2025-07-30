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
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>visitor tickets</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="../admin_dashboard.php">Admin Dashboard</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
                class="fas fa-bars"></i></button>
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..."
                    aria-describedby="btnNavbarSearch" />
                <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i
                        class="fas fa-search"></i></button>
            </div>
        </form>
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
                                        <a class="nav-link" href="../residents/facility_reservation.php">Facility</a>
                                        <a class="nav-link"
                                            href="../residents/maintenance_tickets/maintenance_tickets.php">Maintenance</a>
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
                                        <a class="nav-link" href="visitor_ticket.php">Mail</a>
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
                                    href="../residents/residents_management/residents_registration.php">Registration</a>
                                <a class="nav-link" href="../residents/residents_management/resident_table.php">User
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
                    <h1 class="mt-4">Visit Requests</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="../admin_dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Tables</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-body">
                            <table id="visitorDatatable" class="table">
                                <thead>
                                    <tr>
                                        <th>Visitor Name</th>
                                        <th>Email</th>
                                        <th>Contact</th>
                                        <th>Resident Name</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Purpose of Visit</th>
                                        <th>Created at</th>
                                        <th>Confirmed at</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody">
                                    
                                </tbody>
                            </table>
                            <button class="btn btn-secondary" onclick="printTable()">Print Table</button>

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

        <script>
document.addEventListener('DOMContentLoaded', function () {
    // Fetch data from PHP file and populate DataTable
    fetch('visitor_request_data.php')
        .then(response => response.text())
        .then(data => {
            // Replace the content of tableBody with the data
            document.getElementById('tableBody').innerHTML = data;

            // Initialize the DataTable
            new simpleDatatables.DataTable('#visitorDatatable');
        })
        .catch(error => console.error('Error fetching data:', error));
});

// Confirm button click handler
function confirmBtn(visitorId) {
    console.log('Confirming visitor ID:', visitorId);
    const status = 'Approved'; // Set status to "Approved" when the button is clicked

    // Send an AJAX request to update the status to "Approved"
    fetch('update_status.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `id=${visitorId}&status=${status}` // Send valid status "Approved"
    })
    .then(response => response.text())
    .then(data => {
        console.log('Response from server:', data);
        if (data === 'success') {
            alert('Visitor request confirmed!');
            // Reload the table to reflect the updated status
            location.reload();
        } else {
            alert('Error confirming request: ' + data);
        }
    })
    .catch(error => console.error('Error:', error));
}

// Deny button click handler
function denyBtn(visitorId) {
    console.log('Denying visitor ID:', visitorId);
    const status = 'Denied'; // Set status to "Denied" when the button is clicked

    // Send an AJAX request to update the status to "Denied"
    fetch('update_status.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `id=${visitorId}&status=${status}` // Send valid status "Denied"
    })
    .then(response => response.text())
    .then(data => {
        console.log('Response from server:', data);
        if (data === 'success') {
            alert('Visitor request denied!');
            // Reload the table to reflect the updated status
            location.reload();
        } else {
            alert('Error denying request: ' + data);
        }
    })
    .catch(error => console.error('Error:', error));
}

// Print button click handler
function printTable() {
    // Get the table element
    var table = document.getElementById('visitorDatatable');

    // Remove the last column (action column) from the table for printing
    var rows = table.getElementsByTagName('tr');
    for (var i = 0; i < rows.length; i++) {
        var cells = rows[i].getElementsByTagName('td');
        if (cells.length > 0) {
            // Remove the last column (action column) from every row
            rows[i].deleteCell(cells.length - 1);
        }
    }

    // Open a new window for printing
    var printWindow = window.open('', '', 'height=800, width=1200');
    var content = table.outerHTML;

    // Write content to the new window
    printWindow.document.write('<html><head><title>Visitor Requests</title>');
    printWindow.document.write('<style>body {font-family: Arial, sans-serif; padding: 20px;} table {border-collapse: collapse; width: 100%;} th, td {border: 1px solid #ddd; padding: 8px; text-align: left;} th {background-color: #f2f2f2;}</style>');
    printWindow.document.write('</head><body>');
    printWindow.document.write('<h1>Visitor Requests</h1>');
    printWindow.document.write(content); // Append the table content
    printWindow.document.write('</body></html>');

    printWindow.document.close();
    printWindow.print();
}
</script>








</body>

</html>