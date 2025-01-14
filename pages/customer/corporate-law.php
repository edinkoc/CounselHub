<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Corporate Law Services</title>
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
            <h1>Corporate Law Services</h1>
        </header>
        <main>
            <div class="image-container">
                <img src="https://www.dorukgoksu.av.tr/wp-content/uploads/2018/04/corporate-law-01-1110x550.jpg" alt="Corporate Law Services" class="main-image">
            </div>
            <h2>About Our Corporate Law Services</h2>
            <p>We provide comprehensive corporate law services, including assistance with company formation, compliance, and governance. Our expert legal team ensures your business remains legally secure and operates smoothly within the regulatory framework.</p>
            <ul>
                <li><strong>Company Formation:</strong> Assistance with setting up legal entities, including drafting and reviewing required documentation.</li>
                <li><strong>Mergers & Acquisitions:</strong> Legal guidance for acquisitions, mergers, and restructuring processes.</li>
                <li><strong>Corporate Governance:</strong> Advising on best practices for shareholder agreements and board management.</li>
                <li><strong>Regulatory Compliance:</strong> Helping businesses navigate local and international legal requirements.</li>
                <li><strong>Intellectual Property Protection:</strong> Securing your business assets like patents, trademarks, and copyrights.</li>
            </ul>
            <p>We aim to provide strategic legal support to businesses of all sizes, ensuring your operations are protected from legal challenges.</p>
        </main>
        <footer>
            &copy; <?php echo date("Y"); ?> CounselHub. All Rights Reserved.
        </footer>
    </div>
    <?php include_once "../../components/customer/footer/footer.php"; ?>
</body>
</html>
