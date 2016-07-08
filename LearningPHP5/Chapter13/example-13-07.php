require 'Mail.php';
require 'Mail/mime.php';

$headers = array('From' => 'orders@example.com',
                 'Subject' => 'Your Order');

$text_body = <<<_TXT_
Your order is:
* 2 Fried Bean Curd
* 1 Eggplant with Chili Sauce
* 3 Pineapple with Yu Fungus
_TXT_;

$html_body = <<<_HTML_
<p>Your order is:</p>
<ul>
<li><b>2</b> Fried Bean Curd</li>
<li><b>1</b> Eggplant with Chili Sauce</li>
<li><b>3</b> Pineapple with Yu Fungus</li>
</ul>
_HTML_;

$mime = new Mail_mime();
$mime->setTXTBody($text_body);
$mime->setHTMLBody($html_body);

$msg_body = $mime->get();
$msg_headers = $mime->headers($headers);

$mailer = Mail::factory('mail');

$mailer->send('hungry@example.com', $msg_headers, $msg_body);