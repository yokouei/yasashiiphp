<?php
// Create a new XSL Transformer
$xslt = new XSLTProcessor();
// Load the stylesheet from the file rss.xsl
$xslt->importStyleSheet(DomDocument::load('example-13-12.php'));

// Apply the stylesheet to the XML 
$html = $xslt->transformToDoc($rss);
// Print out the content of the new document
$html->formatOutput = true;
print $html->saveXML();

?>