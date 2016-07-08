$server = '{news.php.net/nntp:119}';
$group = 'php.announce';
$nntp = imap_open("$server$group", '', '', OP_ANONYMOUS);

$last_msg_id = imap_num_msg($nntp);

$msg_id = $last_msg_id - 9;

print '<table>';
print "<tr><td>Subject</td><td>From</td><td>Date</td></tr>\n";

while ($msg_id <= $last_msg_id) {
    $header = imap_header($nntp, $msg_id);

    if (! $header->Size) { print "no size!"; }

    $email = $header->from[0]->mailbox . '@' .
        $header->from[0]->host;
    if ($header->from[0]->personal) {
        $email .= ' ('.$header->from[0]->personal.')';
    }

    $date = date('m/d/Y h:i A', $header->udate);

    print "<tr><td>$header->subject</td><td>$email</td>" .
        "<td>$date</td></tr>\n";
$msg_id++;
}
print '</table>';