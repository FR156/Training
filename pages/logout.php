<?php
require_once '../includes/session.php';

logoutUser();
header('Location: login.php');
exit;
?>