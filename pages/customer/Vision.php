<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Diversity & Inclusion | Cravath</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;1,400&family=Open+Sans:ital,wght@0,400;1,400&display=swap" rel="stylesheet">
    <style>

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Roboto', sans-serif;
            line-height: 1.6;
            color: #f5f5f5; 
            background-color: #d8cfc3; 
            text-align: center;
        }

        a {
            text-decoration: none;
            color: #d89b8c
            transition: color 0.3s;
        }

        a:hover {
            color: #b57665; 
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px 0;
        }

        .intro {
            padding: 50px 20px;
            background-color: #fffaf5;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            margin-bottom: 40px;
        }

        .intro p {
            margin-bottom: 25px;
            font-size: 1.1em;
            color: #6c5b7b; 
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
            font-style: italic;
            padding: 0 20px;
        }

        .initiatives {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            justify-content: center;
            padding: 60px 0;
        }

        .initiative {
            flex: 1 1 300px;
            padding: 25px 20px;
            border-radius: 10px;
            transition: box-shadow 0.3s, transform 0.3s;
            background-color: #ffe4e1; 
            display: flex;
            flex-direction: column;
            height: 100%;
            position: relative;
            color: #333;
        }

        .initiative:hover {
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
            transform: translateY(-5px);
        }

        .initiative-number {
            font-size: 1.8em;
            color: #d89b8c; 
            margin-bottom: 10px;
            font-weight: 700;
        }

        .initiative-title {
            font-size: 1.3em;
            color: #b57665; 
            margin-bottom: 15px;
            font-weight: 600;
        }

        .initiative-description {
            font-size: 1em;
            color: #6c5b7b; 
            line-height: 1.6;
            flex-grow: 1;
            font-style: italic;
            padding: 0 10px;
        }

        .initiative:nth-child(1) {
            background-color: #ffe4e1; 
        }

        .initiative:nth-child(2) {
            background-color: #f5f5dc; 
        }

        .initiative:nth-child(3) {
            background-color: #faf0e6; 
        }

        .initiative:nth-child(4) {
            background-color: #fff0f5; 
        }

        .initiative:nth-child(5) {
            background-color: #fdf5e6; 
        }

        .initiative:nth-child(6) {
            background-color: #ffe4b5; 
        }

        .initiative:nth-child(7) {
            background-color: #ffebcd; 
        }

        @media (max-width: 992px) {
            .intro p {
                font-size: 1em;
            }

            .initiative-number {
                font-size: 1.6em;
            }

            .initiative-title {
                font-size: 1.2em;
            }
        }

        @media (max-width: 768px) {
            .initiative {
                flex: 1 1 100%;
            }
        }

        @media (max-width: 480px) {
            .intro p {
                font-size: 0.9em;
            }

            .initiative-number {
                font-size: 1.4em;
            }

            .initiative-title {
                font-size: 1.1em;
            }
        }
    </style>
</head>
<body>
    <?php include_once "../../components/customer/header/navBar.php"; ?>
    <div class="container">
        <section class="intro">
            <p>At CounselHub, we believe that our strength lies in the unique perspectives, experiences, and backgrounds of our team. Diversity and inclusion are cornerstones of our mission to deliver exceptional legal services to our clients. Our commitment ensures that every individual at CounselHub feels valued, respected, and empowered to excel.</p>
            <p>Through the dedicated efforts of our Diversity Committee and the active involvement of our leadership, we foster an environment that celebrates inclusivity, collaboration, and innovation. Our goal is to reflect the communities we serve, ensuring that our firm remains a beacon of equity and excellence in the legal profession.</p>
        </section>

        <section class="initiatives">
            <?php
             $initiatives = [
                [
                    'number' => '01',
                    'title' => 'Diversity Committee',
                    'description' => 'The Diversity Committee at CounselHub leads initiatives to enhance inclusivity, promote equitable practices, and track our progress toward building a diverse workplace.',
                ],
                [
                    'number' => '02',
                    'title' => 'Inclusive Recruitment',
                    'description' => 'CounselHub is committed to recruiting from a wide range of backgrounds to build a team that represents diverse talents and perspectives, ensuring excellence in legal practice.',
                ],
                [
                    'number' => '03',
                    'title' => 'Mentorship Programs',
                    'description' => 'We provide robust mentorship opportunities to support career development, foster relationships, and help our team balance professional and personal growth.',
                ],
                [
                    'number' => '04',
                    'title' => 'Women’s Initiative',
                    'description' => 'Our Women’s Initiative supports women at all levels of the firm, ensuring opportunities for leadership and professional development while fostering a supportive community.',
                ],
                [
                    'number' => '05',
                    'title' => 'Work-Life Balance',
                    'description' => 'Recognizing the importance of well-being, we offer resources and programs to help our team members achieve a fulfilling balance between their careers and personal lives.',
                ],
                [
                    'number' => '06',
                    'title' => 'Community Engagement',
                    'description' => 'CounselHub partners with organizations that promote inclusivity and diversity in the legal field, contributing to a more equitable profession for all.',
                ],
                [
                    'number' => '07',
                    'title' => 'Equal Opportunity Policy',
                    'description' => 'We are committed to maintaining an inclusive environment where everyone is treated with dignity and respect, and where discrimination or harassment is not tolerated.',
                ],
            ];

            foreach ($initiatives as $initiative) {
                echo '<div class="initiative">';
                echo '<div class="initiative-number">' . htmlspecialchars($initiative['number']) . '</div>';
                echo '<div class="initiative-title">' . htmlspecialchars($initiative['title']) . '</div>';
                echo '<div class="initiative-description">' . htmlspecialchars($initiative['description']) . '</div>';
                echo '</div>';
            }
            ?>
        </section>
    </div>
    <?php include_once "../../components/customer/footer/footer.php"; ?>
</body>
</html>
