$text=<<<TEXT
"It's time to ring again," said Tom rebelliously.
"I agree! I'll help you," said Jerry resoundingly.
TEXT;

$words = preg_split('/[",.!\s]/', $text, -1, PREG_SPLIT_NO_EMPTY);

// Find words that contain double letters
$double_letter_words = preg_grep('/([a-z])\\1/i',$words);

foreach ($double_letter_words as $word) {
    print "$word\n";
}