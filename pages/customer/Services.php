<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Services</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
            color: #333;
            line-height: 1.6;
            margin-top: 30px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        header {
            text-align: center;
            margin-bottom: 20px;
        }

        header h1 {
            font-size: 2.5rem;
            color: #a8896c;
            margin-bottom: 10px;
        }

        header p {
            font-size: 1.2rem;
            color: #555;
        }

        section {
            margin-top: 30px;
        }

        section h2 {
            font-size: 1.8rem;
            color: #a8896c;
            margin-bottom: 15px;
            border-bottom: 2px solid #ddd;
            display: inline-block;
        }

        section p, ul {
            font-size: 1rem;
            color: #555;
            margin-bottom: 15px;
        }

        ul {
            list-style: disc;
            margin-left: 20px;
        }

        ul li {
            margin-bottom: 10px;
        }

        footer {
            text-align: center;
            margin-top: 30px;
            font-size: 0.9rem;
            color: #aaa;
        }
    </style>
</head>
<body>
    <?php include_once "../../components/customer/header/navBar.php"; ?>
    <div class="container">
        <header>
            <h1>Our Services</h1>
            <p>Discover the wide range of legal and consulting services we offer to help you achieve your goals.</p>
        </header>
        <main>
            <section>
                <h2>Legal Services</h2>
                <ul>
                    <li><strong>Family Law:</strong> Assistance with divorce, child custody, spousal support, and adoption.</li>
                    <li><strong>Corporate Law:</strong> Business formation, mergers, acquisitions, and corporate governance.</li>
                    <li><strong>Intellectual Property Law:</strong> Patents, trademarks, copyrights, and trade secret protection.</li>
                </ul>
            </section>
            
            <section>
                <h2>Consulting Services</h2>
                <ul>
                    <li><strong>Startup Consulting:</strong> Guidance on legal documentation and investment strategies.</li>
                    <li><strong>Tax Advisory:</strong> Tax planning and international compliance.</li>
                    <li><strong>Contract Management:</strong> Drafting, reviewing, and negotiating agreements.</li>
                </ul>
            </section>
            
            <section>
                <h2>Alternative Dispute Resolution</h2>
                <ul>
                    <li><strong>Mediation:</strong> Resolving family, business, and employment disputes outside of court.</li>
                    <li><strong>Arbitration:</strong> Local and international arbitration for complex legal matters.</li>
                </ul>
            </section>
            
            <section>
                <h2>Education and Workshops</h2>
                <ul>
                    <li><strong>Legal Education:</strong> Training for employees and aspiring lawyers.</li>
                    <li><strong>Startup and IP Workshops:</strong> Educational sessions on intellectual property and business law.</li>
                </ul>
            </section>
        </main>
        <footer>
            &copy; <?php echo date("Y"); ?> CounselHub. All Rights Reserved.
        </footer>
    </div>
    <?php include_once "../../components/customer/footer/footer.php"; ?>
</body>
</html>
