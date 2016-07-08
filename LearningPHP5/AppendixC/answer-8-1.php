<?php
$page_count = $_COOKIE['page_count'] + 1;
setcookie('page_count',$page_count);
print "Number of views: $page_count";

?>