<?php
$cookieConsentGiven = isset($_COOKIE['cookie_consent']) && $_COOKIE['cookie_consent'] === 'yes';
?>

<link rel="stylesheet" href="http://lab02.com/frontend/css/styles.css">

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cookie Declaration</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="content">
        <h1>Cookie Declaration</h1>
        <p>Our website uses cookies to enhance your browsing experience. By continuing to use our site, you consent to our use of cookies as outlined in this declaration.</p>
    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cookie Consent</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #356859;
            --secondary-color: #fff;
            --border-color: #356859;
            --hover-color: #264A3E;
        }

        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
        }

        .cookie-banner {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: var(--secondary-color);
            box-shadow: 0px -2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            z-index: 1000;
            border-top: 1px solid #ddd;
        }

        .cookie-banner p {
            font-size: 16px;
            text-align: center;
            color: #333;
            margin-bottom: 20px;
            max-width: 600px;
        }

        .cookie-banner button {
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            color: var(--secondary-color);
            background-color: var(--primary-color);
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-bottom: 10px;
        }

        .cookie-banner button:hover {
            background-color: var(--hover-color);
        }

        .cookie-settings {
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            color: var(--primary-color);
            background-color: var(--secondary-color);
            border: 1px solid var(--border-color);
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .cookie-settings:hover {
            background-color: var(--primary-color);
            color: var(--secondary-color);
        }

        .hidden {
            display: none;
        }
    </style>
</head>
<body>
<?php if (!isset($cookieConsentGiven) || !$cookieConsentGiven): ?>
    <div class="cookie-banner" id="cookie-banner">
        <p>
            By clicking “Accept All Cookies”, you agree to the storing of cookies on your device to enhance
            site navigation, analyze site usage, and assist in our marketing efforts. By clicking "Cookie Settings" you
            can manage your cookie preferences.
        </p>
        <button id="accept-all-cookies">Accept All Cookies</button>
        <button class="cookie-settings" id="cookie-settings">Cookies Settings</button>
    </div>
<?php endif; ?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const acceptButton = document.getElementById('accept-all-cookies');
        const cookieBanner = document.getElementById('cookie-banner');

        acceptButton.addEventListener('click', function () {
            // Set a cookie via JavaScript for 30 days
            const date = new Date();
            date.setTime(date.getTime() + (30 * 24 * 60 * 60 * 1000)); // 30 days
            document.cookie = `cookie_consent=yes; expires=${date.toUTCString()}; path=/; SameSite=Lax`;

            // Hide the banner
            cookieBanner.classList.add('hidden');
        });

        const settingsButton = document.getElementById('cookie-settings');
        settingsButton.addEventListener('click', function () {
            alert('Cookie settings dialog will appear here. Customize as needed!');
        });
    });
</script>
</body>
</html>
