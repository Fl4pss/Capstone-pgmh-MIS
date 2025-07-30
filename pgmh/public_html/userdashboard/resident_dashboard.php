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
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard - User</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">

<style>
/* Floating button styles */
.floating-button {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 50%;
    width: 60px;
    height: 60px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    font-size: 24px;
    cursor: pointer;
    z-index: 1000;
}

/* Chatbot modal styles */
.chatbot-modal {
    display: none;
    position: fixed;
    bottom: 90px;
    right: 20px;
    background-color: white;
    border: 1px solid #ddd;
    border-radius: 10px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
    width: 300px;
    max-height: 400px;
    overflow: hidden;
    z-index: 1000;
}

.chatbot-header {
    padding: 10px;
    background-color: #007bff;
    color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.chatbot-body {
    padding: 10px;
    display: flex;
    flex-direction: column;
    height: 300px;
}

#chatbot-messages {
    flex: 1;
    overflow-y: auto;
    margin-bottom: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 5px;
}

#chatbot-input {
    flex: 0;
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 5px;
}

#chatbot-send {
    margin-top: 5px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    padding: 5px 10px;
    cursor: pointer;
}

.close-button {
    background: none;
    border: none;
    color: white;
    font-size: 16px;
    cursor: pointer;
}
</style>


<!-- Floating Chatbot Button -->
<div id="chatbot-container">
    <button id="chatbot-toggle" class="floating-button">
        <i class="fa-solid fa-comments"></i>
    </button>
    <div id="chatbot-modal" class="chatbot-modal">
        <div class="chatbot-header">
            <span>ChatBot</span>
            <button id="close-chatbot" class="close-button">&times;</button>
        </div>
        <div class="chatbot-body">
            <div id="chatbot-messages"></div>
            <input type="text" id="chatbot-input" placeholder="Type your message..." />
            <button id="chatbot-send">Send</button>
        </div>
    </div>
</div>


<script>
document.getElementById('chatbot-toggle').addEventListener('click', function() {
    const modal = document.getElementById('chatbot-modal');
    modal.style.display = modal.style.display === 'block' ? 'none' : 'block';
});

document.getElementById('close-chatbot').addEventListener('click', function() {
    document.getElementById('chatbot-modal').style.display = 'none';
});

document.getElementById('chatbot-send').addEventListener('click', function () {
    const input = document.getElementById('chatbot-input');
    const message = input.value.trim();
    if (message) {
        const messagesDiv = document.getElementById('chatbot-messages');

        // Display user's message with "You" styled in primary color
        const userMessage = document.createElement('div');
        userMessage.innerHTML = `<strong class="text-primary">You:</strong> ${message}`;
        messagesDiv.appendChild(userMessage);

        // Send the user's input to the Groq AI API
        fetch('https://api.groq.com/openai/v1/chat/completions', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer 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`
            },
            body: JSON.stringify({
                model: 'llama3-8b-8192',
                messages: [{ role: 'user', content: message }]
            })
        })
            .then(response => response.json())
            .then(data => {
                const botMessage = document.createElement('div');
                botMessage.textContent = "Bot: " + data.choices[0].message.content;
                messagesDiv.appendChild(botMessage);
                messagesDiv.scrollTop = messagesDiv.scrollHeight;
            })
            .catch(error => {
                console.error('Error:', error);
                const errorMessage = document.createElement('div');
                errorMessage.textContent = "Bot: Sorry, something went wrong.";
                messagesDiv.appendChild(errorMessage);
            });

        input.value = '';
        messagesDiv.scrollTop = messagesDiv.scrollHeight;
    }
});

</script>

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
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
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
                    <h1 class="mt-4">Dashboard</h1>
                    <div class="row">
                        <div class="row">
                            <div class="col-xl-8">
                                <div class="card mb-2">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area me-1"></i>
                                        News
                                        <div id="carouselExampleAutoplaying" class="carousel slide"
                                            data-bs-ride="carousel">
                                            <div class="carousel-inner" style="height: 500px;">
                                                <!-- Images will be dynamically loaded here -->
                                            </div>
                                            <button class="carousel-control-prev" type="button"
                                                data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Previous</span>
                                            </button>
                                            <button class="carousel-control-next" type="button"
                                                data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Next</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="card mb-4">
                                            <div class="card-header">
                                                <i class="fas fa-chart-bar me-1"></i>
                                                Announcement
                                            </div>
                                            <div class="accordion" id="accordionPanelsStayOpenExample">
                                                <!-- Announcement content will be dynamically loaded here -->
                                            </div>
                                            <div class="card-body">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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

                        </div>
                        
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
    <script src="js/scripts.js"></script>
    <script>
        window.addEventListener('DOMContentLoaded', (event) => {
            // Fetch announcements
            fetch('fetch_announcements.php')
                .then(response => response.text())
                .then(data => {
                    document.getElementById('accordionPanelsStayOpenExample').innerHTML = data;
                })
                .catch(error => console.error('Error fetching announcements:', error));

            fetch('fetch_mail_count.php')
                .then(response => response.text())
                .then(count => {
                    document.getElementById('recentMailBadge').textContent = count;
                })
                .catch(error => console.error('Error fetching mail count:', error));

            // Fetch images
            fetch('get_images.php')
                .then(response => response.json())
                .then(data => {
                    const carouselInner = document.querySelector('.carousel-inner');
                    data.forEach((imageUrl, index) => {
                        const carouselItem = document.createElement('div');
                        carouselItem.classList.add('carousel-item');
                        if (index === 0) {
                            carouselItem.classList.add('active');
                        }
                        const img = document.createElement('img');
                        img.src = imageUrl;
                        img.classList.add('d-block', 'w-100');
                        img.alt = `Image ${index + 1}`;
                        carouselItem.appendChild(img);
                        carouselInner.appendChild(carouselItem);
                    });
                })
                .catch(error => console.error('Error fetching images:', error));

        });
    </script>
<!-- Your HTML content -->

<!-- Place the script here just before closing </body> tag -->
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


<script>
    document.getElementById('postForm').addEventListener('submit', function (event) {
        event.preventDefault();
        
        const formData = new FormData(this);

        fetch('handle_forum.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                loadPosts(); // Refresh posts after success
                this.reset(); // Clear form fields
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    });
</script>

 <!-- Terms and Conditions Modal -->
    <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="termsModalLabel">Terms and Conditions</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6>1. Introduction</h6>
                    <p>Welcome to Peninsula Garden Midtown Homes Condominium. By accessing or using our website, you agree to comply with and be bound by these Terms and Conditions ("Terms"). If you do not agree with any part of these Terms, please do not use our website.</p>
                    <h6>2. Use of Our Website</h6>
                    <p>You agree to use our website for lawful purposes only and in a way that does not infringe the rights of, restrict, or inhibit anyone else's use and enjoyment of the website. Prohibited behavior includes, but is not limited to, harassing or causing distress or inconvenience to any other user, transmitting obscene or offensive content, or disrupting the normal flow of dialogue within our website.</p>
                    <h6>3. Changes to These Terms</h6>
                    <p>We reserve the right to update or modify these Terms at any time without prior notice. Your continued use of our website following any changes constitutes your acceptance of the new Terms.</p>
                    <h6>4. Contact Us</h6>
                    <p>If you have any questions or concerns about these Terms, please contact us at <a href="mailto:peninsulahomes@gmail.com">peninsulahomes@gmail.com</a>.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

</body>

</html>