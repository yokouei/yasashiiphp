<?php
$user = "data_user";
$pass = "LsNbmtrWTZd6yh67";

try {
    $dbh = new PDO('mysql:host=localhost;dbname=db1;charset=utf8', $user, $pass);

    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    
    //$sql = "SELECT * FROM recipes WHERE id = " . $_GET['id'];
    $sql = "SELECT * FROM recipes WHERE id = ?";
    
    //$result = $dbh->query($sql,PDO::FETCH_ASSOC);

    $id = (int)$_GET['id'];
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    var_dump($stmt);
   
    echo "<pre>";
    //print_r($result->fetchall());
    print_r($result);

} catch (Exception $e) {
    echo "エラー発生: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
    die();
}