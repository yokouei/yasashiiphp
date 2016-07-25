<?php

//データベース設定の読み込み
//require_once '\xampp\db_config.php';
require_once(dirname(__FILE__)."/../db_config.php");
require 'read_csv.php';

//try〜catchにてエラーハンドリングを行う。
try {
    if (array_key_exists('id', $_POST) && $_POST['id']) {
        // If validate_form() returns errors, pass them to show_form()
        //$_GET['id']が空かのチェックを行う。（id=0でもこの場合Exceptionを発生させる)
        if (empty($_POST['id'])) throw new Exception('Error');

        //取得した$_GET['id']は文字列であるため数値型に変換を行う。
        $id = (int)$_POST['id'];
    } else {
        //$_GET['id']が空かのチェックを行う。（id=0でもこの場合Exceptionを発生させる)
        if (empty($_GET['id'])) throw new Exception('Error');

        //取得した$_GET['id']は文字列であるため数値型に変換を行う。
        $id = (int)$_GET['id'];
    }

    //PDOを使ったデータベースへの接続
    //$user,$passはdb_config.phpにて定義済み
    $dbh = new PDO('mysql:host=localhost;dbname=household_budget;charset=utf8', $user, $pass);

    //PDOの実行モードの設定
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //前データ取得のSQLを生成
    $sql = "SELECT * FROM csv WHERE id = ?";

    //SQL実行の準備
    $stmt = $dbh->prepare($sql);
    //bindParamにてidの値をセットする
    $stmt->bindValue(1, $id, PDO::PARAM_INT);
    //SQLの実行
    $stmt->execute();

    //SQLの結果を$resultに取得する
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    //接続を閉じる
    $dbh = null;

//try{}で発生したPDOExceptionはこの部分でcatchされる
} catch (PDOException $e) {
    //エラーメッセージ出力
    echo "エラー発生: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
    //処理の終了
    die();
}


if (array_key_exists('id', $_POST) && $_POST['id']) {
    // If validate_form() returns errors, pass them to show_form()
    if ($form_errors = validate_form()) {
        show_form($form_errors);
    } else {
        // The submitted data is valid, so process it
        process_form();
    }
} else {
    // The form wasn't submitted, so display
    show_form();
}

function show_form($errors = '') {

    if ($errors) {
        print 'You need to correct the following errors: <ul><li>';
        print implode('</li><li>',$errors);
        print '</li></ul>';
    }

    global $result;

    print<<<_HTML_
<form enctype="multipart/form-data" method="POST"
      action="$_SERVER[PHP_SELF]">

File to Upload: <input name="my_file" type="file"/>

<input type="hidden" name="MAX_FILE_SIZE" value="131072"/>
<input type="hidden" name="id" value="{$result['id']}">
<input type="submit" value="Upload"/>
</form>
_HTML_;


    echo "<a href=index.php?id=" . htmlspecialchars($result['account_id'], ENT_QUOTES, 'UTF-8') . ">トップページへ戻る</a>\n";
}

function validate_form() {
    $errors = array();

    if (($_FILES['my_file']['error'] == UPLOAD_ERR_INI_SIZE)||
        ($_FILES['my_file']['error'] == UPLOAD_ERR_FORM_SIZE)) {
        $errors[] = 'Uploaded file is too big.';
    } elseif ($_FILES['my_file']['error'] == UPLOAD_ERR_PARTIAL) {
        $errors[] = 'File upload was interrupted.';
    } elseif ($_FILES['my_file']['error'] == UPLOAD_ERR_NO_FILE) {
        $errors[] = 'No file uploaded.';
    }

    return $errors;
}

function process_form() {
    print "You uploaded a file called {$_FILES['my_file']['name']} ";
    print "of type {$_FILES['my_file']['type']} that is ";
    print "{$_FILES['my_file']['size']} bytes long.";

    $safe_filename = str_replace('/', '', $_FILES['my_file']['name']);
    $safe_filename = str_replace('..', '', $safe_filename);

    global $result;
    //$destination_file = '/usr/local/uploads/' . $safe_filename;
    $destination_file = "../history_csv/".$result['account_id']."_".$result['account_year']."_".$result['account_month'].".csv";
    if (move_uploaded_file($_FILES['my_file']['tmp_name'], $destination_file)) {
        print "Successfully saved file as $destination_file.";

        read_csv($result['id'], $result['account_id'], $destination_file);
        
    } else {
        print "Couldn't save file in /usr/local/uploads.";
    }

    echo "<br/>";

    echo "<a href=index.php?id=" . htmlspecialchars($result['account_id'], ENT_QUOTES, 'UTF-8') . ">トップページへ戻る</a>\n";

}

?>