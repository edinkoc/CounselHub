<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Family Law Services</title>
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
            <h1>Family Law Services</h1>
        </header>
        <main>
            <div class="image-container">
                <img src="https://www.westoverlaw.com/wp-content/uploads/2021/01/introduction-to-family-law-2.png" alt="Family Law Services" class="main-image">
            </div>
            <h2>About Our Family Law Services</h2>
            <p>We provide expert guidance in family law matters, ensuring that you are supported during life’s most challenging times. Our services include:</p>
            <ul>
                <li><strong>Divorce:</strong> Providing assistance in navigating divorce proceedings with a focus on equitable solutions.</li>
                <li><strong>Child Custody:</strong> Ensuring the best interests of your children are prioritized in custody agreements.</li>
                <li><strong>Spousal Support:</strong> Offering advice on alimony and financial support matters.</li>
                <li><strong>Adoption:</strong> Guiding you through the adoption process with legal precision and care.</li>
            </ul>
            <p>With years of experience, we are dedicated to protecting your rights and ensuring the best outcomes for your family. Our compassionate approach ensures peace of mind as we help you navigate complex family law issues.</p>
        </main>
        <footer>
            &copy; <?php echo date("Y"); ?> CounselHub. All Rights Reserved.
        </footer>
    </div>
    <?php include_once "../../components/customer/footer/footer.php"; ?>
</body>
</html>
