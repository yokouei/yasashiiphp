<?php
$user = "data_user";
$pass = "LsNbmtrWTZd6yh67";

try {
    $dbh = new PDO('mysql:host=localhost;dbname=db1;charset=utf8', $user, $pass);

    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT * FROM recipes";
    $stmt = $dbh->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<table>\n";
    echo "<tr>\n";
    echo "<th>料理名</th><th>予算</th><th>難易度</th>\n";
    echo "</tr>\n";
    echo "</table>\n";

    $dbh = null;
} catch (PDOException $e) {
    echo "エラー発生: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
    die();
}
?>