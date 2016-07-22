<?php
$menu=<<<_XML_
<?xml version="1.0" encoding="utf-8" ?>
<rss version="0.91">
 <channel>
  <title>What's For Dinner</title>
  <link>http://menu.example.com/</link>
  <description>These are your choices of what to eat tonight.</description>
  <item-old>
   <title>Braised Sea Cucumber</title>
   <link>http://menu.example.com/dishes.php?dish=cuke</link>
   <description>Gentle flavors of the sea that nourish and refresh you.</description>
  </item-old>
  <item-old>
   <title>Baked Giblets with Salt</title>
   <link>http://menu.example.com/dishes.php?dish=giblets</link>
   <description>Rich giblet flavor infused with salt and spice.</description>
  </item-old>
  <item-old>
   <title>Abalone with Marrow and Duck Feet</title>
   <link>http://menu.example.com/dishes.php?dish=abalone</link>
   <description>There's no mistaking the special pleasure of abalone.</description>
  </item-old>
 </channel>
</rss>
_XML_;

// Create the SimpleXML object
$xml = simplexml_load_string($menu);

// Modify the SimpleXML object
$xml['version'] = '6.3';
$xml->channel->title = strtoupper($xml->channel->title);

for ($i = 0; $i < 3; $i++) {
    $xml->channel->item[$i]->link = str_replace('menu.example.com','dinner.example.org', $xml->channel->item[$i]->link);
}

// Send the XML document to the web client
header('Content-Type: text/xml');
print $xml->asXML();

?>