<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Law Firm Blog - News & Insights</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/kTc1Xxb8YVyv5n0BcHI6kOCLV8E3Yv96KRJzxlgYjGjj+uhLg3TmFyLwTH6YGe+cM/6owJUGVvD5A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f5f5;
            color: #333;
            line-height: 1.6;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        img {
            max-width: 100%;
            display: block;
        }

        h1, h2, h3, h4, h5, h6 {
            font-weight: 600;
            color: #333;
        }

        p {
            font-weight: 300;
            color: #555;
        }

        .blog-container {
            width: 90%;
            max-width: 1200px;
            margin: 50px auto;
            display: flex;
            flex-wrap: wrap;
            gap: 40px;
        }

        .blog-main {
            flex: 3;
            display: flex;
            flex-direction: column;
            gap: 30px;
        }

        .blog-post {
            margin-left: 220px;
            max-width: 800px;
            background: linear-gradient(135deg, #ff7e5f, #feb47b);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(255, 126, 95, 0.3);
            transition: transform 0.3s, box-shadow 0.3s;
            margin-bottom: 30px;
        }

        .blog-post:hover {
            transform: scale(1.02);
            box-shadow: 0 15px 25px rgba(255, 126, 95, 0.5);
        }

        .blog-post img {
            width: 100%; 
            height: auto; 
            max-height: 550px; 
            object-fit: cover; 
            filter: brightness(0.9);
            transition: transform 0.3s;
        }

        .blog-post:hover img {
            transform: scale(1.05);
        }

        .blog-post .content {
            padding: 25px;
        }

        .blog-post h3 {
            font-size: 1.8em;
            margin-bottom: 10px;
            color: #fff;
        }

        .blog-post .date {
            font-size: 0.85em;
            color: #ffd700;
            margin-bottom: 15px;
        }

        .blog-post p {
            font-size: 1em;
            color: #e0e0e0;
            margin-bottom: 20px;
        }

        .blog-post a.read-more {
            display: inline-flex;
            align-items: center;
            padding: 10px 25px;
            background-color: #ffdd57;
            color: #1e1e1e;
            border-radius: 50px;
            font-weight: 600;
            transition: background-color 0.3s, color 0.3s;
            font-size: 0.9em;
        }

        .blog-post a.read-more i {
            margin-left: 8px;
        }

        .blog-post a.read-more:hover {
            background-color: #ffa502;
            color: #fff;
        }

        .blog-sidebar {
            flex: 1;
            background: linear-gradient(135deg, #00c6ff, #0072ff);
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 198, 255, 0.3);
            position: sticky;
            top: 80px;
            height: fit-content;
            color: #fff;
        }

        .featured-news {
            width: 100%;
            margin-bottom: 50px;
        }

        .featured-news h2 {
            font-size: 2.5em;
            margin-bottom: 20px;
            color: #ff7e5f;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .news-slider {
            display: flex;
            overflow-x: auto;
            scroll-behavior: smooth;
            gap: 20px;
        }

        .news-slider::-webkit-scrollbar {
            display: none;
        }

        .news-item {
            min-width: 300px;
            background: linear-gradient(135deg, #43cea2, #185a9d);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(67, 206, 162, 0.3);
            flex-shrink: 0;
            transition: transform 0.3s, box-shadow 0.3s;
            color: #fff;
        }

        .news-item:hover {
            transform: scale(1.02);
            box-shadow: 0 15px 25px rgba(67, 206, 162, 0.5);
        }

        .news-item img {
            width: 100%; 
            height: auto; 
            max-height: 250px; 
            object-fit: cover;
            filter: brightness(0.8);
            transition: transform 0.3s;
        }

        .news-item:hover img {
            transform: scale(1.05);
        }

        .news-item .news-content {
            padding: 15px;
        }

        .news-item h4 {
            font-size: 1.3em;
            margin-bottom: 10px;
            color: #fff;
        }

        .news-item p {
            font-size: 0.95em;
            color: #d1d1d1;
        }

        @media (max-width: 992px) {
            .blog-container {
                flex-direction: column;
            }

            .blog-sidebar {
                position: relative;
                top: 0;
                margin-bottom: 30px;
            }
        }

        @media (max-width: 768px) {
            .news-slider {
                flex-direction: column;
                align-items: center;
            }

            .news-item {
                width: 100%;
                max-width: 100%;
            }
        }
    </style>
</head>

<body>
    <?php include_once "../../components/customer/header/navBar.php"; ?>

    <div class="blog-container">


        <div class="blog-main">

            <section class="featured-news">
                <h2>Featured News</h2>
                <div class="news-slider">

                    <div class="news-item">
                        <img src="https://www.thenews.com.pk/assets/uploads/updates/2024-11-24/1254402_8276200_kanye_updates.jpg" alt="Kanye West">
                        <div class="news-content">
                            <a href="https://www.thenews.com.pk/latest/1254402-kanye-west-faces-legal-trouble-for-diddy-party-accusations" target="_blank">
                                <h4>Kanye West faces legal trouble for Diddy party accusations</h4>
                            </a>
                            <p>Kanye West remains unresponsive to court against disturbing allegations.</p>
                        </div>
                    </div>

                    <div class="news-item">
                        <a href="https://www.nytimes.com/2024/11/25/us/politics/trump-cases-presidential-criminality.html" target="_blank" class="news-link">
                            <img src="https://static01.nyt.com/images/2024/11/25/multimedia/25DC-ASSESS-wpfk/25DC-ASSESS-wpfk-superJumbo.jpg?quality=75&auto=webp" alt="Trump Winning">
                            <div class="news-content">
                                <h4>Trump Winning: Legal Perspectives</h4>
                                <p>End of Trump Cases Leaves Limits on Presidential Criminality Unclear.</p>
                            </div>
                        </a>
                    </div>

                    <div class="news-item">
                        <a href="https://www.bbc.com/news/articles/czxvz4re5y1o" target="_blank" class="news-link">
                            <img src="https://www.ft.com/__origami/service/image/v2/images/raw/ftcms%3Ac95f22c3-afce-4ffd-98c1-9bf5855aab5c?source=next-article&fit=scale-down&quality=highest&width=700&dpr=2" alt="Russia Ukraine Conflict">
                            <div class="news-content">
                                <h4>US universities warn foreign students on Trump immigration crackdown</h4>
                                <p>Top colleges have issued travel advisories urging students and staff to return to the US before inauguration day.</p>
                            </div>
                        </a>
                    </div>

                    <div class="news-item">
                        <a href="https://www.washingtonpost.com/business/2024/11/27/elon-musk-delete-cfpb-doge/" target="_blank" class="news-link">
                            <img src="https://e3.365dm.com/24/05/2048x1152/skynews-elon-musk-tesla_6570413.jpg?20240531130205" alt="Corruption in America">
                            <div class="news-content">
                                <h4>Elon Musk wants to ‘delete’ federal financial watchdog as ‘DOGE’ begins work</h4>
                                <p>“Delete CFPB,” Elon Musk, the billionaire tech executive running the “Department of Government Efficiency,” said in an early-morning post on X.</p>
                            </div>
                        </a>
                    </div>
                </div>

                </div>
            </section>

            <section class="blog-posts">

                <article class="blog-post">
                    <img src="https://westline.com.tr/wp-content/uploads/2019/07/florida-work-and-travel.jpg" alt="Social Media and Law">
                    <div class="content">
                        <h3>Palm Beach, a Democratic Pocket in Florida, Becomes MAGA Central</h3>
                        <p class="date">November 24, 2024</p>
                        <p>Republicans descend on the enclave to be near Mar-a-Lago, snarling traffic, jostling for hotel rooms and looking to buy homes</p>
                        <a href="https://www.wsj.com/real-estate/palm-beach-a-democratic-pocket-in-florida-becomes-maga-central-e96f9a1f?mod=real-estate_lead_pos3" class="read-more">Read More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </article>

                <article class="blog-post">
                    <img src="https://media.cnn.com/api/v1/images/stellar/prod/220411154647-donald-trump-jr-0227.jpg?c=16x9&q=h_653,w_1160,c_fill/f_webp" alt="Legal Reforms 2024">
                    <div class="content">
                        <h3>Unusual Machines CEO: Donald Trump Jr. Advisory Role Isn’t About Political Connections</h3>
                        <p class="date">November 27, 2024</p>
                        <p>Company shares surged on announcement of Trump Jr. as an advisor.</p>
                        <a href="https://www.wsj.com/business/unusual-machines-ceo-donald-trump-jr-advisory-role-isnt-about-political-connections-0208e1ad?mod=business_lead_pos1" class="read-more">Read More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </article>

                <article class="blog-post">
                    <img src="https://media.cnn.com/api/v1/images/stellar/prod/gettyimages-1462355302.jpg?c=16x9&q=w_1280,c_fill" alt="Intellectual Property">
                    <div class="content">
                        <h3>Menendez brothers timeline: From the 1989 murders to their new fight for freedom</h3>
                        <p class="date">November 27, 2024</p>
                        <p>Lyle and Erik Menendez are each serving two life sentences without parole.</p>
                        <a href="https://abcnews.go.com/US/menendez-brothers-timeline-1989-murders-new-fight-freedom/story?id=116243650" class="read-more">Read More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </article>

            </section>

        </div>
    </div>

    <script>
    
        const newsSlider = document.querySelector('.news-slider');
        const newsItems = document.querySelectorAll('.news-item');
        let scrollAmount = 0;
        const scrollStep = 1;
        const delay = 20; // milliseconds

        function autoScroll() {
            if (newsSlider.scrollLeft + newsSlider.clientWidth >= newsSlider.scrollWidth) {
                newsSlider.scrollLeft = 0;
            } else { 
                newsSlider.scrollLeft += scrollStep;
            }
        }

        let scrollInterval = setInterval(autoScroll, delay);

        // Pause on hover
        newsSlider.addEventListener('mouseover', () => {
            clearInterval(scrollInterval);
        });

        newsSlider.addEventListener('mouseout', () => {
            scrollInterval = setInterval(autoScroll, delay);
        });
    </script>
    <?php include_once "../../components/customer/footer/footer.php"; ?>
</body>

</html>
