document.addEventListener("DOMContentLoaded", function () {
    // First Name ve Last Name: Sadece harflere izin ver
    const nameFields = document.querySelectorAll("#first_name, #last_name");
    nameFields.forEach((field) => {
        field.addEventListener("input", function () {
            this.value = this.value.replace(/[^a-zA-Z]/g, ""); // Harf olmayanları kaldır
        });
    });

    // Phone: Sadece rakamlara izin ver
    const phoneField = document.getElementById("phone");
    phoneField.addEventListener("input", function () {
        this.value = this.value.replace(/\D/g, ""); // Rakam olmayanları kaldır
    });

    // Email: Geçerli domain kontrolü (ör: @hotmail.com)
    const emailField = document.getElementById("email");
    emailField.addEventListener("input", function () {
        const validDomains = ["hotmail.com", "gmail.com", "yahoo.com"]; // İzin verilen domainler
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
