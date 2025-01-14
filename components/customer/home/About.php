<?php
$img1 = "/frontend/assets/components/customer/home/about/justice.jpeg";
$img2 = "/frontend/assets/components/customer/home/about/stamp.jpeg";
$img3 = "/frontend/assets/components/customer/home/about/libra.jpeg";
$video = "/frontend/assets/components/customer/home/about/about_video.mp4";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Law Firm</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to bottom right, #f2ece6, #eae4dc);
            color: #3c2f2f; 
        }

        .about {
            padding: 80px 20px;
            text-align: center;
        }

        .about .sec-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .title {
            font-size: 2.5rem;
            margin-bottom: 50px;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #3c2f2f; 
            position: relative;
        }

        .title::after {
            content: "";
            display: block;
            width: 60px;
            height: 4px;
            background: #6a4c2f; 
            margin: 10px auto 0 auto;
            border-radius: 2px;
        }

        .main-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 40px;
            margin-top: 40px;
        }

        .single-item {
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .single-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .single-item img {
            width: 100%;
            height: 300px; 
            object-fit: cover;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .single-item h3 {
            font-size: 1.4rem;
            margin: 15px 0;
            color: #5c4533; 
            font-weight: 600;
            line-height: 1.4;
        }

        .single-item p {
            font-size: 1rem;
            color: #3c2f2f;
            line-height: 1.8;
            margin: 0;
        }

        .video-card {
            margin-top: 60px;
            background: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .video-card .card-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            align-items: center;
        }

        .card-text h2 {
            font-size: 2rem;
            color: #5c4533; 
            margin-bottom: 20px;
            font-weight: 600;
            line-height: 1.4;
        }

        .card-text p {
            font-size: 1.1rem;
            color: #3c2f2f;
            line-height: 1.8;
            margin: 0;
        }

        .card-video video {
            width: 100%;
            border-radius: 5px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        .single-item:hover h3 {
            color: #8a6a4f; 
        }

        .card-text h2:hover {
            text-shadow: 2px 2px 10px rgba(90, 70, 50, 0.3);
        }

        @media (max-width: 900px) {
            .video-card .card-content {
                grid-template-columns: 1fr;
            }

            .card-video {
                margin-top: 20px;
            }
        }

        @media (max-width: 600px) {
            .title {
                font-size: 2rem;
            }

            .single-item h3 {
                font-size: 1.2rem;
            }

            .card-text h2 {
                font-size: 1.6rem;
            }
        }
    </style>
</head>
<body>
    <section class="about">
        <div class="sec-container">
            <h1 class="title">WHY CHOOSE OUR FIRM?</h1>

            <div class="main-content container grid">
                <div class="single-item">
                    <img src="<?= $img1 ?>" alt="Justice Image" />
                    <h3>"Commitment to Justice: Advocating for Your Rights"</h3>
                    <p>
                        Our team of experienced attorneys is dedicated to providing exceptional legal counsel, ensuring fair representation and protecting your rights.
                    </p>
                </div>

                <div class="single-item">
                    <img src="<?= $img2 ?>" alt="Law Logo" />
                    <h3>"Expertise Across Practice Areas: Your Legal Allies"</h3>
                    <p>
                        With extensive knowledge across various fields of law, we tailor our services to meet your unique needs and provide comprehensive solutions.
                    </p>
                </div>

                <div class="single-item">
                    <img src="<?= $img3 ?>" alt="Scales of Justice" />
                    <h3>"Client-Centered Approach: Building Trust and Success"</h3>
                    <p>
                        We value open communication and prioritize your goals, fostering a trusted partnership to achieve the best outcomes.
                    </p>
                </div>
            </div>

            <div class="video-card container">
                <div class="card-content grid">
                    <div class="card-text">
                        <h2>
                            "Your Trusted Legal Partner for Every Challenge"
                        </h2>
                        <p>
                            From navigating complex legal challenges to offering personalized advice, our firm is here to guide you every step of the way.
                        </p>
                    </div>

                    <div class="card-video">
                        <video src="<?= $video ?>" autoplay loop muted type="video/mp4"></video>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
