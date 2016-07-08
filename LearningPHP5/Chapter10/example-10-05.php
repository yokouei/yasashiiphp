// Load the file from Example 10.2
$page = file_get_contents('page-template.html');

// Insert the title of the page
$page = str_replace('{page_title}', 'Welcome', $page);

// Make the page blue in the afternoon and
// green in the morning
if (date('H' >= 12)) {
    $page = str_replace('{color}', 'blue', $page);
} else {
    $page = str_replace('{color}', 'green', $page);
}

// Take the username from a previously saved session
// variable
$page = str_replace('{name}', $_SESSION['username'], $page);

// Instead of printing the results, save the page on a 
// remote FTP server
file_put_contents('ftp://bruce:hax0r@ftp.example.com/usr/local/htdocs/welcome.html', $page);