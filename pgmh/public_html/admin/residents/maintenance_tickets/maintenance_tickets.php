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
    <link href="../../css/styles.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" rel="stylesheet">
S
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
                    <li><a class="dropdown-item" href="../../../index.html">Logout</a></li>
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
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            News & Announcements
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="../../E-bulletin.php">Media</a>
                                <a class="nav-link" href="../../Announcement_editor.php">Announcements</a>
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
                                        <a class="nav-link" href="../../residents/mail.php">Mail</a>
                                        <a class="nav-link" href="../facility_reservation.php">Facility</a>
                                        <a class="nav-link"
                                            href="../maintenance_tickets/maintenance_tickets.php">Maintenance</a>
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
                                    href="../residents_management/residents_registration.php">Registration</a>
                                <a class="nav-link" href="../residents_management/resident_table.php">User Table</a>
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
                    <ul class="nav nav-tabs" id="customTab2" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="tab-oneA" data-bs-toggle="tab" href="#oneA" role="tab"
                                aria-controls="oneA" aria-selected="true">Active Tickets</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="tab-twoA" data-bs-toggle="tab" href="#twoA" role="tab"
                                aria-controls="twoA" aria-selected="false">Completed Tickets</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="tab-threeA" data-bs-toggle="tab" href="#threeA" role="tab"
                                aria-controls="threeA" aria-selected="false">Archived Tickets</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="tab-fourA" data-bs-toggle="tab" href="#fourA" role="tab"
                                aria-controls="fourA" aria-selected="false">Create Ticket</a>
                        </li>
                    </ul>
                    <div class="tab-content h-350">
                        <!-- Active Tickets Tab -->
                        <div class="tab-pane fade show active" id="oneA" role="tabpanel">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-table me-1"></i>
                                    Active Tickets
                                </div>
                                <div class="card-body">
                                    <table id="maintenanceDatatable" class="table">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Description</th>
                                                <th>Urgency</th>
                                                <th>Location</th>
                                                <th>Issue</th>
                                                <th>Created at</th>
                                                <th>Status</th>
                                                <th>Image</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="activeTableBody"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Completed Tickets Tab -->
                        <div class="tab-pane fade" id="twoA" role="tabpanel">
                            <div class="card-body">
                                <h2>Completed Tickets</h2>
                                <table id="completedDatatable" class="table">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Description</th>
                                            <th>Urgency</th>
                                            <th>Location</th>
                                            <th>Issue</th>
                                            <th>Created at</th>
                                            <th>Completed at</th>
                                            <th>Status</th>
                                            <th>Confirmed By</th>
                                            <th>Image</th>
                                        </tr>
                                    </thead>
                                    <tbody id="completedTableBody"></tbody>
                                </table>
                                <button id="printButton" class="btn btn-primary">Print Table</button>
                            </div>
                        </div>

                        <!-- Archived Tickets Tab -->
                        <div class="tab-pane fade" id="threeA" role="tabpanel">
                            <div class="card-body">
                                <h2>Archived Tickets</h2>
                                <table id="archiveDatatable" class="table">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Description</th>
                                            <th>Urgency</th>
                                            <th>Location</th>
                                            <th>Issue</th>
                                            <th>Created at</th>
                                            <th>Status</th>
                                            <th>Image</th>
                                        </tr>
                                    </thead>
                                    <tbody id="archiveTableBody"></tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Create Ticket Tab -->
                        <div class="tab-pane fade" id="fourA" role="tabpanel">
                            <div class="card-body">
