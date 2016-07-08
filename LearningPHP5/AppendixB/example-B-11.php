$text=<<<TEXT
"It's time to ring again," said Tom rebelliously.
"I agree! I'll help you," said Jerry resoundingly.
TEXT;

// Get each of the words in $text, but don't put the whitespace and
// punctuation into $words. The -1 for the limit argument means "no limit"
$words = preg_split('/[",.!\s]/', $text, -1, PREG_SPLIT_NO_EMPTY);

print 'There are ' . count($words) .' words in the text.';