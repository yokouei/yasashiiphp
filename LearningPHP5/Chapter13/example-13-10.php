class RSS extends DomDocument {
    function __construct($title, $link, $description) {
        // Set this document up as XML 1.0 with a root
        // <rss> element that has a version="0.91" attribute
        parent::__construct('1.0');
        $rss = $this->createElement('rss');
        $rss->setAttribute('version', '0.91');
        $this->appendChild($rss);
        
        // Create a <channel> element with <title>, <link>,
        // and <description> sub-elements
        $channel = $this->createElement('channel');
        $channel->appendChild($this->makeTextNode('title', $title));
        $channel->appendChild($this->makeTextNode('link', $link));
        $channel->appendChild($this->makeTextNode('description',
                                                  $description));
        
        // Add <channel> underneath <rss>
        $rss->appendChild($channel);
        
        // Set up output to print with linebreaks and spacing
        $this->formatOutput = true;
    }
    
    // This function adds an <item> to the <channel>
    function addItem($title, $link, $description) {
        // Create an <item> element with <title>, <link>
        // and <description> sub-elements
        $item = $this->createElement('item');
        $item->appendChild($this->makeTextNode('title', $title));
        $item->appendChild($this->makeTextNode('link', $link));
        $item->appendChild($this->makeTextNode('description',
                                               $description));
        
        // Add the <item> to the <channel>
        $channel = $this->getElementsByTagName('channel')->item(0);
        $channel->appendChild($item);
    }
    
    // A helper function to make elements that consist entirely
    // of text (no sub-elements)
    private function makeTextNode($name, $text) {
        $element = $this->createElement($name);
        $element->appendChild($this->createTextNode($text));
        return $element;
    }
}

// Create a new RSS feed with the specified title, link and description
// for the channel.
$rss = new RSS("What's For Dinner", 'http://menu.example.com/', 
               'These are your choices of what to eat tonight.');
// Add three items
$rss->addItem('Braised Sea Cucumber',
              'http://menu.example.com/dishes.php?dish=cuke',
              'Gentle flavors of the sea that nourish and refresh you.');
$rss->addItem('Baked Giblets with Salt',
              'http://menu.example.com/dishes.php?dish=giblets',
              'Rich giblet flavor infused with salt and spice.');
$rss->addItem('Abalone with Marrow and Duck Feet',
              'http://menu.example.com/dishes.php?dish=abalone',
              "There's no mistaking the special pleasure of abalone.");
// Print the XML
print $rss->saveXML();