<h2>Create Ticket</h2>
<form id="createTicketForm" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="ticketName" class="form-label">Name</label>
        <input type="text" class="form-control" id="ticketName" name="name" required>
    </div>
    <div class="mb-3">
        <label for="ticketEmail" class="form-label">Email</label>
        <input type="email" class="form-control" id="ticketEmail" name="email" required>
    </div>
    <div class="mb-3">
        <label for="ticketDescription" class="form-label">Description</label>
        <textarea class="form-control" id="ticketDescription" name="description" required></textarea>
    </div>
    <div class="mb-3">
        <label for="ticketUrgency" class="form-label">Urgency</label>
        <select class="form-control" id="ticketUrgency" name="urgency" required>
            <option value="Low">Low</option>
            <option value="Moderate">Moderate</option>
            <option value="High">High</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="ticketLocation" class="form-label">Location</label>
        <input type="text" class="form-control" id="ticketLocation" name="location" required>
    </div>
    <div class="mb-3">
        <label for="ticketIssue" class="form-label">Issue</label>
        <input type="text" class="form-control" id="ticketIssue" name="type" required>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
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
    <script src="../../js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/js/bootstrap.bundle.min.js"
        integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl5+z24U8AB+8M2kIcy5PVW39d+6B6q5fZfLh8KuuF"
        crossorigin="anonymous"></script>

        <script>
    document.addEventListener('DOMContentLoaded', function () {
        const urlParams = new URLSearchParams(window.location.search);
        const urgencyFilter = urlParams.get('urgency');

        // Object to temporarily store urgency updates before final submission
        const pendingUrgencyUpdates = {};

        function loadTickets() {
            fetch('maintenance_data.php')
                .then(response => response.json())
                .then(data => {
                    const activeTableBody = document.getElementById('activeTableBody');
                    const completedTableBody = document.getElementById('completedTableBody');
                    const archiveTableBody = document.getElementById('archiveTableBody');
                    activeTableBody.innerHTML = '';
                    completedTableBody.innerHTML = '';
                    archiveTableBody.innerHTML = '';

                    data.active_and_archived_tickets
                        .filter(ticket => !urgencyFilter || ticket.urgency === urgencyFilter)
                        .forEach(ticket => {
                            const row = createTicketRow(ticket);
                            if (ticket.status === 'Pending') {
                                activeTableBody.appendChild(row);
                            } else if (ticket.status === 'Archived') {
                                archiveTableBody.appendChild(row);
                            }
                        });

                    data.completed_tickets
                        .filter(ticket => !urgencyFilter || ticket.urgency === urgencyFilter)
                        .forEach(ticket => {
                            const row = createCompletedTicketRow(ticket);
                            completedTableBody.appendChild(row);
                        });

                    setupEventListeners();
                })
                .catch(error => console.error('Error loading tickets:', error));
        }

function createTicketRow(ticket) {
    const row = document.createElement('tr');
    const imageSrc = ticket.image ? `data:image/jpeg;base64,${ticket.image}` : '';
    const typeAndIssue = `${ticket.type}${ticket.other_issue ? ` (${ticket.other_issue})` : ''}`;

    row.innerHTML = `
        <td>${ticket.name}</td>
        <td>${ticket.email}</td>
        <td>${ticket.description}</td>
        <td class="urgency-cell">${ticket.urgency}</td>
        <td>${ticket.location}</td>
        <td>${typeAndIssue}</td> <!-- Combined Type and Other Issue -->
        <td>${ticket.created_at}</td>
        <td class="status-cell">${ticket.status}</td>
        <td>
            <img src="${imageSrc}" alt="Ticket Image" width="50" height="50" />
        </td>
        <td>
            ${ticket.status === 'Pending' ? `
                <button class="edit-btn btn btn-info" data-id="${ticket.id}">
                    <i class="fa-solid fa-pen-to-square"></i>
                </button>
                <button class="done-btn btn btn-success" data-id="${ticket.id}">Done</button>
                <button class="archive-btn btn btn-warning" data-id="${ticket.id}">
                    <i class="fa-solid fa-trash"></i>
                </button>
            ` : ''}
        </td>`;
    return row;
}


function createCompletedTicketRow(ticket) {
    const row = document.createElement('tr');
    const imageSrc = ticket.image ? `data:image/jpeg;base64,${ticket.image}` : '';
    const typeAndIssue = `${ticket.type}${ticket.other_issue ? ` (${ticket.other_issue})` : ''}`;

    row.innerHTML = `
        <td>${ticket.name}</td>
        <td>${ticket.email}</td>
        <td>${ticket.description}</td>
        <td>${ticket.urgency}</td>
        <td>${ticket.location}</td>
        <td>${typeAndIssue}</td> <!-- Combined Type and Other Issue -->
        <td>${ticket.created_at}</td>
        <td>${ticket.completed_at}</td>
        <td>${ticket.status}</td>
        <td>${ticket.admin_name || 'N/A'}</td> <!-- Confirmed By Column -->
        <td>
            <img src="${imageSrc}" alt="Ticket Image" width="50" height="50" />
        </td>`;
    return row;
}

        function setupEventListeners() {
            document.querySelectorAll('.edit-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const row = this.closest('tr');
                    const urgencyCell = row.querySelector('.urgency-cell');
                    const ticketId = this.getAttribute('data-id');

                    if (!urgencyCell.querySelector('select')) {
                        const currentUrgency = urgencyCell.textContent.trim();
                        urgencyCell.innerHTML = `
                            <select class="urgency-dropdown">
                                <option value="Low" ${currentUrgency === 'Low' ? 'selected' : ''}>Low</option>
                                <option value="Moderate" ${currentUrgency === 'Moderate' ? 'selected' : ''}>Moderate</option>
                                <option value="High" ${currentUrgency === 'High' ? 'selected' : ''}>High</option>
                            </select>
                            <button class="save-btn btn btn-primary btn-sm" data-id="${ticketId}">Save</button>
                        `;
                        setupSaveEvent();
                    }
                });
            });

            document.querySelectorAll('.done-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const id = this.getAttribute('data-id');
                    handleDoneAction(id);
                });
            });

            document.querySelectorAll('.archive-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const id = this.getAttribute('data-id');
                    showModalConfirmation(id, 'archive');
                });
            });

            // Setup print button event listener
            document.getElementById('printButton').addEventListener('click', printTickets);
        }

        function setupSaveEvent() {
            document.querySelectorAll('.save-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const row = this.closest('tr');
                    const urgencyDropdown = row.querySelector('.urgency-dropdown');
                    const ticketId = this.getAttribute('data-id');
                    const newUrgency = urgencyDropdown.value;

                    // Save the urgency change locally
                    pendingUrgencyUpdates[ticketId] = newUrgency;

                    // Replace the dropdown with the selected value
                    const urgencyCell = row.querySelector('.urgency-cell');
                    urgencyCell.innerHTML = newUrgency;

                    // Notify the user that the urgency will be updated upon clicking "Done"
                    alert(`Urgency updated locally for Ticket ID: ${ticketId}. Click "Done" to confirm changes.`);
                });
            });
        }

        function handleDoneAction(ticketId) {
            const newUrgency = pendingUrgencyUpdates[ticketId] || null;

            const payload = `id=${ticketId}&action=done${newUrgency ? `&urgency=${newUrgency}` : ''}`;
            
            fetch('maintenance_data.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: payload
            })
            .then(response => response.json())
            .then(result => {
                if (result.status === 'success') {
                    delete pendingUrgencyUpdates[ticketId];
                    loadTickets();
                } else {
                    console.error('Error marking ticket as completed:', result.message);
                }
            })
            .catch(error => console.error('Network error:', error));
        }

        function showModalConfirmation(id, action) {
            const confirmActionBtn = document.getElementById('confirmActionBtn');
            confirmActionBtn.onclick = function () {
                $('#confirmationModal').modal('hide');
                if (action === 'archive') {
                    archiveTicket(id);
                }
            };
            $('#confirmationModal').modal('show');
        }

        function archiveTicket(id) {
            fetch('maintenance_data.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `id=${id}&action=archive`
            })
            .then(response => response.json())
            .then(result => {
                if (result.status === 'success') {
                    loadTickets();
                } else {
                    console.error('Error archiving ticket:', result.message);
                }
            })
            .catch(error => console.error('Network error:', error));
        }

        // Function to print the completed tickets table
        function printTickets() {
    const completedTable = document.getElementById('completedTableBody');
    const printWindow = window.open('', '', 'height=600,width=800');
    printWindow.document.write('<html><head><title>Completed Tickets</title>');
    printWindow.document.write('<style>body { font-family: Arial, sans-serif; }');
    printWindow.document.write('table { width: 100%; border-collapse: collapse; margin: 20px 0; }');
    printWindow.document.write('td, th { border: 1px solid #ddd; padding: 8px; text-align: left; }');
    printWindow.document.write('th { background-color: #f2f2f2; }');
    printWindow.document.write('img { filter: none; width: 50px; height: 50px; }'); // Ensures no grayscale filter is applied
    printWindow.document.write('</style></head><body>');
    printWindow.document.write('<h2>Completed Tickets</h2>');
    printWindow.document.write('<table><thead><tr><th>ID</th><th>Name</th><th>Description</th><th>Urgency</th><th>Location</th><th>Type</th><th>Other Issue</th><th>Created At</th><th>Completed At</th><th>Status</th><th>Confirmed By</th><th>Image</th></tr></thead><tbody>');

    completedTable.querySelectorAll('tr').forEach(row => {
        const imageCell = row.querySelector('td img');
        const imageSrc = imageCell ? imageCell.src : '';

        printWindow.document.write('<tr>' + row.innerHTML.replace(imageSrc, `<img src="${imageSrc}" alt="Ticket Image" style="filter: none; width: 50px; height: 50px;" />`) + '</tr>');
    });

    printWindow.document.write('</tbody></table>');
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
}


        loadTickets();
    });
