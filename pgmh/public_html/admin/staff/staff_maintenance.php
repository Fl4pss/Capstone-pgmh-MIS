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
    <title>Maintenance Tickets</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="../../admin_dashboard.php">Admin Dasboard</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle"><i
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
                        <a class="nav-link" href="../../admin_dashboard.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <div class="sb-sidenav-menu-heading">Manage</div>

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
                                        <a class="nav-link" href="staff_facility.php">Facility</a>
                                        <a class="nav-link"
                                            href="staff_maintenance.php">Maintenance</a>
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
                                        <a class="nav-link" href="../../visitors/visitor_ticket.php">Mail</a>
                                    </nav>
                                </div>
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
                    <h1 class="mt-4">Maintenance Tickets</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="admin_dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Maintenance Tickets</li>
                    </ol>
                    <div class="card mb-2">
                        <div class="card-body">
                            <div class="custom-tabs-container">
                                <!-- Removed the tabs as the table will now be displayed directly -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-table me-1"></i>
                                        Completed Tickets
                                    </div>
                                    <div class="card-body">
                                        <!-- Completed Tickets Table -->
                                        <h2>Completed Tickets</h2>
                                        <table id="completedDatatable" class="table">
                                            <thead>
                                                <tr>
                                                    <th>Ticket ID</th>
                                                    <th>Name</th>
                                                    <th>Description</th>
                                                    <th>Urgency</th>
                                                    <th>Location</th>
                                                    <th>Type</th>
                                                    <th>Other Issue</th>
                                                    <th>Created at</th>
                                                    <th>Completed at</th>
                                                    <th>Status</th>
                                                    <th>Confirmed By</th>
                                                    <th>Image</th>
                                                </tr>
                                            </thead>
                                            <tbody id="completedTableBody">
                                                <!-- Rows will be dynamically populated here -->
                                            </tbody>
                                        </table>
                                        <!-- Print Button -->
                                        <button class="btn btn-primary mt-3" onclick="printTable()">Print Table</button>
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
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="../../js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/js/bootstrap.bundle.min.js"
        integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl5+z24U8AB+8M2kIcy5PVW39d+6B6q5fZfLh8KuuF"
        crossorigin="anonymous"></script>

        <script>
    // Ensure the printTable function is defined globally
    function printTable() {
        const printContent = document.querySelector('.card-body').innerHTML;
        const originalContent = document.body.innerHTML;

        // Replace the body content with the table content
        document.body.innerHTML = printContent;

        // Trigger the print dialog
        window.print();

        // Restore the original content
        document.body.innerHTML = originalContent;

        // Reload the page to reattach event listeners
        location.reload();
    }

    document.addEventListener('DOMContentLoaded', function () {
        const urlParams = new URLSearchParams(window.location.search);
        const urgencyFilter = urlParams.get('urgency');

        function loadTickets() {
            fetch('../residents/maintenance_tickets/maintenance_data.php')
                .then(response => response.json())
                .then(data => {
                    const completedTableBody = document.getElementById('completedTableBody');

                    completedTableBody.innerHTML = '';

                    data.completed_tickets
                        .filter(ticket => !urgencyFilter || ticket.urgency === urgencyFilter)
                        .forEach(ticket => {
                            const row = createCompletedTicketRow(ticket);
                            completedTableBody.appendChild(row);
                        });
                })
                .catch(error => console.error('Error loading tickets:', error));
        }

        function createCompletedTicketRow(ticket) {
            const row = document.createElement('tr');
            const imageSrc = ticket.image ? `data:image/jpeg;base64,${ticket.image}` : '';

            row.innerHTML = `
                <td>${ticket.id}</td>
                <td>${ticket.name}</td>
                <td>${ticket.description}</td>
                <td>${ticket.urgency}</td>
                <td>${ticket.location}</td>
                <td>${ticket.type}</td>
                <td>${ticket.other_issue || 'N/A'}</td>
                <td>${ticket.created_at}</td>
                <td>${ticket.completed_at}</td>
                <td>${ticket.status}</td>
                <td>${ticket.admin_name || 'N/A'}</td>  <!-- Confirmed By Column -->
                <td>
                    <img src="${imageSrc}" alt="Ticket Image" width="50" height="50" />
                </td>`;
            return row;
        }

        loadTickets();
    });
</script>


</body>

</html>