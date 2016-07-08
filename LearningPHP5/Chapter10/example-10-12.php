function make_csv_line($values) {
    // If a value contains a comma, a quote, a space, a 
    // tab (\t), a newline (\n), or a linefeed (\r),
    // then surround it with quotes and replace any quotes inside
    // it with two quotes
    foreach($values as $i => $value) {
        if ((strpos($value, ',')  !== false) ||
            (strpos($value, '"')  !== false) ||
            (strpos($value, ' ')  !== false) ||
            (strpos($value, "\t") !== false) ||
            (strpos($value, "\n") !== false) ||
            (strpos($value, "\r") !== false)) {
            $values[$i] = '"' . str_replace('"', '""', $value) . '"';
        }
    }
    // Join together each value with a comma and tack on a newline
    return implode(',', $values) . "\n";
}