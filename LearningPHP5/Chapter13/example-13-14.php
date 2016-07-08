// Run "df" and divide up its output into individual lines
$df_output = shell_exec('/bin/df -h');
$df_lines = explode("\n", $df_output);

// Loop through each line. Skip the first line, which
// is just a header
for ($i = 1, $lines = count($df_lines); $i < $lines; $i++) {
    if (trim($df_lines[$i])) {
        // Divide up the line into fields
        $fields = preg_split('/\s+/', $df_lines[$i]);
        // Print info about each filesystem
        print "Filesystem $fields[5] is $fields[4] full.\n";
    }
}