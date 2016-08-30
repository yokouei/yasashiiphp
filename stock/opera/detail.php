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
    $dbh = new PDO('mysql:host=localhost;dbname=stock;charset=utf8', $user, $pass);

    //PDOの実行モードの設定
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //データ取得のSQLを生成
    $sql = "SELECT * FROM opera WHERE id = ?";
    //SQL実行の準備
    $stmt = $dbh->prepare($sql);
    //bindParamにてidの値をセットする
    $stmt->bindValue(1, $id, PDO::PARAM_INT);
    //SQLの実行
    $stmt->execute();
    //SQLの実行結果を$resultに取得する
    $item = $stmt->fetch(PDO::FETCH_ASSOC);

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

<a href="index.php">return</a><br/>

<form>
    <table>

        <tr>
            <td>
                stock：
            </td>
            <td>
                <?php echo htmlspecialchars($item['stock'], ENT_QUOTES, 'UTF-8'); ?>
            </td>

            <td>
                account：
            </td>
            <td>
                <?php echo htmlspecialchars($item['account'], ENT_QUOTES, 'UTF-8'); ?>
            </td>

        </tr>


        
        <tr>
            <td>
                buy_time：
            </td>
            <td>
                <?php echo htmlspecialchars($item['buy_time'], ENT_QUOTES, 'UTF-8'); ?>
            </td>

            <td>
                sell_time：
            </td>
            <td>
                <?php echo htmlspecialchars($item['sell_time'], ENT_QUOTES, 'UTF-8'); ?>
            </td>

        </tr>

        <tr>
            <td>
                buy_price：
            </td>
            <td>
                <?php echo htmlspecialchars($item['buy_price'], ENT_QUOTES, 'UTF-8'); ?>
            </td>

            <td>
                sell_price：
            </td>
            <td>
                <?php echo htmlspecialchars($item['sell_price'], ENT_QUOTES, 'UTF-8'); ?>
            </td>
        </tr>

        <tr>
            <td valign="top">
                buy_image：
            </td>
            <td>
                <img src=<?php echo "../image/" . htmlspecialchars($item['buy_image'], ENT_QUOTES, 'UTF-8'); ?> width="320" height="568">
            </td>

            <td valign="top">
                sell_image：
            </td>
            <td>
                <img src=<?php echo "../image/" . htmlspecialchars($item['sell_image'], ENT_QUOTES, 'UTF-8'); ?> width="320" height="568">
            </td>
        </tr>

        
    </table>


</form>
</body>
</html>