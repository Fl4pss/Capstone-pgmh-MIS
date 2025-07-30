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
    <title>Mail</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="resident_dashboard.php">Peninsula Garden</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle"><i class="fas fa-bars"></i></button>
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." />
                <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
                <a class="d-flex p-3 position-relative" href="mail.php">
                    <i class="fas fa-envelope"></i>
                    <span id="recentMailBadge" class="badge bg-danger position-absolute top-80 start-50 translate-middle">0</span>
                </a>
            </div>
        </form>
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown">
                    <i class="fas fa-user fa-fw"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="user_settings.php">Settings</a></li>
                    <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                    <li><hr class="dropdown-divider" /></li>
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
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Request
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts">
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
                    <?php echo htmlspecialchars($full_name); ?>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Mail</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="resident_dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Mail</li>
                    </ol>
                    <div class="notification-container mt-4" id="mailNotifications">
                        <!-- Notifications will load here dynamically -->
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
        <!-- Modal -->
        <div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="notificationModalLabel">Notification Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalContent">
                    <!-- Additional details will be injected here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>

    <script>
document.addEventListener('DOMContentLoaded', () => {
    const notificationContainer = document.getElementById('mailNotifications');

    function loadNotifications() {
        fetch('mail_data.php')
            .then(response => response.text())
            .then(data => {
                try {
                    const jsonData = JSON.parse(data);
                    notificationContainer.innerHTML = '';
                    if (jsonData.error) {
                        notificationContainer.innerHTML = `<p>${jsonData.error}</p>`;
                        return;
                    }

                    if (jsonData.length === 0) {
                        notificationContainer.innerHTML = '<p>No notifications available.</p>';
                        return;
                    }

                    jsonData.forEach(notification => {
                        const notificationItem = document.createElement('div');
                        notificationItem.classList.add('notification-card', 'p-3', 'mb-3', 'bg-light', 'text-dark', 'rounded', 'clickable');
                        notificationItem.innerHTML = `
                            <div class="d-flex align-items-center">
                                <div class="notification-avatar me-3">
                                    <i class="fas fa-user-circle" style="font-size: 40px; color: black;"></i>
                                </div>
                                <div class="notification-content flex-grow-1">
                                    <div class="notification-from"><strong>${notification.admin_name || notification.resident_name || 'Admin'}</strong></div>
                                    <div class="notification-subject">${notification.notification_message}</div>
                                    <div class="notification-sent text-muted small">${notification.confirmed_at || notification.completed_at}</div>
                                </div>
                            </div>
                        `;
                        notificationItem.addEventListener('click', () => {
                            showModal(notification);
                        });
                        notificationContainer.appendChild(notificationItem);
                    });
                } catch (e) {
                    console.error('Error parsing JSON:', data);
                    notificationContainer.innerHTML = '<p>Error loading notifications.</p>';
                }
            })
            .catch(error => {
                console.error('Error fetching notifications:', error);
                notificationContainer.innerHTML = '<p>Error loading notifications.</p>';
            });
    }

    function showModal(notification) {
        const modalContent = document.getElementById('modalContent');
        modalContent.innerHTML = `
            <p><strong>From:</strong> ${notification.admin_name || notification.resident_name || 'Admin'}</p>
            <p><strong>Message:</strong> ${notification.notification_message}</p>
            <p><strong>Date:</strong> ${notification.confirmed_at || notification.completed_at}</p>
        `;
        const modal = new bootstrap.Modal(document.getElementById('notificationModal'));
        modal.show();
    }

    loadNotifications();
});

    </script>
</body>

</html>
