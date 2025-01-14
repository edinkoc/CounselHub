<?php
$faqs = [
    [
        "question" => "What types of legal cases does CounselHub handle?",
        "answer" => "CounselHub specializes in a wide range of legal cases including family law, criminal defense, personal injury, corporate law, and intellectual property disputes."
    ],
    [
        "question" => "How can I schedule a consultation with CounselHub?",
        "answer" => "You can schedule a consultation by visiting our website and filling out the contact form or by calling our office directly."
    ],
    [
        "question" => "What are the consultation fees at CounselHub?",
        "answer" => "The consultation fees vary depending on the complexity of your case. We offer a free initial consultation for personal injury and criminal defense cases."
    ],
    [
        "question" => "Does CounselHub handle international legal matters?",
        "answer" => "Yes, we have a dedicated team specializing in international legal disputes and cross-border cases."
    ],
    [
        "question" => "What documents should I bring for my first meeting with a lawyer?",
        "answer" => "Please bring all relevant documents related to your case, such as contracts, court notices, evidence, and identification."
    ],
    [
        "question" => "Can CounselHub represent me in court?",
        "answer" => "Yes, our experienced attorneys are fully licensed and can represent you in court for all types of cases."
    ],
    [
        "question" => "What payment options are available at CounselHub?",
        "answer" => "We accept various payment options including credit cards, bank transfers, and installment plans for certain cases."
    ],
    [
        "question" => "Does CounselHub offer mediation services?",
        "answer" => "Yes, we provide mediation services for family law, business disputes, and other cases where out-of-court settlements are preferred."
    ],
    [
        "question" => "How long will it take to resolve my case?",
        "answer" => "The duration of your case depends on its complexity and the legal procedures involved. Our team will provide an estimated timeline after reviewing your case."
    ],
    [
        "question" => "Can CounselHub help me with contract drafting and review?",
        "answer" => "Yes, we offer contract drafting and review services to ensure your agreements are legally sound and protect your interests."
    ],
    [
        "question" => "Does CounselHub offer corporate legal services?",
        "answer" => "Yes, we provide a range of corporate legal services, including business formation, compliance, mergers and acquisitions, and intellectual property protection."
    ],
    [
        "question" => "What is the process for filing a lawsuit with CounselHub?",
        "answer" => "Filing a lawsuit begins with an initial consultation to understand your case. Our lawyers will guide you through the documentation, filing, and litigation process."
    ],
    [
        "question" => "How can I track the progress of my case?",
        "answer" => "We provide regular updates on your case and offer online case tracking through our client portal."
    ],
    [
        "question" => "Does CounselHub handle pro bono cases?",
        "answer" => "Yes, we take on a limited number of pro bono cases each year. Please contact us to see if your case qualifies."
    ],
    [
        "question" => "What languages does the CounselHub team speak?",
        "answer" => "Our team speaks English, Spanish, and French, ensuring effective communication with a diverse range of clients."
    ],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frequently Asked Questions</title>
    <link rel="stylesheet" href="/frontend/css/FAQ.css">
</head>
<body>
    <?php include_once "../../components/customer/header/navBar.php"; ?>
    <div class="app-container">
        <div class="faqs-card-container">
            <h1>Frequently Asked Questions</h1>
            <ul class="faqs-list-container">
                <?php foreach ($faqs as $faq): ?>
                    <li class="faq-item">
                        <div class="faq-question">Q: <?php echo $faq['question']; ?></div>
                        <div class="faq-answer">A: <?php echo $faq['answer']; ?></div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <?php include_once "../../components/customer/footer/footer.php"; ?>
</body>
</html>