<?php
require 'formhelpers.php';

if ($_POST['_submit_check']) {
    if ($form_errors = validate_form()) {
        show_form($form_errors);
    } else {
        process_form();
    }
} else {
    show_form();
}

function show_form($errors = '') {
    if ($errors) {
        print 'You need to correct the following errors: <ul><li>';
        print implode('</li><li>',$errors);
        print '</li></ul>';
    }

    // the beginning of the form
    print '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">';
    print '<table>';

    // the search term
    print '<tr><td>Search Term:</td><td>';
    input_text('term', $_POST);
    print '</td></tr>';
    
    // form end
    print '<tr><td colspan="2"><input type="submit" value="Search News Feed"></td></tr>';
    print '</table>';
    print '<input type="hidden" name="_submit_check" value="1"/>';
    print '</form>';
}      

function validate_form() {
    $errors = array();

    if (! strlen(trim($_POST['term']))) {
        $errors[] = 'Please enter a search term.';
    }
    return $errors;
}

function process_form() {
    
    // Retrieve the news feed
    $feed = simplexml_load_file('http://rss.news.yahoo.com/rss/topstories');

    if ($feed) {
        print "<ul>\n";
        foreach ($feed->channel->item as $item) {
            if (stristr($item->title, $_POST['term'])) {
                print '<li><a href="' . $item->link .'">' ;
                print htmlentities($item->title);
                print "</a></li>\n";
            }
        }
        print '</ul>';
    } else {
        print "Couldn't retrieve feed.";
    }
}
?>