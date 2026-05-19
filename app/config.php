<?php
define('DATA_DIR', __DIR__ . '/data/');
define('USERS_FILE', DATA_DIR . 'users.json');
define('PRODUCTS_FILE', DATA_DIR . 'products.json');
define('INVOICES_FILE', DATA_DIR . 'invoices.json');

// Email settings (for PHPMailer)
define('SMTP_HOST', 'smtp.example.com'); // Replace with actual
define('SMTP_USERNAME', 'your_email@example.com');
define('SMTP_PASSWORD', 'your_password');
define('SMTP_PORT', 587);
define('FROM_EMAIL', 'noreply@example.com');
define('FROM_NAME', 'Sistema de Compras');

// Admin credentials (hashed)
define('ADMIN_EMAIL', 'admin@example.com');
define('ADMIN_PASSWORD_HASH', password_hash('admin123', PASSWORD_DEFAULT)); // Change this

// Points system: 1 point per 10 currency spent
define('POINTS_PER_CURRENCY', 0.1);
?>