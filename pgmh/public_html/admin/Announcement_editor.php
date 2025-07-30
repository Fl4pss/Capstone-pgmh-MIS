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
    <title>Announcements</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="admin_dashboard.php">Admin Dashboard</a>
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
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="../index.html">Logout</a></li>
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
                        <a class="nav-link" href="admin_dashboard.php">
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
                                <a class="nav-link" href="E-bulletin.php">Media</a>
                                <a class="nav-link" href="Announcement_editor.php">Announcements</a>
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
                                        <a class="nav-link" href="residents/mail.php">Mail</a>
                                        <a class="nav-link" href="residents/facility_reservation.php">Facility</a>
                                        <a class="nav-link"
                                            href="residents/maintenance_tickets/maintenance_tickets.php">Maintenance</a>
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
                                        <a class="nav-link" href="visitors/visitor_ticket.php">Mail</a>
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
                                    href="residents/residents_management/residents_registration.php">Registration</a>
                                <a class="nav-link" href="residents/residents_management/resident_table.php">User
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
                    <h1 class="mt-4">Announcements</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="admin_dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Announcements</li>
                    </ol>
                    <div class="card mb-2">
                        <div class="card-body">
                            <div class="custom-tabs-container">
                                <ul class="nav nav-tabs" id="customTab2" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active" id="tab-oneA" data-bs-toggle="tab" href="#oneA"
                                            role="tab" aria-controls="oneA" aria-selected="true">Create Announcement</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="tab-twoA" data-bs-toggle="tab" href="#twoA" role="tab"
                                            aria-controls="twoA" aria-selected="false">Current Announcements</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="tab-threeA" data-bs-toggle="tab" href="#threeA"
                                            role="tab" aria-controls="threeA" aria-selected="false">Pending
                                            Announcements</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="tab-fourA" data-bs-toggle="tab" href="#fourA" role="tab"
                                            aria-controls="fourA" aria-selected="false">Archived
                                            Announcements</a>
                                    </li>
                                </ul>
                                <div class="tab-content h-350">
                                    <div class="tab-pane fade show active" id="oneA" role="tabpanel">
                                        <div class="card mb-4">
                                            <div class="card-header">
                                                <i class="fas fa-table me-1"></i>
                                                Create Announcement
                                            </div>
                                            <div class="card-body">
                                                <form id="announcementForm" action="process_announcement.php"
                                                    method="post">
                                                    <div class="form-group">
                                                        <label for="inputTitle">Title</label>
                                                        <input type="text" class="form-control" id="inputTitle"
                                                            name="inputTitle" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputContent">Content</label>
                                                        <textarea class="form-control" id="inputContent"
                                                            name="inputContent" rows="5" required></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputStartDate">Start Date</label>
                                                        <input type="date" class="form-control" id="inputStartDate"
                                                            name="inputStartDate" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputStartTime">Start Time</label>
                                                        <input type="time" class="form-control" id="inputStartTime"
                                                            name="inputStartTime" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputEndDate">End Date</label>
                                                        <input type="date" class="form-control" id="inputEndDate"
                                                            name="inputEndDate" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputEndTime">End Time</label>
                                                        <input type="time" class="form-control" id="inputEndTime"
                                                            name="inputEndTime" required>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary"
                                                        id="postButton">Post</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="twoA" role="tabpanel">
                                        <div class="card-body">
                                            <div class="card mb-4">
                                                <div class="card-header">
                                                    <i class="fas fa-table me-1"></i>
                                                    Announcements
                                                </div>
                                                <div class="card-body">
                                                    <table id="currentAnnouncementList" class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>Title</th>
                                                                <th>Content</th>
                                                                <th>Start Date</th>
                                                                <th>Start Time</th>
                                                                <th>End Date</th>
                                                                <th>End Time</th>
                                                                <th>created_at</th>
                                                                <th>status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="currentAnnouncementTable">
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="threeA" role="tabpanel">
                                        <div class="card-body">
                                            <div class="card-header">
                                                <i class="fas fa-table me-1"></i>
                                                Pending Announcements
                                            </div>
                                            <div class="card-body">
                                                <table id="pendingAnnouncementList" class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Title</th>
                                                            <th>Content</th>
                                                            <th>Start Date</th>
                                                            <th>Start Time</th>
                                                            <th>End Date</th>
                                                            <th>End Time</th>
                                                            <th>created_at</th>
                                                            <th>status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="pendingAnnouncementTable">

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="fourA" role="tabpanel">
                                        <div class="card-body">
                                            <div class="card-header">
                                                <i class="fas fa-table me-1"></i>
                                                Archived Announcements
                                            </div>
                                            <div class="card-body">
                                                <table id="archivedAnnouncementList" class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Title</th>
                                                            <th>Content</th>
                                                            <th>Start Date</th>
                                                            <th>Start Time</th>
                                                            <th>End Date</th>
                                                            <th>End Time</th>
                                                            <th>Archived at</th>
                                                            <th>status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="archivedAnnouncementTable">
                                                    </tbody>
                                                </table>
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
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const announcementForm = document.getElementById("announcementForm");

            announcementForm.addEventListener("submit", function (event) {
                if (!confirm("Are you sure you want to post this announcement?")) {
                    event.preventDefault(); // Prevent form submission
                }
            });

            function archiveAnnouncement(id, row) {
                fetch(`archive_announcement.php?id=${id}`)
                    .then(response => response.text())
                    .then(message => {
                        alert(message);
                        row.remove();
                    })
                    .catch(error => console.error('Error:', error));
            }


            function addArchiveButton(row, id) {
                const archiveButton = document.createElement('button');
                archiveButton.innerText = 'Archive';
                archiveButton.classList.add('btn', 'btn-danger', 'btn-sm');
                archiveButton.addEventListener('click', () => archiveAnnouncement(id, row));

                const actionCell = row.insertCell(-1);
                actionCell.appendChild(archiveButton);
            }

            function fetchData(url) {
                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(item => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                        <td>${item.id}</td>
                        <td>${item.title}</td>
                        <td>${item.content}</td>
                        <td>${item.start_date}</td>
                        <td>${item.start_time}</td>
                        <td>${item.end_date}</td>
                        <td>${item.end_time}</td>
                        <td>${item.created_at}</td>
                        <td>${item.status}</td>
                    `;

                            if (item.status === 'Pending') {
                                document.getElementById('pendingAnnouncementTable').appendChild(row);
                                addArchiveButton(row, item.id); // Add archive button to the row
                            } else if (item.status === 'Active') {
                                document.getElementById('currentAnnouncementTable').appendChild(row);
                                addArchiveButton(row, item.id); // Add archive button to the row
                            } else if (item.status === 'Archived') {
                                document.getElementById('archivedAnnouncementTable').appendChild(row);
                            }
                        });
                    })
                    .catch(error => console.error('Error:', error));
            }

            fetchData('fetch_announcement.php');
        });

    </script>
</body>

</html>