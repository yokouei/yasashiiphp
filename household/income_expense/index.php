<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>レシピの一覧</title>
</head>
<body>
<h1>レシピの一覧</h1>
<!--<a href="form.php">レシピの新規登録</a>-->
<?php
/**
 * いちばんやさしいPHPの教本 サンプルコード
 * 2015 Copyright(c) Alleyoop inc. (http://alleyoop.jp)
 *
 * index.php 一覧表示処理
 */

//データベース設定の読み込み
//require_once '\xampp\db_config.php';
require_once(dirname(__FILE__)."/../db_config.php");
require_once(dirname(__FILE__) . "/../formhelpers.php");

// setup the arrays of choices in the select menus
// these are needed in display_form(), validate_form(),
// and process_form(), so they are declared in the global scope
$accounts = array();

$years = array();
for ($year = date('Y') - 1, $max_year = date('Y') + 1 ; $year < $max_year; $year++) {
    $years[$year] = $year;
}
$months = array();
for ($i = 1; $i <= 12; $i++) { $months[$i] = $i; }

//try〜catchにてエラーハンドリングを行う。
try {
    //PDOを使ったデータベースへの接続
    //$user,$passはdb_config.phpにて定義済み
    $dbh = new PDO('mysql:host=localhost;dbname=household_budget;charset=utf8', $user, $pass);

    //PDOの実行モードの設定
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //前データ取得のSQLを生成
    $sql = "SELECT DISTINCT account.id, concat(account.name, '(' , member.name , ')') as account
FROM income_expense
LEFT JOIN csv ON income_expense.csv = csv.id
LEFT JOIN account ON csv.account_id = account.id
LEFT JOIN member ON account.owner = member.id
ORDER BY account.id ";

    //SQLの実行
    $stmt = $dbh->query($sql);
    //SQLの結果を$resultに取得する
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //取得したデータが無くなるまでforeach()で処理を繰り返す。
    //取得した値は各カラムに表示を行う。
    //ループ処理の開始
    foreach ($result as $row) {
        $accounts[$row['id']] = $row['account'];
        //ループ処理の終了
    }
    
    //接続を閉じる
    $dbh = null;

    //try{}で発生したPDOExceptionはこの部分でcatchされる
} catch (PDOException $e) {
    //エラーメッセージ出力
    echo "エラー発生: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
    //処理の終了
    die();
}

// The main page logic:
// - If the form is submitted, validate and then process or redisplay
// - If it's not submitted, display
//if ($_POST['_submit_check']) {
if (array_key_exists('_submit_check', $_POST)) {
    // If validate_form() returns errors, pass them to show_form()
    if ($form_errors = validate_form()) {
        show_form($form_errors);
    } else {
        show_form();
        // The submitted data is valid, so process it
        process_form();
    }
} else {
    // The form wasn't submitted, so display
    show_form();
}

function show_form($errors = '')
{
    global $accounts, $months, $years;

    // If the form is submitted, get defaults from submitted parameters
    //if ($_POST['_submit_check']) {
    if (array_key_exists('_submit_check', $_POST)) {
        $defaults = $_POST;
    } else {
        // Otherwise, set our own defaults: the current time and date parts
        $defaults = array(
            'month' => date('n')-1,
            'year'  => date('Y'));
    }

    // If errors were passed in, put them in $error_text (with HTML markup)
    if ($errors) {
        $error_text = '<tr><td>You need to correct the following errors:';
        $error_text .= '</td><td><ul><li>';
        $error_text .= implode('</li><li>', $errors);
        $error_text .= '</li></ul></td></tr>';
    } else {
        // No errors? Then $error_text is blank
        $error_text = '';
    }

    // Jump out of PHP mode to make displaying all the HTML tags easier
    ?>
    <form method="POST" action="<?php print $_SERVER['PHP_SELF']; ?>">
        <table>
            <?php print $error_text ?>

            <tr>
                <td>account:</td>
                <td><?php input_select('account', $defaults, $accounts); ?>
                </td>
            </tr>

            <tr>
                <td>year:</td>
                <td>
                    <?php input_select('year',$defaults,$years); ?>
                </td>
            </tr>

            <tr>
                <td>month:</td>
                <td>
                    <?php input_select('month',$defaults,$months); ?>
                </td>
            </tr>

            <tr>
                <td colspan="2" align="center"><?php input_submit('search', 'Search'); ?>
                </td>
            </tr>

        </table>
        <input type="hidden" name="_submit_check" value="1"/>
    </form>
    <?php
} // The end of show_form()

