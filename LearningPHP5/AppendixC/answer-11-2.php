<?php
  // Load form helper functions
require 'formhelpers.php';

if ($_POST['_submit_check']) {
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
    if ($errors)) {
        print 'You need to correct the following errors: <ul><li>';
        print implode('</li><li>',$errors);
        print '</li></ul>';
    }

    // the beginning of the form
    print '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">';

    // title
    print 'Title: ';
    input_text('title', $_POST);
    print '<br/>';

    // link
    print 'Link: ';
    input_text('link', $_POST);
    print '<br/>';

    // description
    print 'Description: ';
    input_text('description', $_POST);
    print '<br/>';

    // the submit button
    input_submit('submit','Generate Feed');

    // the hidden _submit_check variable and the end of the form
    print '<input type="hidden" name="_submit_check" value="1"/>';
    print '</form>';
}

function validate_form() {
    $errors = array();

    // title is required
    if (! strlen(trim($_POST['title']))) {
        $errors[] = 'Enter an item title.';
    }

    // link is required
    if (! strlen(trim($_POST['link']))) {
        $errors[] = 'Enter an item link.';
    // It's tricky to perfectly validate a URL, but we can
    // at least check to make sure it begins with the right 
    // string
    } elseif (! (substr($_POST['link'], 0, 7) == 'http://') ||
              (substr($_POST['link'], 0, 8) == 'https://')) {
        $errors[] = 'Enter a valid http or https URL.';
    }
    
    // description is required
    if (! strlen(trim($_POST['description']))) {
        $errors[] = 'Enter an item description.';
    }

    return $errors;
}

function process_form() {
    // Send the Content-Type header
    header('Content-Type: text/xml');
    // print out the beginning of the XML, including the channel information
    print<<<_XML_
<rss version="0.91">
 <channel>
  <title>What's For Dinner</title>
  <link>http://menu.example.com/</link>
  <description>This is your choice of what to eat tonight.</description>
   <item>
_XML_;
  
    // print out the submitted form data
    print '  <title>' . htmlentities($_POST['title']) . "</title>\n";
    print '  <link>' . htmlentities($_POST['link']) . "</link>\n";
    print '  <description>' . htmlentities($_POST['description']) . "</description>\n";
   
    // print out the end of the XML
    print<<<_XML_
  </item>
 </channel>
</rss>
_XML_;
}
?>