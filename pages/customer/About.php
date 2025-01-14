<?php
    $styles = [
        'introSectionContainer' => 'intro-section-container',
        'title' => 'title',
        'paragraph' => 'paragraph',
        'experiencesContainer' => 'experiences-container',
        'card' => 'card',
        'activityImage' => 'activity-image',
        'overlayInfo' => 'overlay-info',
        'activityFooter' => 'activity-footer',
        'description' => 'description',
        'number' => 'number',
        'dot' => 'dot',
    ];

    $experiences = [
        [
            "description" => "Founded on the principles of integrity, expertise, and client-first service, CounselHub has grown into a leading name in the legal industry. From our humble beginnings, we set out to redefine how legal services are delivered, focusing on creating meaningful and lasting client relationships.",
            "imagePath" => "https://cdn.cfr.org/sites/default/files/styles/large_xl_2x_680/public/image/2024/10/ImmigrationElex_IB.jpg.webp"
        ],
        [
            "description" => "We understand that no two companies are alike. That’s why we offer customized legal services designed to address the specific challenges and opportunities your business faces. Whether it’s navigating regulatory frameworks, managing employee relations, or resolving disputes, CounselHub is your partner in success.",
            "imagePath" => "https://www.thewallstreetexperience.com/wp-content/uploads/2021/12/xLM_-TWSE-2259-1-scaled.jpg.pagespeed.ic.y1vtQAQ2qC.webp"
        ],
        [
            "description" => "Today, CounselHub stands as a beacon of trust and reliability. Our diverse team of attorneys brings a wealth of knowledge and a passion for justice, ensuring every client receives the personalized care they deserve. From corporate law to criminal defense, our history is a testament to our dedication to achieving exceptional outcomes.",
            "imagePath" => "https://ca-times.brightspotcdn.com/dims4/default/c4ba11f/2147483647/strip/true/crop/971x644+0+0/resize/1200x796!/format/webp/quality/75/?url=https%3A%2F%2Fcalifornia-times-brightspot.s3.amazonaws.com%2Fb3%2F93%2F77ecd0a64652a49410e457b9262a%2Fgettyimages-51966022.jpg"
        ],
    ];

    function renderExperienceContainer($experience, $index, $styles) {
        return "
            <div class=\"{$styles['card']}\" data-expanded=\"false\">
                <!-- Profile Header Section -->
                <div class=\"insta-header\">
                    <div class=\"author-info\">
                        <div class=\"profile-img-container\">
                            <img src=\"/frontend/assets/components/customer/home/about/Warner-Spencer.ico\" alt=\"Author Profile\" />
                        </div>
                        <div class=\"author-details\">
                            <p>counselhub</p>
                        </div>
                    </div>
                    <div class=\"post-type-icon\">
                        <img src=\"https://upload.wikimedia.org/wikipedia/commons/thumb/a/a5/Instagram_icon.png/1024px-Instagram_icon.png\" alt=\"Instagram Icon\" />
                    </div>
                </div>
                
                <!-- Main Image Section -->
                <div class=\"{$styles['activityImage']}\">
                    <img src=\"{$experience['imagePath']}\" alt=\"Image related to experience\" />
                </div>
                
                <!-- Post Content Section -->
                <div class=\"insta-content\">
                    <p class=\"post-description\">
                        <strong>counselhub</strong> <span class=\"short-text\">" . htmlspecialchars(substr($experience['description'], 0, 100)) . "</span>
                        <span class=\"full-text\">" . htmlspecialchars($experience['description']) . "</span>
                        <span class=\"see-more\">...See more</span>
                    </p>
                </div>
            </div>
        ";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <style>
        body {
            background-color: #f0f0f0; 
            font-family: 'Times', serif;
            color: #333333;
        }

        .intro-section-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
            width: 80%;
            max-width: 1400px;
            margin: 50px auto;
            background: #ffffff; 
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); 
        }

        .title {
            text-align: center;
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333333;
        }

        .paragraph {
            text-align: center;
            width: 80%;
            margin: 0 auto;
            color: #555555;
            line-height: 1.8;
            font-size: 1.1rem;
        }

        .experiences-container {
            display: flex;
            flex-direction: column;
            gap: 60px;
            width: 100%;
            margin: 50px auto 0 auto;
        }

        .zigzag-row {
            display: flex;
            gap: 40px;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
        }

        .zigzag-row.odd {
            flex-direction: row;
        }

        .zigzag-row.even {
            flex-direction: row-reverse;
        }

        .card {
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: box-shadow 0.3s ease-in-out;
            max-width: 500px;
            width: 100%;
            display: flex;
            flex-direction: column;
            cursor: pointer;
        }

        .card:hover {
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        }

        .insta-header {
            display: flex;
            align-items: center;
            padding: 15px;
            position: relative;
            background-color: #f9f9f9;
        }

        .author-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .profile-img-container {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            overflow: hidden;
        }

        .profile-img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .author-details p {
            margin: 0;
            font-size: 1rem;
            color: #8e8e8e;
        }

        .author-details p:first-child {
            font-weight: bold;
            color: #262626;
        }

        .post-type-icon {
            position: absolute;
            right: 15px;
            top: 15px;
        }

        .post-type-icon img {
            width: 20px;
            height: 20px;
        }

        .activity-image {
            width: 100%;
            height: 300px;
            overflow: hidden;
        }

        .activity-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .insta-content {
            padding: 16px;
        }

        .post-description {
            font-size: 1.1rem;
            line-height: 1.6;
            color: #333333;
            text-align: justify;
        }

        .short-text {
            display: inline;
        }

        .full-text {
            display: none;
        }

        .see-more {
            color: #000000;
            cursor: pointer;
            font-weight: bold;
        }

        .separator {
            width: 80%;
            margin: 20px auto;
            border-bottom: 2px solid #dddddd;
        }

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .overlay.active {
            display: flex;
        }

        .expanded-card {
            background: #ffffff;
            padding: 30px;
            border-radius: 15px;
            width: 500px;
            max-height: 750px;
            overflow-y: auto;
            position: relative;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .expanded-card .activity-image {
            height: 300px;  
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 1.5rem;
            cursor: pointer;
            color: #333333;
        }

        .comments-section {
            width: 80%;
            margin: 50px auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .comments-section h2 {
            font-size: 2rem;
            font-weight: bold;
            color: #333333;
            margin-bottom: 30px;
            text-align: center;
        }

        .comment {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .comment-header {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .user-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 15px;
        }

        .user-info {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-weight: bold;
            margin: 0;
            color: #333333;
        }

        .star-rating {
            display: flex;
        }

        .star {
            font-size: 1.2rem;
            color: #ccc;
        }

        .star.filled {
            color: #FFD700;
        }

        .comment-text {
            font-size: 1.1rem;
            line-height: 1.6;
            color: #555555;
            margin: 0;
        }

        @media (max-width: 768px) {
            .intro-section-container, .comments-section {
                width: 90%;
                padding: 15px;
            }

            .expanded-card {
                width: 90%;
            }

            .activity-image {
                height: 150px;
            }

            .expanded-card .activity-image {
                height: 200px;
            }

            .zigzag-row {
                flex-direction: column !important;
            }
        }
    </style>
</head>
<body>
    <?php include_once "../../components/customer/header/navBar.php"; ?>

    <div class="intro-section-container">
        <h1 class="title">Welcome to CounselHub: Your Trusted Legal Partner</h1>
        <p class="paragraph">
            <i>
                At CounselHub, we are dedicated to empowering businesses with top-tier legal expertise, ensuring they thrive in today’s competitive landscape. From startups to established corporations, our firm serves as a trusted partner, offering solutions that are as dynamic as the businesses we represent.
            </i>
        </p>
        <div class="experiences-container">
            <?php 
            $index = 1;
            foreach ($experiences as $experience) : 
                $rowClass = ($index % 2 === 0) ? 'even' : 'odd';
            ?>
            <div class="zigzag-row <?php echo $rowClass; ?>">
                <?php echo renderExperienceContainer($experience, $index, $styles); ?>
            </div>
            <div class="separator"></div>
            <?php
                $index++;
            endforeach; 
            ?>
        </div>
    </div>

    <div class="comments-section">
        <h2>Customer Comments</h2>
        <div class="comment">
            <div class="comment-header">
                <img src="https://i1.sndcdn.com/avatars-EJ9GGrkQ9typ3a0d-v74n4Q-t1080x1080.jpg" alt="User Profile" class="user-img" />
                <div class="user-info">
                    <p class="user-name">Donald Glover</p>
                    <div class="star-rating">
                        <span class="star filled">&#9733;</span>
                        <span class="star filled">&#9733;</span>
                        <span class="star filled">&#9733;</span>
                        <span class="star filled">&#9733;</span>
                        <span class="star filled">&#9733;</span>
                    </div>
                </div>
            </div>
            <p><strong>"Highly Recommended for Startups"</strong></p>
            <p class="comment-text">As a startup, finding a reliable legal partner was critical for us. CounselHub provided excellent guidance on contracts and compliance, making sure we were set up for success. I couldn’t be happier with their services!</p>
        </div>
        <div class="comment">
            <div class="comment-header">
                <img src="https://tr.web.img3.acsta.net/pictures/17/07/17/11/38/542879.jpg" alt="User Profile" class="user-img" />
                <div class="user-info">
                    <p class="user-name">Harry Styles</p>
                    <div class="star-rating">
                        <span class="star filled">&#9733;</span>
                        <span class="star filled">&#9733;</span>
                        <span class="star filled">&#9733;</span>
                        <span class="star filled">&#9733;</span>
                        <span class="star filled">&#9733;</span>
                    </div>
                </div>
            </div>
            <p><strong>"Expert Corporate Legal Services"</strong></p>
            <p class="comment-text">CounselHub has been our go-to law firm for corporate legal matters. Their advice is always clear, practical, and timely. They’ve helped us navigate complex mergers and compliance issues seamlessly. A fantastic team to work with!</p>
        </div>
        <div class="comment">
            <div class="comment-header">
                <img src="https://i.gazeteduvar.com.tr/2/1280/720/storage/files/images/2021/08/05/the-weeknd-o3ls_cover.jpg" alt="User Profile" class="user-img" />
                <div class="user-info">
                    <p class="user-name">Abel Tesfaye</p>
                    <div class="star-rating">
                        <span class="star filled">&#9733;</span>
                        <span class="star filled">&#9733;</span>
                        <span class="star filled">&#9733;</span>
                        <span class="star filled">&#9733;</span>
                        <span class="star filled">&#9733;</span>
                    </div>
                </div>
            </div>
            <p><strong>"Professional and Trustworthy"</strong></p>
            <p class="comment-text">I had a great experience with CounselHub! Their team was incredibly professional and took the time to understand my case in detail. They kept me informed throughout the process, and the results exceeded my expectations. Highly recommend their services!</p>
        </div>
    </div>

    <div class="overlay" id="overlay">
        <div class="expanded-card" id="expandedCard">
            <span class="close-btn" id="closeBtn">&times;</span>
            <div id="expandedCardContent"></div>
        </div>
    </div>

    <?php include_once "../../components/customer/footer/footer.php"; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const seeMoreLinks = document.querySelectorAll('.see-more');
            const cards = document.querySelectorAll('.card');
            const overlay = document.getElementById('overlay');
            const expandedCardContent = document.getElementById('expandedCardContent');
            const closeBtn = document.getElementById('closeBtn');

            function toggleText(event) {
                event.stopPropagation(); 
                const card = this.closest('.card');
                const shortText = card.querySelector('.short-text');
                const fullText = card.querySelector('.full-text');
                const seeMore = card.querySelector('.see-more');

                if (card.dataset.expanded === "false") {
                    shortText.style.display = 'none';
                    fullText.style.display = 'inline';
                    seeMore.textContent = ' See Less';
                    card.dataset.expanded = "true";
                } else {
                    shortText.style.display = 'inline';
                    fullText.style.display = 'none';
                    seeMore.textContent = '...See more';
                    card.dataset.expanded = "false";
                }
            }

            seeMoreLinks.forEach(link => {
                link.addEventListener('click', toggleText);
            });

            cards.forEach(card => {
                card.addEventListener('click', function() {
                    
                    const clonedCard = this.cloneNode(true);
                
                    const clonedSeeMore = clonedCard.querySelector('.see-more');
                    if (clonedSeeMore) {
                        clonedSeeMore.removeEventListener('click', toggleText);
                        clonedSeeMore.textContent = '...See more'; 
                        clonedSeeMore.style.display = 'inline';
                        const shortText = clonedCard.querySelector('.short-text');
                        const fullText = clonedCard.querySelector('.full-text');
                        shortText.style.display = 'inline';
                        fullText.style.display = 'none';
                        clonedCard.dataset.expanded = "false";
                        clonedSeeMore.addEventListener('click', toggleText);
                    }

                    expandedCardContent.innerHTML = '';
                    expandedCardContent.appendChild(clonedCard);
                    overlay.classList.add('active');
                });
            });

            closeBtn.addEventListener('click', function() {
                overlay.classList.remove('active');
            });

            overlay.addEventListener('click', function(event) {
                if (event.target === overlay) {
                    overlay.classList.remove('active');
                }
            });
        });
    </script>
</body>
</html>
