<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar - CounselHub</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&family=Roboto&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
    <link rel="stylesheet" href="/frontend/components/customer/header/navBar.css">
</head>

<body>
    <div class="top-bar">
        <span>Call Us: +90 (212) 455-1248 | Email: info@counselhub.com</span>
    </div>

    <nav class="navbar" id="navbar">
        <a href="/frontend/pages/customer/HomePage.php" class="logo">CounselHub</a>
        <ul id="nav-links">
            <li><a href="/frontend/pages/customer/HomePage.php">Home</a></li>
            <li><a href="/frontend/pages/search_attorney.php">Attorneys</a></li>
            <li><a href="/frontend/pages/customer/MyCases.php">My Cases</a></li>
            <li><a href="/frontend/pages/customer/About.php">About</a></li>
            <li><a href="/frontend/pages/customer/Blog.php">Blog</a></li>
            <li><a href="/frontend/pages/customer/Vision.php">Vision</a></li>
            <li class="logout"><a href="/frontend/pages/signin/index.php">Log Out</a></li>
        </ul>
        <div class="hamburger" id="hamburger" aria-label="Open navigation menu" role="button" tabindex="0">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </div>
    </nav>
    <div class="nav-overlay" id="nav-overlay">
        <div class="close-btn" id="close-btn" aria-label="Close navigation menu" role="button" tabindex="0">
            <div class="close-line"></div>
        </div>
        <h2>Menu</h2>
        <ul>
            <li><a href="/frontend/pages/customer/HomePage.php">Home</a></li>
            <li><a href="/frontend/pages/search_attorney.php">Attorneys</a></li>
            <li><a href="/frontend/pages/customer/MyCases.php">My Cases</a></li>
            <li><a href="/frontend/pages/customer/About.php">About</a></li>
            <li><a href="/frontend/pages/customer/Blog.php">Blog</a></li>
            <li><a href="/frontend/pages/customer/Vision.php">Vision</a></li>
            <li class="logout"><a href="/frontend/pages/signin/index.php">Log Out</a></li>
        </ul>
    </div>

    <script src="/frontend/components/customer/header/navBar.js"></script> 

</body>

</html>
