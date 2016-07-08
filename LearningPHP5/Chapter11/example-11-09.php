foreach ($xml->channel->item[0] as $element_name => $content) {
    print "The $element_name is $content\n";
}