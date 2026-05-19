<?php
define('DATA_DIR', __DIR__ . '/data/');
define('USERS_FILE', DATA_DIR . 'users.json');
define('PRODUCTS_FILE', DATA_DIR . 'products.json');
define('INVOICES_FILE', DATA_DIR . 'invoices.json');

define('SMTP_HOST', 'smtp.example.com');
define('SMTP_USERNAME', 'your_email@example.com');
define('SMTP_PASSWORD', 'your_password');
define('SMTP_PORT', 587);
define('FROM_EMAIL', 'noreply@example.com');
define('FROM_NAME', 'Sistema de Compras');

define('ADMIN_EMAIL', 'admin@example.com');
define('ADMIN_PASSWORD_HASH', '$2y$12$RPGK99uZQvrU50xE2YOOFejil6GrUmLcdzUgN3Lnmf1I9D1Gr2sSi');

define('POINTS_PER_CURRENCY', 0.1);
?> 