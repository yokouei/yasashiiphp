$xml['version'] = '6.3';
$xml->channel->title = strtoupper($xml->channel->title);

for ($i = 0; $i < 3; $i++) {
    $xml->channel->item[$i]->link = str_replace('menu.example.com',
        'dinner.example.org', $xml->channel->item[$i]->link);
}