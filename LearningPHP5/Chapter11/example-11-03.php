$channel =<<<_XML_
<channel>
 <title>What's For Dinner</title>
 <link>http://menu.example.com/</link>
 <description>These are your choices of what to eat tonight.</description>
</channel>
_XML_;

$xml = simplexml_load_string($channel);