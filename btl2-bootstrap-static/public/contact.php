<?php
/**
 * public/contact.php
 * Entry point nhận request POST từ form liên hệ ở index.php (#lien-he).
 * Chỉ có nhiệm vụ nạp cấu hình + controller, rồi giao việc xử lý cho
 * ContactController — bản thân file này không chứa logic nghiệp vụ.
 */

session_start();
require_once __DIR__ . '/../config/config.php';
require_once BASE_PATH . '/controllers/ContactController.php';

$controller = new ContactController();
$controller->xuLy();
