<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo $css_path; ?>">
    <title>CounselHub Footer</title>
</head>
<style>
    .footer-container {
        max-width: 100vw;
        background-color: #a8896c;
        padding: 3rem 5rem;
        font-family: Arial, sans-serif;
        color: #fff;
    }

    .footersection {
        display: flex;
        justify-content: center;
        gap: 4rem;
        flex-wrap: wrap;
        align-items: flex-start;
        text-align: center;
    }

    .footercolumn {
        flex: 1;
        min-width: 250px;
    }

    .footercolumn h4 {
        font-size: 1.4rem;
        margin-bottom: 1rem;
        color: #fff;
        font-weight: bold;
    }

    .footerlinks a {
        display: block;
        margin-bottom: 0.5rem;
        text-decoration: none;
        color: #f0e5d2;
        font-size: 1rem;
        transition: color 0.3s ease;
    }

    .footerlinks a:hover {
        color: #ffe0a6;
        text-decoration: underline;
    }

    .mapcontainer {
        margin-top: -3rem;
        text-align: center;
    }

    .mapframe iframe {
        border-radius: 8px;
        width: 300px; 
        height: 200px;
    }

    .socialmedia-column {
        text-align: center;
    }

    .socialmedia {
        display: flex;
        gap: 15px;
        justify-content: center;
        align-items: center;
        margin-top: 1.5rem;
    }

    .socialmedia img {
        width: 40px;
        height: 40px;
        transition: transform 0.3s ease, filter 0.3s ease;
    }

    .socialmedia img:hover {
        transform: scale(1.1);
        filter: brightness(1.2);
    }

    .footerbelow {
        margin-top: 2rem;
        border-top: 1px solid #fff;
        padding-top: 1rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
    }

    .footerbelowlinks a {
        margin-right: 1rem;
        font-size: 0.9rem;
        color: #f0e5d2;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .footerbelowlinks a:hover {
        color: #ffe0a6;
        text-decoration: underline;
    }

    .footercopyright {
        font-size: 0.9rem;
        color: #f0e5d2;
        margin-bottom: 0.5rem;
        flex: 1 100%;
        text-align: center;
    }
     hr {
        border: none; 
        border-top: 0px solid #f0e5d2; 
    }
</style>
<body>
    <footer class="footer-container">
        <div class="footersection">
            <div class="footercolumn">
                <h4>Legal Services</h4>
                <div class="footerlinks">
                    <a href="/frontend/pages/customer/family-law.php">Family Law</a>
                    <a href="/frontend/pages/customer/corporate-law.php">Corporate Law</a>
                    <a href="/frontend/pages/customer/intellectual-property.php">Intellectual Property</a>
                </div>
            </div>
            <div class="footercolumn">
                <h4>Resources</h4>
                <div class="footerlinks">
                    <a href="/frontend/pages/customer/OurWorks.php">Our Work</a>
                    <a href="/frontend/pages/customer/Services.php">Services</a>
                    <a href="/frontend/pages/customer/FAQ.php">FAQ</a>
                </div>
            </div>
            <div class="footercolumn">
                <h4>Company</h4>
                <div class="footerlinks">
                    <a href="/frontend/pages/customer/About.php">About Us</a>
                    <a href="/frontend/pages/customer/Blog.php">Blog</a>
                    <a href="/frontend/pages/customer/Contact.php">Contact</a>
                </div>
            </div>
            <div class="footercolumn mapcontainer">
                <h4>Location</h4>
                <div class="mapframe">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3010.007840947401!2d28.9568305!3d41.0250844!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14cab9f12ab56e17%3A0x9485bbf687d7cbfd!2sKadir%20Has%20%C3%9Cniversitesi!5e0!3m2!1str!2str!4v1733059404464!5m2!1str!2str"
                        width="250"
                        height="200"
                        style="border: 0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        title="Location Map">
                    </iframe>
                </div>
            </div>
            <div class="footercolumn socialmedia-column">
                <h4>Follow Us</h4>
                <div class="socialmedia">
                    <a href="https://www.facebook.com/Khasedutr">
                        <img src="/frontend/assets/components/customer/footer/Facebook.png" alt="Facebook">
                    </a>
                    <a href="https://www.instagram.com/Khasedutr/">
                        <img src="/frontend/assets/components/customer/footer/Instagram.png" alt="Instagram">
                    </a>
                    <a href="https://twitter.com/Khasedutr">
                        <img src="/frontend/assets/components/customer/footer/Twitter1.png" alt="Twitter">
                    </a>
                    <a href="https://www.tiktok.com/@Khasedutr">
                        <img src="/frontend/assets/components/customer/footer/Tiktok.png" alt="TikTok">
                    </a>
                </div>
            </div>
        </div>
        <hr />
        <div class="footerbelow">
            <div class="footercopyright">
                &copy; <?php echo date('Y'); ?> CounselHub. All Rights Reserved.
            </div>
            <div class="footerbelowlinks">
                <a href="/frontend/pages/customer/terms.php">Terms & Conditions</a>
                <a href="/frontend/pages/customer/privacy.php">Privacy</a>
                <a href="/frontend/pages/customer/security.php">Security</a>
                <a href="/frontend/pages/customer/cookie.php">Cookie Declaration</a>
            </div>
        </div>
    </footer>
</body>
</html>
