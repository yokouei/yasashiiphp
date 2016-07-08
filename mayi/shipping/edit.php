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
    $sql = "SELECT * FROM shipping WHERE id = ?";
    //SQL実行の準備
    $stmt = $dbh->prepare($sql);
    //bindParamにてidの値をセットする
    $stmt->bindValue(1, $id, PDO::PARAM_INT);
    //SQLの実行
    $stmt->execute();
    //SQLの実行結果を$resultに取得する
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    //接続を閉じる
    $dbh = null;

//try{}で発生したPDOExceptionはこの部分でcatchされる
} catch (Exception $e) {
    //エラーメッセージ出力
    echo "エラー発生: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
    //処理の終了
    die();
}
//下記で取得したデータを取り込んだHTMLを表示
//本編の通りの記述ではカテゴリと難易度の表示が正しく出来ませんでした。
//データベースから取得したカテゴリと難易度は数値型であるため比較ではダブルコーテーション無しで
//比較を行ってください。
//誤 $result['category'] === "1"
//正 $result['category'] === 1
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>入力フォーム</title>
</head>
<body>
レシピの投稿<br>
<form method="post" action="update.php">
    <table>

        <tr>
            <td>
                number：
            </td>
            <td>
                <input type="text" name="number"
                       value="<?php echo htmlspecialchars($result['number'], ENT_QUOTES, 'UTF-8'); ?>" readonly>
            </td>
        </tr>

        <tr>
            <td>
                send_time：
            </td>
            <td>
                <input type="text" name="send_time"
                       value="<?php echo htmlspecialchars($result['send_time'], ENT_QUOTES, 'UTF-8'); ?>" required>
            </td>
        </tr>

        <tr>
            <td>
                receive_time：
            </td>
            <td>
                <input type="text" name="receive_time"
                       value="<?php echo htmlspecialchars($result['receive_time'], ENT_QUOTES, 'UTF-8'); ?>" required>
            </td>
        </tr>

        <tr>
            <td>
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($result['id'], ENT_QUOTES, 'UTF-8'); ?>">
            </td>
            <td>
                <input type="submit" value="送信">
            </td>
        </tr>


    </table>
    <br/>



    <a href='index.php'>トップページへ戻る</a>
</form>
</body>
</html>
