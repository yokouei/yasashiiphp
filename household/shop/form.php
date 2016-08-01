<?php
/**
 * いちばんやさしいPHPの教本 サンプルコード
 * 2015 Copyright(c) Alleyoop inc. (http://alleyoop.jp)
 *
 * add.php レシピ追加処理
 */

//データベース設定の読み込み
require_once(dirname(__FILE__) . "/../db_config.php");
require '/../formhelpers.php';

//try〜catchにてエラーハンドリングを行う。
try {

    //$_GET['id']が空かのチェックを行う。（id=0でもこの場合Exceptionを発生させる)
    if (empty($_GET['id'])) throw new Exception('Error');

    //取得した$_GET['id']は文字列であるため数値型に変換を行う。
    $id = (int)$_GET['id'];

    //PDOを使ったデータベースへの接続
    //$user,$passはdb_config.phpにて定義済み
    $dbh = new PDO('mysql:host=localhost;dbname=household_budget;charset=utf8', $user, $pass);

    //PDOの実行モードの設定
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //データ取得のSQLを生成
    $sql = "SELECT shop.*, account.name as account_name FROM shop 
LEFT JOIN (SELECT DISTINCT account.id, concat(account.name, '(' , member.name , ')') as name FROM account LEFT JOIN member ON account.owner = member.id) as account ON shop.account = account.id 
WHERE shop.id = ?";
    //SQL実行の準備
    $stmt = $dbh->prepare($sql);
    //bindParamにてidの値をセットする
    $stmt->bindValue(1, $id, PDO::PARAM_INT);
    //SQLの実行
    $stmt->execute();
    //SQLの実行結果を$resultに取得する
    $item = $stmt->fetch(PDO::FETCH_ASSOC);


    //データ取得のSQLを生成
    $sql = "SELECT id, name  FROM type WHERE income_expense = ? ORDER BY id ";
    //SQL実行の準備
    $stmt = $dbh->prepare($sql);
    //bindParamにてidの値をセットする
    $stmt->bindValue(1, $item['income_expense'], PDO::PARAM_INT);
    //SQLの実行
    $stmt->execute();
    //SQLの結果を$resultに取得する
    $type = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //データ取得のSQLを生成
    $sql = "SELECT id, name FROM member ORDER BY id";
    //SQLの実行
    $stmt = $dbh->query($sql);
    //SQLの結果を$resultに取得する
    $owner = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
                name：
            </td>
            <td>
                <input type="text" name="name" size="100"
                       value="<?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?>" required>
            </td>
        </tr>

        <tr>
            <td>
                account：
            </td>
            <td>
                <?php echo htmlspecialchars($item['account_name'], ENT_QUOTES, 'UTF-8'); ?>
            </td>
        </tr>

        <tr>
            <td>
                type：
            </td>
            <td>
                <select name="type">
                    <?php
                    foreach ($type as $row) {
                        if($item['type'] === $row['id'])
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
                user：
            </td>
            <td>
                 <select name="user">
                    <?php
                    foreach ($owner as $row) {
                        if($item['user'] === $row['id'])
                            echo "<option value=\"" . $row['id'] . "\"selected>" . $row['name'] . "</option>\n";
                        else
                            echo "<option value=\"" . $row['id'] . "\">" . $row['name'] . "</option>\n";
                    }
                    ?>
                </select>
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