foreach ($xml->channel->item as $item) {
    print "Title: " . $item->title . "\n";
}