</script>

    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to proceed with this action?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmActionBtn">Confirm</button>
                </div>
            </div>
        </div>
    </div>
<div id="imageModal" class="modal">
    <span class="close">&times;</span>
    <img class="modal-content" id="modalImage">
    <div id="caption"></div>
</div>
<script>
    function showModal(img) {
        var modal = document.getElementById('imageModal');
        var modalImg = document.getElementById("modalImage");
        var captionText = document.getElementById("caption");
        modal.style.display = "block";
        modalImg.src = img.src;
        captionText.innerHTML = img.alt;

        var span = document.getElementsByClassName("close")[0];
        span.onclick = function() { 
            modal.style.display = "none";
        }
    }
</script>

<style>
    /* Modal styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        padding-top: 100px;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0,0,0);
        background-color: rgba(0,0,0,0.9);
    }

    .modal-content {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
    }

    #caption {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
        text-align: center;
        color: #ccc;
        padding: 10px 0;
        height: 150px;
    }

    .close {
        position: absolute;
        top: 15px;
        right: 35px;
        color: #f1f1f1;
        font-size: 40px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: #bbb;
        text-decoration: none;
        cursor: pointer;
    }
</style>
<!-- Include Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Request Submitted</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalMessage">
                <!-- Success message will be dynamically inserted here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
<script>
document.getElementById('createTicketForm').addEventListener('submit', function (e) {
    e.preventDefault(); // Prevent default form submission

    const form = e.target;
    const formData = new FormData(form);

    fetch('process_maintenance_request.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                document.getElementById('modalMessage').textContent = data.message;
                const successModal = new bootstrap.Modal(document.getElementById('successModal'));
                successModal.show();

                // Optionally reset the form
                form.reset();
            } else {
                alert(data.message); // Handle error case
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An unexpected error occurred.');
        });
});
</script>

</body>

</html>