<form method="post" action="htmlsp.php">
    <input type="text" name="test">
    <input type="submit">
</form>
<?php
echo $_POST["test"];
echo htmlspecialchars($_POST['test'], ENT_QUOTES, 'UTF-8');

print_r($_POST);
//print($_POST);
var_dump($_POST);
?>