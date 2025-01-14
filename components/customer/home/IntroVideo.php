<?php
$videoSrc = "/frontend/assets/components/customer/home/introvideo/intro_video.mov";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CounselHub</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body, html {
            height: 100%;
            font-family: 'Roboto', sans-serif;
        }

        .videoContainer {
            position: relative;
            width: 100%;
            height: 100vh;
            overflow: hidden;
            background-color: #000;
        }

        .video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: brightness(70%);
            transition: filter 0.5s ease;
        }

        .videoContainer:hover .video {
            filter: brightness(50%);
        }

        .overlayContainer {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 0 20px;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.3));
            animation: fadeIn 2s ease-in-out;
        }

        .introTitle {
            font-family: 'Playfair Display', serif;
            font-size: 64px;
            font-weight: 700;
            color: #ffffff;
            text-shadow: 3px 3px 10px rgba(0, 0, 0, 0.7);
            margin-bottom: 20px;
            animation: slideDown 1s ease-out;
        }

        .introSubTitle {
            font-size: 22px;
            font-style: italic;
            color: #e0e0e0;
            text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.5);
            max-width: 800px;
            margin-bottom: 40px;
            line-height: 1.5;
            animation: fadeIn 2s ease-in-out 0.5s forwards;
            opacity: 0;
        }

        .infoContainer {
            display: flex;
            justify-content: center;
            gap: 60px;
            margin-bottom: 50px;
            flex-wrap: wrap;
            animation: fadeIn 2s ease-in-out 1s forwards;
            opacity: 0;
        }

        .infoBlock {
            text-align: center;
            color: #ffffff;
            transition: transform 0.3s ease, color 0.3s ease;
        }

        .infoBlock:hover {
            transform: translateY(-10px);
            color: #ffcc00;
        }

        .infoNumber {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .infoText {
            font-size: 18px;
            color: #cfcfcf;
        }

        .ctaButton {
            padding: 15px 30px;
            font-size: 18px;
            font-weight: 600;
            color: #ffffff;
            background-color: #4E342E;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
            text-decoration: none;
        }

        .ctaButton:hover {
            background-color: #e64a19;
            transform: translateY(-5px);
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideDown {
            from { transform: translateY(-50px); }
            to { transform: translateY(0); }
        }

        @media (max-width: 768px) {
            .introTitle {
                font-size: 48px;
            }

            .introSubTitle {
                font-size: 18px;
            }

            .infoNumber {
                font-size: 28px;
            }

            .infoText {
                font-size: 16px;
            }

            .ctaButton {
                font-size: 16px;
                padding: 12px 25px;
            }
        }

        @media (max-width: 480px) {
            .infoContainer {
                gap: 30px;
            }
        }
    </style>
</head>
<body>
    <div class="videoContainer">
        <video autoplay loop muted class="video">
            <source src="<?php echo htmlspecialchars($videoSrc); ?>" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <div class="overlayContainer">
            <h1 class="introTitle">CounselHub</h1>
            <p class="introSubTitle">From safeguarding your legacy to defending your rights, we are your trusted legal allies every step of the way.</p>
            <div class="infoContainer">
                <div class="infoBlock">
                    <p class="infoNumber">30+</p>
                    <p class="infoText">Years of Proven Expertise</p>
                </div>
                <div class="infoBlock">
                    <p class="infoNumber">500+</p>
                    <p class="infoText">Successful Cases Resolved</p>
                </div>
                <div class="infoBlock">
                    <p class="infoNumber">Millions</p>
                    <p class="infoText">Protected & Saved for Our Clients</p>
                </div>
            </div>
            <a href="../../pages/search_attorney.php" class="ctaButton">Meet Our Attorneys</a>
        </div>
    </div>
</body>
</html>