function validate_form()
{
    $errors = array();

    // sweet is required
    if (!array_key_exists($_POST['account'], $GLOBALS['accounts'])) {
        $errors[] = 'Please select a valid account.';
    }

    // sweet is required
    if (!array_key_exists($_POST['month'], $GLOBALS['months'])) {
        $errors[] = 'Please select a valid month.';
    }

    // sweet is required
    if (!array_key_exists($_POST['year'], $GLOBALS['years'])) {
        $errors[] = 'Please select a valid year.';
    }

    return $errors;
}

function process_form()
{
    global $user, $pass;
    global $accounts, $months, $years;
    
    // look up the full names of the sweet and the main dishes in
    // the $GLOBALS['sweets'] and $GLOBALS['main_dishes'] arrays
    $account = $_POST['account'];
    $year = $_POST['year'];
    $month = $_POST['month'];

    //try〜catchにてエラーハンドリングを行う。
    try {
        //PDOを使ったデータベースへの接続
        //$user,$passはdb_config.phpにて定義済み
        $dbh = new PDO('mysql:host=localhost;dbname=household_budget;charset=utf8', $user, $pass);
    
        //PDOの実行モードの設定
        $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        //前データ取得のSQLを生成
        $sql = "SELECT income_expense.income_expense, income_expense.id, time, shop, detail, number, member.name as user, type.name as type
    FROM income_expense
    LEFT JOIN member ON income_expense.member = member.id
    LEFT JOIN type ON income_expense.type = type.id
    LEFT JOIN csv ON income_expense.csv = csv.id
    LEFT JOIN account ON csv.account_id = account.id
    WHERE account.id = ? AND YEAR (income_expense.TIME) = ? AND MONTH (income_expense.TIME) = ?
    ORDER BY time";

        //SQL実行の準備
        $stmt = $dbh->prepare($sql);
        //bindParamにてidの値をセットする
        $stmt->bindValue(1, $account, PDO::PARAM_INT);
        $stmt->bindValue(2, $year, PDO::PARAM_INT);
        $stmt->bindValue(3, $month, PDO::PARAM_INT);

        //SQLの実行
        $stmt->execute();

        //SQLの結果を$resultに取得する
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        //テーブル部分のHTMLを生成
        echo "<table border=\"1\">\n";
        echo "<tr>\n";
        echo "<th>update</th><th>id</th><th>time</th><th>shop</th><th>detail</th><th>number</th><th>user</th><th>type</th><th>income_expense</th>\n";
        echo "</tr>\n";
        //取得したデータが無くなるまでforeach()で処理を繰り返す。
        //取得した値は各カラムに表示を行う。
        //ループ処理の開始
        foreach ($result as $row) {
            echo "<tr>\n";
    
            echo "<td>\n";
            echo "<a href=form.php?id=" . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . "&action=1>update</a>\n";
            //echo "|<a href=form.php?id=" . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . "&action=2>copy</a>\n";
            //echo "|<a href=form.php?id=" . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . "&action=3>delete</a>\n";
            echo "</td>\n";
    
            echo "<td>" . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . "</td>\n";
            //echo "<td><a href=" . htmlspecialchars($row['link'], ENT_QUOTES, 'UTF-8') . ">".htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8')."</a></td>\n";
            echo "<td>" . htmlspecialchars($row['time'], ENT_QUOTES, 'UTF-8') . "</td>\n";
            echo "<td>" . htmlspecialchars($row['shop'], ENT_QUOTES, 'UTF-8') . "</td>\n";
            echo "<td>" . htmlspecialchars($row['detail'], ENT_QUOTES, 'UTF-8') . "</td>\n";
            echo "<td>" . htmlspecialchars($row['number'], ENT_QUOTES, 'UTF-8') . "</td>\n";
            echo "<td>" . htmlspecialchars($row['user'], ENT_QUOTES, 'UTF-8') . "</td>\n";
            echo "<td>" . htmlspecialchars($row['type'], ENT_QUOTES, 'UTF-8') . "</td>\n";
            echo "<td>" . htmlspecialchars($row['income_expense'], ENT_QUOTES, 'UTF-8') . "</td>\n";
            //echo "<td>" . htmlspecialchars($row['owner'], ENT_QUOTES, 'UTF-8') . "</td>\n";
    
            echo "</tr>\n";
            //ループ処理の終了
        }
        //テーブルタグを閉じる
        echo "</table>\n";
        //接続を閉じる
        $dbh = null;
    
    //try{}で発生したPDOExceptionはこの部分でcatchされる
    } catch (PDOException $e) {
        //エラーメッセージ出力
        echo "エラー発生: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
        //処理の終了
        die();
    }


}

?>


</body>
</html>



