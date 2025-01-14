<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Law Firm Blog - News & Insights</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f5f5;
            color: #333;
            line-height: 1.6;
        }

        .blog-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .blog-post {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            overflow: hidden;
            padding: 20px;
        }

        .blog-post img {
            width: 100%;
            height: auto;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .blog-post h3 {
            font-size: 1.5rem;
            color: #a8896c;
            margin-bottom: 10px;
        }

        .blog-post p {
            margin-bottom: 15px;
            color: #555;
        }

        .blog-post .author {
            font-size: 0.9rem;
            color: #888;
        }
    </style>
</head>

<body>
    <?php include_once "../../components/customer/header/navBar.php"; ?>
    <div class="blog-container">

        <div class="blog-post">
            <img src="https://media.nu.nl/m/m1nxht6arqaq_wd854/michael-jackson.jpg" alt="Michael Jackson">
            <h3>Michael Jackson's Acquittal in Child Abuse Allegations</h3>
            <p>In the late 1990s, "King of Pop" Michael Jackson faced accusations of child abuse. In a 2005 trial, Jackson was acquitted of all charges. However, these allegations tarnished his career and personal image.</p>
        </div>

        <div class="blog-post">
            <img src="https://ichef.bbci.co.uk/ace/ws/800/cpsprodpb/ffb1/live/505458a0-5172-11ed-ac87-630245663c6a.png.webp" alt="Ed Sheeran">
            <h3>Ed Sheeran's "Shape of You" Lawsuit</h3>
            <p>In 2017, Ed Sheeran faced plagiarism allegations over his song "Shape of You," accused of resembling Sami Chokri's 2015 track "Oh Why." In a landmark ruling, the UK High Court cleared Sheeran of intentional infringement.</p>
        </div>

        <div class="blog-post">
            <img src="https://upload.wikimedia.org/wikipedia/commons/6/63/Led_Zeppelin_-_promotional_image_%281971%29.jpg" alt="Led Zeppelin">
            <h3>Led Zeppelin's "Stairway to Heaven" Lawsuit</h3>
            <p>Legendary rock band Led Zeppelin faced a lawsuit in 2014 claiming their 1971 hit "Stairway to Heaven" plagiarized Spirit's 1968 instrumental track "Taurus." In 2020, the court ruled in favor of Led Zeppelin.</p>
        </div>

        <div class="blog-post">
            <img src="https://cdn1.ntv.com.tr/gorsel/2KAZjKVZvEamyA3muSYxaw.jpg?width=1000&mode=both&scale=both&v=1655304434145" alt="Johnny Depp and Amber Heard">
            <h3>Johnny Depp and Amber Heard's Defamation Case</h3>
            <p>Hollywood actor Johnny Depp filed a defamation lawsuit against his ex-wife Amber Heard, citing damage to his reputation from allegations of domestic violence. In 2022, the jury ruled in Depp's favor, awarding him damages.</p>
        </div>
    </div>
    <?php include_once "../../components/customer/footer/footer.php"; ?>
</body>

</html>
