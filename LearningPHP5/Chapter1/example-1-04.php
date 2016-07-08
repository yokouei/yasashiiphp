<?php
print <<<_HTML_
<form method="post" action="$_SERVER[PHP_SELF]">
Your Name: <input type="text" name="user">
<br/>
<input type="submit" value="Say Hello">
</form>
_HTML_;
?>