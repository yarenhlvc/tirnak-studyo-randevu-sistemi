<?php
session_start();
session_destroy(); // Tüm oturum bilgilerini siler
header("Location: index.php"); // Ana sayfaya gönderir
exit;
?>