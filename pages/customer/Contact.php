<link rel="stylesheet" href="http://lab02.com/frontend/css/Contact.css">

<?php
$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name'] ?? '');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $message = htmlspecialchars($_POST['message'] ?? '');

    if (empty($name) || empty($email) || empty($message)) {
        $errorMessage = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMessage = "Please enter a valid email address.";
    } else {
        $to = "your-email@example.com";
        $subject = "New Contact Form Submission";
        $body = "Name: $name\nEmail: $email\nMessage: $message";
        $headers = "From: $email";

        if (mail($to, $subject, $body, $headers)) {
            $successMessage = "Thank you for your message. We will get back to you shortly!";
            $name = $email = $message = "";
        } else {
            $errorMessage = "There was an error sending your message. Please try again later.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="http://lab02.com/frontend/css/Contact.css">
</head>
<body>
    <?php include_once "../../components/customer/header/navBar.php"; ?>
    <div class="contact-container">
        <h2>Welcome to Contact Page for CounselHub</h2>
        <p>We're thrilled to hear from you. Please fill out the form below and we will get back to you as soon as possible.</p>
        <form class="contact-form" method="POST" action="">
            <input type="text" name="name" placeholder="Your Name" value="<?php echo htmlspecialchars($name ?? ''); ?>" required>
            <input type="email" name="email" placeholder="Your Email Address" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
            <textarea name="message" placeholder="Your Message" required><?php echo htmlspecialchars($message ?? ''); ?></textarea>
            <button type="submit">Send Message</button>
        </form>
        <?php if (!empty($errorMessage)): ?>
            <p style="color: red; margin-top: 20px;"><?php echo $errorMessage; ?></p>
        <?php endif; ?>
        <?php if (!empty($successMessage)): ?>
            <p style="color: green; margin-top: 20px;"><?php echo $successMessage; ?></p>
        <?php endif; ?>
    </div>
    <?php include_once "../../components/customer/footer/footer.php"; ?>
</body>
</html>


