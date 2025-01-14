<?php
$hashedPassword = password_hash('12345@Mehmet', PASSWORD_BCRYPT);
echo $hashedPassword;
