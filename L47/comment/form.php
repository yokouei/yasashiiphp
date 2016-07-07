<?php
/**
 * いちばんやさしいPHPの教本 サンプルコード
 * 2015 Copyright(c) Alleyoop inc. (http://alleyoop.jp)
 *
 * add.php レシピ追加処理
 */

//データベース設定の読み込み
require_once '\xampp\db_config.php';

//try〜catchにてエラーハンドリングを行う。
try {

    //PDOを使ったデータベースへの接続
    //$user,$passはdb_config.phpにて定義済み
    $dbh = new PDO('mysql:host=localhost;dbname=db1;charset=utf8', $user, $pass);

    //PDOの実行モードの設定
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //データ取得のSQLを生成
    $sql = "SELECT * FROM difficulty ORDER BY id";
    //SQLの実行
    $stmt = $dbh->query($sql);
    //SQLの結果を$resultに取得する
    $difficulty = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //データ取得のSQLを生成
    $sql = "SELECT * FROM category ORDER BY id";
    //SQLの実行
    $stmt = $dbh->query($sql);
    //SQLの結果を$resultに取得する
    $category = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    //接続を閉じる
    $dbh = null;

    //try{}で発生したPDOExceptionはこの部分でcatchされる
} catch (Exception $e) {
    //エラーメッセージ出力
    echo "エラー発生: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
    //処理の終了
    die();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>入力フォーム</title>
</head>
<body>
入力フォーム<br/><br/>
<form method="post" action="add.php">
    <table>
        <tr>
            <td>
料理名：
            </td>
            <td>
                <input type="text" name="recipe_name" required>
            </td>
        </tr>
        <tr>
            <td>
カテゴリ：
            </td>
            <td>
                <select name="category">
                   <!-- <option value="">選択してください</option>
                    <option value="1">和食</option>
                    <option value="2">中華</option>
                    <option value="3">洋食</option>-->
                    <?php
                    foreach ($category as $row) {
                        echo "<option value=\"".$row['id']."\">".$row['name']."</option>\n";
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>
難易度：
            </td>
            <td>
                <!--
                <input type="radio" name="difficulty" value="1">簡単
                <input type="radio" name="difficulty" value="2" checked>普通
                <input type="radio" name="difficulty" value="3">難しい
                -->
                <?php
                foreach ($difficulty as $row) {
                    echo "<input type=\"radio\" name=\"difficulty\" value=\"".$row['id']."\">".$row['name']."\n";
                }
                ?>
            </td>
        </tr>

        <tr>
            <td>
予算：
            </td>
            <td>
                <input type="number" min="1" max="9999" name="budget">円
            </td>
        </tr>

        <tr>
            <td>
作り方：
            </td>
            <td>
                <textarea name="howto" cols="40" rows="4" maxlength="150"></textarea>
            </td>
        </tr>

    </table>
    <br/>
    <input type="submit" value="送信">
</form>
</body>
</html>