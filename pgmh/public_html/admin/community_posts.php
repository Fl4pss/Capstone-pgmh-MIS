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
    <title>Dashboard - SB Admin</title>
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
                    <li><a class="dropdown-item" href="#!">Activity Log</a></li>
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
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="visitors/visitor_request.php">Visit Requests</a>
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
                                    <a class="nav-link" href="residents/admin_management/admin_registration.php">Admin Registration</a>
                                <a class="nav-link" href="residents/residents_management/resident_table.php">User
                                    Table</a>
                            </nav>
                        </div>
                        <a class="nav-link" href="community_posts.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Posts
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
                                <div class="col-xl-12">
                                    <div class="card mb-4" style="max-width: 800px; margin: 0 auto;">
                                        <div class="card-header">
                                            <i class="fas fa-users me-1"></i>
                                            Community Forum
                                        </div>
                                        <div class="card-body">
                                            <!-- Post Submission Form -->
                                            <form id="postForm" action="handle_forum.php" method="POST" enctype="multipart/form-data">
                                                <div class="mb-3">
                                                    <textarea class="form-control" id="postContent" name="content" placeholder="Share something..." rows="3" required></textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <input type="file" class="form-control" id="postImage" name="image" accept="image/*">
                                                </div>
                                                <button type="submit" class="btn btn-primary">Post</button>
                                            </form>
                                            <hr>
                                
                                            <!-- Posts Container -->
                                            <div id="postsContainer">
                                                <!-- Posts will be dynamically loaded here -->
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const postsContainer = document.getElementById('postsContainer');

    // Load posts and populate the container
    function loadPosts() {
        fetch('fetch_posts.php')
            .then(response => response.json())
            .then(renderPosts)
            .catch(error => console.error('Error loading posts:', error));
    }

    // Render posts in the container
    function renderPosts(posts) {
        postsContainer.innerHTML = '';
        posts.forEach(post => {
            const postElement = createPostElement(post);
            postsContainer.appendChild(postElement);
        });
    }

    function createPostElement(post) {
        const postElement = document.createElement('div');
        postElement.classList.add('card', 'mb-3');
        postElement.innerHTML = `
            <div class="card-body">
                <h5>${post.author}</h5>
                <small>${timeAgo(post.created_at)}</small>
                <p>${post.content}</p>
                ${post.image ? `<img src="${post.image}" class="img-fluid mb-2">` : ''}
                <button class="btn btn-primary btn-sm like-button" data-post-id="${post.id}">
                    Like (${post.likes})
                </button>
                <button class="btn btn-secondary btn-sm comment-button" data-post-id="${post.id}">
                    Comments
                </button>
                <div id="commentsContainer-${post.id}" class="mt-3 collapse"></div>
            </div>
        `;
        return postElement;
    }

    // Event delegation for like buttons
    postsContainer.addEventListener('click', (e) => {
        if (e.target.matches('.like-button')) {
            const postId = e.target.dataset.postId;
            toggleLike(postId, e.target);
        }
    });

    // Global toggleLike function
    function toggleLike(postId, buttonElement) {
        const originalText = buttonElement.textContent;

        // Optimistic UI Update
        buttonElement.textContent = originalText.replace(/\d+/, match => parseInt(match) + 1);
        buttonElement.disabled = true;

        fetch('handle_interactions.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ action: 'like', post_id: postId }),
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'unliked') {
                    buttonElement.textContent = originalText.replace(/\d+/, match => parseInt(match) - 1);
                }
            })
            .catch(error => {
                console.error('Error toggling like:', error);
                alert('Failed to toggle like. Please try again.');
                buttonElement.textContent = originalText; // Revert to original text
            })
            .finally(() => {
                buttonElement.disabled = false;
            });
    }

    // Toggle comments section
    postsContainer.addEventListener('click', (e) => {
        if (e.target.matches('.comment-button')) {
            const postId = e.target.dataset.postId;
            toggleComments(postId);
        }
    });

    function toggleComments(postId) {
        const commentsContainer = document.getElementById(`commentsContainer-${postId}`);

        if (!commentsContainer.classList.contains('show')) {
            fetchComments(postId, commentsContainer);
        }

        commentsContainer.classList.toggle('show');
    }

    function fetchComments(postId, container) {
        fetch(`fetch_comments.php?post_id=${postId}`)
            .then(response => response.text())
            .then(data => {
                try {
                    const jsonData = JSON.parse(data);
                    if (jsonData.success) {
                        container.innerHTML = jsonData.html;

                        // Add an event listener for the comment form
                        const commentForm = container.querySelector('#commentForm');
                        if (commentForm) {
                            commentForm.addEventListener('submit', function (e) {
                                e.preventDefault();
                                submitComment(new FormData(this), postId, container);
                            });
                        }
                    } else {
                        container.innerHTML = `<p>${jsonData.message}</p>`;
                    }
                } catch (e) {
                    console.error('Error parsing JSON:', data); // Log server's raw response
                    container.innerHTML = `<p>Error: Could not load comments.</p>`;
                }
            })
            .catch(error => console.error('Error fetching comments:', error));
    }

    function submitComment(formData, postId, container) {
        fetch('add_comment.php', {
            method: 'POST',
            body: formData,
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    fetchComments(postId, container); // Reload comments after a successful submission
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => console.error('Error submitting comment:', error));
    }

    function timeAgo(datetime) {
        const time = new Date(datetime).getTime();
        const diff = Date.now() - time;

        if (diff < 60000) {
            return Math.floor(diff / 1000) + ' secs ago';
        } else if (diff < 3600000) {
            return Math.floor(diff / 60000) + ' mins ago';
        } else if (diff < 86400000) {
            return Math.floor(diff / 3600000) + ' hrs ago';
        } else {
            return Math.floor(diff / 86400000) + ' days ago';
        }
    }

    // Initialize
    loadPosts();
});
</script>
</body>

</html>