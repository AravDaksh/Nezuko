<?php
// Root-level index.php — entry point for Render or any PHP web host

// Enable error display for debugging (you can remove this later)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include your main bot webhook script
require_once __DIR__ . '/Daisuke/bot/index.php';
?>
