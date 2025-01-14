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
        "title" => "Corporate Law",
        "description" => "Comprehensive legal solutions for businesses, including mergers, contracts, and compliance.",
        "imagePath" => "/frontend/assets/components/customer/home/experiences/corporate_law.jpeg"
    ],
    [
        "title" => "Criminal Law",
        "description" => "Expert legal representation to defend your rights and ensure fair treatment in criminal cases.",
        "imagePath" => "/frontend/assets/components/customer/home/experiences/criminal_law.jpeg"
    ],
    [
        "title" => "Intellectual Property Law",
        "description" => "Protect your ideas and creations through trademarks, copyrights, and patents.",
        "imagePath" => "/frontend/assets/components/customer/home/experiences/intellectual_property_law.jpeg"
    ],
    [
        "title" => "Immigration Law",
        "description" => "Navigate complex immigration processes with confidence and expert legal assistance.",
        "imagePath" => "/frontend/assets/components/customer/home/experiences/immigration_law.jpeg"
    ],
    [
        "title" => "Family Law",
        "description" => "Supportive legal guidance for divorce, child custody, and family-related matters.",
        "imagePath" => "/frontend/assets/components/customer/home/experiences/family_law.jpeg"
    ],
    [
        "title" => "Tax Law",
        "description" => "Expertise in tax planning, audits, and resolving disputes with tax authorities.",
        "imagePath" => "/frontend/assets/components/customer/home/experiences/tax_law.jpeg"
    ],
    [
        "title" => "Environmental Law",
        "description" => "Protect the environment with legal counsel on regulations, policies, and disputes.",
        "imagePath" => "/frontend/assets/components/customer/home/experiences/environmental_law.jpeg"
    ],
    [
        "title" => "Labor Law",
        "description" => "Advocate for employees or employers in workplace disputes, contracts, and compliance.",
        "imagePath" => "/frontend/assets/components/customer/home/experiences/labor_law.jpeg"
    ],
    [
        "title" => "Real Estate Law",
        "description" => "Legal services for property transactions, disputes, and land use matters.",
        "imagePath" => "/frontend/assets/components/customer/home/experiences/real_estate_law.jpeg"
    ],
    [
        "title" => "Technology Law",
        "description" => "Expert counsel on tech-related issues like data privacy, cybersecurity, and software licensing.",
        "imagePath" => "/frontend/assets/components/customer/home/experiences/technology_law.jpeg"
    ]
];

function renderExperienceContainer($experience, $index, $styles) {
    return "
        <div class=\"{$styles['card']}\">
            <div class=\"{$styles['activityImage']}\">
                <img src=\"{$experience['imagePath']}\" alt=\"{$experience['title']}\" />
                <div class=\"{$styles['overlayInfo']}\">
                    <h3>{$experience['title']}</h3>
                </div>
            </div>
             <div class=\"{$styles['activityFooter']}\">
                <div class=\"{$styles['number']}\">" . sprintf("%02d", $index) . "</div>
                <p class=\"p\">{$experience['description']}</p>
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
    <link rel="stylesheet" href="Experiences.module.css">
    <title>Legal Services</title>
    <style>
        .intro-section-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
            width: 80%;
            max-width: 1400px;
            margin: 100px auto 0px auto;
        }

        .title {
            text-align: center;
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .paragraph {
            text-align: center;
            width: 80%;
            margin: 0px auto;
            color: gray;
            line-height: 1.6;
            font-size: 1rem;
        }

        .experiences-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            width: 80%;
            margin: 50px auto 0px auto;
        }

        .card {
            position: relative;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .activity-image {
            position: relative;
            height: 200px;
            width: 100%;
            overflow: hidden;
        }

        .activity-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .card:hover .activity-image img {
            transform: scale(1.1);
        }

        .overlay-info {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            padding: 8px;
            text-align: center;
        }

        .card:hover .overlay-info {
            opacity: 1;
        }

        .overlay-info h3 {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .overlay-info p {
            font-size: 1rem;
            opacity: 0.9;
        }

        .activity-footer {
            padding: 15px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .number {
            font-size: 24px;
            font-weight: bold;
            color: black;
        }
        .p {
            font-size: 1rem;
            line-height: 1.4; 
            font-family: 'Times', cursive;
            font-style: italic; 
            color: #000; 
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1); 
        }
    </style>
</head>
<body>
    <div class="intro-section-container">
        <h1 class="title">LEGAL SERVICES</h1>
        <p class="paragraph">
            <i>
                Explore our range of legal services designed to meet diverse needs, from corporate solutions to personal guidance. Trust our expertise to navigate complex legal challenges and provide tailored solutions.
            </i>
        </p>
        <div class="experiences-container">
            <?php 
            $index = 1;
            foreach ($experiences as $experience) : 
                echo renderExperienceContainer($experience, $index, $styles);
                $index++;
            endforeach; 
            ?>
        </div>
    </div>
</body>
</html>
