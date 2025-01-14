<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cookie Consent</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            overflow: hidden; 
        }

        .cookie-banner-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8); 
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .cookie-banner {
            background: #EFE6D9;
            border-radius: 10px;
            max-width: 500px;
            padding: 30px;
            text-align: center;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .cookie-banner h2 {
            font-size: 24px;
            color: #000000;
            margin-bottom: 15px;
        }

        .cookie-banner p {
            font-size: 16px;
            color: #000000;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .accept-button {
            padding: 12px 20px;
            font-size: 16px;
            font-weight: bold;
            color: #fff;
            background-color: #3E2723; 
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-bottom: 10px;
            width: 100%;
        }

        .accept-button:hover {
            background-color: #388e3c;
        }

        .settings-button {
            padding: 12px 20px;
            font-size: 16px;
            font-weight: bold;
            color: #3e2723; 
            background-color: #d7ccc8;
            border: 1px solid #3e2723;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, color 0.3s ease;
            width: 100%;
        }

        .settings-button:hover {
            background-color: #3e2723;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="cookie-banner-overlay" id="cookie-banner-overlay">
        <div class="cookie-banner">
            <h2>Cookie Consent Required 🍪</h2>
            <p>
                We use cookies to enhance your experience, analyze site usage, and assist in our marketing efforts.
                By clicking "Accept All Cookies," you consent to the use of cookies. Click "Cookie Settings" to
                customize your preferences.
            </p>
            <button class="accept-button" id="accept-all-cookies">Accept All Cookies</button>
            <button class="settings-button" id="cookie-settings">Cookie Settings</button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const acceptButton = document.getElementById('accept-all-cookies');
            const settingsButton = document.getElementById('cookie-settings');
            const cookieBannerOverlay = document.getElementById('cookie-banner-overlay');

            acceptButton.addEventListener('click', function () {

                const date = new Date();
                date.setTime(date.getTime() + (30 * 24 * 60 * 60 * 1000)); // 30 days
                document.cookie = `cookie_consent=yes; expires=${date.toUTCString()}; path=/; SameSite=Lax`;

                // Hide the cookie modal
                cookieBannerOverlay.style.display = 'none';

                document.body.style.overflow = 'auto';
            });

            settingsButton.addEventListener('click', function () {
                alert('Cookie settings modal or page will appear here. Customize as needed!');
            });

            if (!document.cookie.includes('cookie_consent=yes')) {
                cookieBannerOverlay.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }
        });
    </script>
</body>
</html>
