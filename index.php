<?php
// Root-level index.php — entry point for Render

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Optional: respond to GET requests (browser visits)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo "✅ Telegram bot is running!";
    exit;
}

// Include your actual bot logic
require_once __DIR__ . '/Daisuke/bot/index.php';
?>
