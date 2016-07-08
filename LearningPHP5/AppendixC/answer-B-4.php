$url = 'http://www.sklar.com/';
$page = file_get_contents($url);
if (preg_match_all('@<a href="[^"]+">.+?</a>@', $page, $matches)) {
    foreach ($matches[0] as $link) {
        print "$link <br/>\n";
    }
}