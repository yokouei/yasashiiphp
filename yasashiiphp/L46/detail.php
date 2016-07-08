<?php
$user = "data_user";
$pass = "LsNbmtrWTZd6yh67";

try {
    if (empty($_GET['id'])) throw new Exception('Error');
   
    $id = (int)$_GET['id'];
   
    $dbh = new PDO('mysql:host=localhost;dbname=db1;charset=utf8', $user, $pass);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   
    $sql = "SELECT * FROM recipes WHERE id = ?";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $id, PDO::PARAM_INT);
    $stmt->execute();
  
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
   
    echo "料理名:" . htmlspecialchars($result['recipe_name'], ENT_QUOTES, 'UTF-8') . "<br>\n";
    echo "カテゴリ:" . htmlspecialchars($result['category'], ENT_QUOTES, 'UTF-8') . "<br>\n";
    echo "予算:" . htmlspecialchars($result['budget'], ENT_QUOTES, 'UTF-8') . "<br>\n";
    echo "難易度:" . htmlspecialchars($result['difficulty'], ENT_QUOTES, 'UTF-8') . "<br>\n";
    echo "作り方:<br>" . nl2br(htmlspecialchars($result['howto'], ENT_QUOTES, 'UTF-8')) . "<br>\n";
   
    $dbh = null;
   
    echo "<a href='index.php'>トップページへ戻る</a>";
} catch (Exception $e) {
    echo "エラー発生: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
    die();
}