// Get the epoch timestamp for 6 months ago
$range_start = strtotime('6 months ago');
// Get the epoch timestamp for right now
$range_end   = time();

// 4-digit year is in $_POST['yr']
// 2-digit month is in $_POST['mo']
// 2-digit day is is $_POST['dy']
$submitted_date = strtotime($_POST['yr'] . '-' . 
                            $_POST['mo'] . '-' . 
                            $_POST['dy']);

if (($range_start > $submitted_date) || ($range_end < $submitted_date)) {
    $errors[] = 'Please choose a date less than six months old.';
}