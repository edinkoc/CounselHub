<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intellectual Property Services</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            color: #333;
            line-height: 1.8;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
        }

        header {
            text-align: center;
            margin-bottom: 30px;
        }

        header h1 {
            font-size: 2.5rem;
            color: #a8896c;
            margin-bottom: 10px;
        }

        main {
            margin-top: 20px;
        }

        main h2 {
            font-size: 2rem;
            color: #a8896c;
            margin-bottom: 15px;
            border-bottom: 2px solid #adb5bd;
            display: inline-block;
        }

        main p {
            font-size: 1.1rem;
            color: #495057;
            margin-bottom: 20px;
        }

        .image-container {
            text-align: center;
            margin-bottom: 30px;
        }

        .main-image {
            width: 650px;
            height: 400px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            object-fit: cover;
            border: 3px solid #dee2e6;
        }

        footer {
            text-align: center;
            margin-top: 30px;
            font-size: 0.9rem;
            color: #868e96;
        }
    </style>
</head>
<body>
    <?php include_once "../../components/customer/header/navBar.php"; ?>
    <div class="container">
        <header>
            <h1>Intellectual Property Services</h1>
        </header>
        <main>
            <div class="image-container">
                <img src="https://vethanlaw.com/wp-content/uploads/sites/644/2016/11/shutterstock_1807689193.webp" alt="Intellectual Property Services" class="main-image">
            </div>
            <h2>About Our Intellectual Property Services</h2>
            <p>Our Intellectual Property (IP) services are designed to protect your innovations and creations, ensuring that your rights are secure in today’s competitive markets. We assist with:</p>
            <ul>
                <li><strong>Patents:</strong> Protecting your inventions from unauthorized use or reproduction.</li>
                <li><strong>Trademarks:</strong> Securing your brand identity, including logos, slogans, and business names.</li>
                <li><strong>Copyrights:</strong> Safeguarding your creative works such as books, music, and software.</li>
                <li><strong>Trade Secrets:</strong> Helping you maintain the confidentiality of proprietary business information.</li>
            </ul>
            <p>Our team ensures your intellectual property remains protected, providing peace of mind and legal certainty while fostering innovation and creativity.</p>
        </main>
        <footer>
            &copy; <?php echo date("Y"); ?> CounselHub. All Rights Reserved.
        </footer>
    </div>
    <?php include_once "../../components/customer/footer/footer.php"; ?>
</body>
</html>
