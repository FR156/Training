<?php
require_once '../../includes/session.php';
requireAdmin();

require_once '../../includes/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    deleteUpload($id);
}

header('Location: dashboard.php');
exit;
?>