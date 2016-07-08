<?php
$page_count = $_COOKIE['page_count'] + 1;
if ($page_count == 20) {
    // an empty value deletes the cookie
    setcookie('page_count','');
    print "Time to start over.";
} else {
    setcookie('page_count', $page_count);
    print "Number of views: $page_count";
    if ($page_count == 5) {
        print "<br/> This is your fifth visit.";
    } elseif ($page_count == 10) {
        print "<br/> This is your tenth visit. Aren't you sick of this page yet?";
    } elseif ($page_count == 15) {
        print "<br/> This is your fifteenth visit. Don't you have anything better to do?";
    }
}?>