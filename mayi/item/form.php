<?php
/**
 * いちばんやさしいPHPの教本 サンプルコード
 * 2015 Copyright(c) Alleyoop inc. (http://alleyoop.jp)
 *
 * add.php レシピ追加処理
 */

//データベース設定の読み込み
require_once(dirname(__FILE__) . "/../db_config.php");

//try〜catchにてエラーハンドリングを行う。
try {

    //$_GET['id']が空かのチェックを行う。（id=0でもこの場合Exceptionを発生させる)
    if (empty($_GET['id'])) throw new Exception('Error');

    //取得した$_GET['id']は文字列であるため数値型に変換を行う。
    $id = (int)$_GET['id'];

    //PDOを使ったデータベースへの接続
    //$user,$passはdb_config.phpにて定義済み
    $dbh = new PDO('mysql:host=localhost;dbname=mamazon;charset=utf8', $user, $pass);

    //PDOの実行モードの設定
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //データ取得のSQLを生成
    $sql = "SELECT * FROM item WHERE id = ?";
    //SQL実行の準備
    $stmt = $dbh->prepare($sql);
    //bindParamにてidの値をセットする
    $stmt->bindValue(1, $id, PDO::PARAM_INT);
    //SQLの実行
    $stmt->execute();
    //SQLの実行結果を$resultに取得する
    $item = $stmt->fetch(PDO::FETCH_ASSOC);


    //データ取得のSQLを生成
    $sql = "SELECT id, chinese_name  FROM brand ORDER BY id DESC ";
    //SQLの実行
    $stmt = $dbh->query($sql);
    //SQLの結果を$resultに取得する
    $brand = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //データ取得のSQLを生成
    $sql = "SELECT id, name FROM shop ORDER BY id";
    //SQLの実行
    $stmt = $dbh->query($sql);
    //SQLの結果を$resultに取得する
    $shop = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //データ取得のSQLを生成
    $sql = "SELECT id, name FROM ship ORDER BY id";
    //SQLの実行
    $stmt = $dbh->query($sql);
    //SQLの結果を$resultに取得する
    $ship = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
<form method="post" action="action.php">
    <table>
        <tr>
            <td>
                brand：
            </td>
            <td>
                <select name="brand">
                    <?php
                    foreach ($brand as $row) {
                        if($item['brand'] === $row['id'])
                            echo "<option value=\"" . $row['id'] . "\"selected>" . $row['chinese_name'] . "</option>\n";
                        else
                            echo "<option value=\"" . $row['id'] . "\">" . $row['chinese_name'] . "</option>\n";
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                japanese_name：
            </td>
            <td>
                <input type="text" name="japanese_name" size="100"
                       value="<?php echo htmlspecialchars($item['japanese_name'], ENT_QUOTES, 'UTF-8'); ?>" required>
            </td>
        </tr>
        <tr>
            <td>
                chinese_name：
            </td>
            <td>
                <input type="text" name="chinese_name" size="100"
                       value="<?php echo htmlspecialchars($item['chinese_name'], ENT_QUOTES, 'UTF-8'); ?>" required>
            </td>
        </tr>

        <tr>
            <td>
                weight：
            </td>
            <td>
                <input type="number" name="weight"
                       value="<?php echo htmlspecialchars($item['weight'], ENT_QUOTES, 'UTF-8'); ?>" required>
            </td>
        </tr>

        <tr>
            <td>
                shop：
            </td>
            <td>
                 <select name="shop">
                    <?php
                    foreach ($shop as $row) {
                        if($item['shop'] === $row['id'])
                            echo "<option value=\"" . $row['id'] . "\"selected>" . $row['name'] . "</option>\n";
                        else
                            echo "<option value=\"" . $row['id'] . "\">" . $row['name'] . "</option>\n";
                    }
                    ?>
                </select>
            </td>
        </tr>

        <tr>
            <td>
                price_in：
            </td>
            <td>
                <input type="number" name="price_in"
                       value="<?php echo htmlspecialchars($item['price_in'], ENT_QUOTES, 'UTF-8'); ?>" required>
            </td>
        </tr>

        <tr>
            <td>
                price_out：
            </td>
            <td>
                <input type="number" name="price_out"
                       value="<?php echo htmlspecialchars($item['price_out'], ENT_QUOTES, 'UTF-8'); ?>" required>
            </td>
        </tr>

        <tr>
            <td>
                ship：
            </td>
            <td>
                <select name="ship">
                    <?php
                    foreach ($ship as $row) {
                        if($item['ship'] === $row['id'])
                            echo "<option value=\"" . $row['id'] . "\"selected>" . $row['name'] . "</option>\n";
                        else
                            echo "<option value=\"" . $row['id'] . "\">" . $row['name'] . "</option>\n";
                    }
                    ?>
                </select>
            </td>
        </tr>

        <tr>
            <td>
                descripe：
            </td>
            <td>
                <input type="text" name="descripe" size="200"
                       value="<?php echo htmlspecialchars($item['descripe'], ENT_QUOTES, 'UTF-8'); ?>" required>
            </td>
        </tr>

    </table>
    <br/>

    <input type="hidden" name="id" value="<?php echo htmlspecialchars($item['id'], ENT_QUOTES, 'UTF-8'); ?>">
    <input type="hidden" name="action" value="<?php echo htmlspecialchars($_GET['action'], ENT_QUOTES, 'UTF-8'); ?>">

    <input type="submit" value="送信">

    <br/>
    <a href="index.php">return</a>

</form>
</body>
</html>