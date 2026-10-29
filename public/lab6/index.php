<?php
session_start();
header('Location: ' . (isset($_SESSION['user_id']) ? 'Welcome.php' : 'login.php'));
exit;