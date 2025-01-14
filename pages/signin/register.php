<?php

session_start();
if (isset($_SESSION['errors'])) {
    $errors = $_SESSION['errors'];
    unset($_SESSION['errors']);
} else {
    $errors = [];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <div class="container" id="signup">
        <h1 class="form-title">Register</h1>
        <?php
    session_start();
    if (isset($_SESSION['errors'])) {
        echo '<div class="error-messages">';
        foreach ($_SESSION['errors'] as $error) {
            echo '<p class="error">' . htmlspecialchars($error) . '</p>';
        }
        echo '</div>';
        unset($_SESSION['errors']);
    }
    ?>
        <form method="POST" action="user-account.php">
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="first_name" id="first_name" placeholder="First Name" required>
                <?php
                if (isset($errors['first_name'])){
                    echo ' <div class="error">
                    <p>' . $errors['first_name'] . '</p>
                </div>';
                }
                ?>
            </div>

            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="last_name" id="last_name" placeholder="Last Name" required>
                <?php
                if (isset($errors['last_name'])){
                    echo ' <div class="error">
                    <p>' . $errors['last_name'] . '</p>
                </div>';
                }
                ?>
            </div>

            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="username" id="username" placeholder="Username" required>
                <?php
                if (isset($errors['username'])){
                    echo ' <div class="error">
                    <p>' . $errors['username'] . '</p>
                </div>';
                }
                ?>
            </div>

            <div class="input-group">
                <i class="fas fa-phone"></i>
                <input type="text" name="phone" id="phone" placeholder="Phone" maxlength="12" required>
                <?php
                if (isset($errors['phone'])) {
                    echo '<div class="error">
                    <p>' . $errors['phone'] . '</p>
                    </div>';
                    unset($errors['phone']);

                }
                ?>
            </div>

            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" id="email" placeholder="Email" required>
                <?php
                if (isset($errors['email'])) {
                    echo '<div class="error">
                    <p>' . $errors['email'] . '</p>
                    </div>';
                    unset($errors['email']);

                }
                ?>
            </div>

            <div class="input-group password">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" id="password" placeholder="Password" required>
                <i id="eye" class="fa fa-eye"></i>
                <?php
                if (isset($errors['password'])) {
                    echo '<div class="error">
                    <p>' . $errors['password'] . '</p>
                    </div>';
                    unset($errors['password']);

                }
                ?>
            </div>

            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="confirm_password" placeholder="Confirm Password" pattern="(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&#]).{8,}" 
           title="Password must contain at least 8 characters, one uppercase, one lowercase, one digit, and one special character" required>
                <?php
                if (isset($errors['confirm_password'])) {
                    echo '<div class="error">
                    <p>' . $errors['confirm_password'] . '</p>
                    </div>';
                    unset($errors['confirm_password']);

                }
                ?>
            </div>

            <input type="submit" class="btn" value="Sign Up" name="signup">
        </form>
        <div class="links">
            <p>Already Have Account?</p>
            <a href="index.php">Sign In</a>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // First Name ve Last Name: Harfler ve sadece "-" veya "'" özel karakterlerine izin ver
            const nameFields = document.querySelectorAll("#first_name, #last_name");
            nameFields.forEach((field) => {
                field.addEventListener("input", function () {
                    this.value = this.value.replace(/[^a-zA-ZığüşöçİĞÜŞÖÇ\-']/g, ""); // Sadece harfler ve "-', izin ver
                });
            });

            // Phone: Sadece rakamlara izin ver
            const phoneField = document.getElementById("phone");
            phoneField.addEventListener("input", function () {
                this.value = this.value.replace(/\D/g, ""); // Rakam olmayanları kaldır
            });

            // Username: En az 3 karakter uzunlukta olmalı ve ".", "-", "_" karakterlerine izin ver ama başlangıçta kullanılamaz
const usernameField = document.getElementById("username");
usernameField.addEventListener("input", function () {
    // Başlangıçta ".", "-", "_" karakterlerini engelle
    if (/^[._-]/.test(this.value)) {
        this.value = this.value.substring(1); // İlk karakteri kaldır
    }

    // Sadece harf, rakam, ".", "-", "_" karakterlerine izin ver
    this.value = this.value.replace(/[^a-zA-Z0-9._-]/g, ""); 

    // Minimum uzunluk kontrolü
    if (this.value.length < 3) {
        this.setCustomValidity("Username must be at least 3 characters long and cannot start with '.', '-', or '_'.");
    } else {
        this.setCustomValidity(""); // Hata yoksa temizle
    }
});


            // Email: Geçerli domain kontrolü (ör: @hotmail.com)
            const emailField = document.getElementById("email");
            emailField.addEventListener("input", function () {
                const validDomains = ["hotmail.com", "gmail.com", "yahoo.com", "stu.khas.edu.tr", "khas.edu.tr"]; // İzin verilen domainler
                const emailParts = this.value.split("@");
                if (emailParts.length === 2) {
                    const domain = emailParts[1];
                    if (!validDomains.some((validDomain) => domain.endsWith(validDomain))) {
                        this.setCustomValidity("Email must end with @hotmail.com, @gmail.com, or @yahoo.com.");
                    } else {
                        this.setCustomValidity(""); // Hata yoksa temizle
                    }
                } else {
                    this.setCustomValidity("Please enter a valid email address.");
                }
            });

            // Password: Regex kuralları
            const passwordField = document.getElementById("password");
            passwordField.addEventListener("input", function () {
                const password = this.value;
                const regex = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/;
                if (!regex.test(password)) {
                    this.setCustomValidity(
                        "Password must contain at least 8 characters, one uppercase letter, one lowercase letter, one number, and one special character."
                    );
                } else {
                    this.setCustomValidity(""); // Hata yoksa temizle
                }
            });
        });
    </script>
    <script src="script.js"></script>
</body>

</html>
<?php
if(isset($_SESSION['errors'])){
    unset($_SESSION['errors']);
}
?>
