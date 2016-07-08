<?php
$user = "data_user";
$pass = "LsNbmtrWTZd6yh67";

try {
    $end = strtotime('3 months ago');
    var_dump($end);

    if (empty($_GET['id'])) throw new Exception('Error');

    $id = (int)$_GET['id'];

    var_dump($id);
} catch (Exception $e) {
    echo "エラー発生: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
    die();
}