// These values are in points (1/72nd of an inch)
$fontsize = 72;     // 1 inch high letters
$page_height = 612; // 8.5 inch high page
$page_width = 792;  // 11 inch wide page

// Use a default message if none is supplied
if (strlen(trim($_GET['message']))) {
    $message = trim($_GET['message']);
} else {
    $message = 'Generate a PDF!';
}

// Create a new PDF document in memory
$pdf = pdf_new();
pdf_open_file($pdf, '');

// Add a 11"x8.5" page to the document
pdf_begin_page($pdf, $page_width, $page_height);

// Select the Helvetica font at 72 points
$font = pdf_findfont($pdf, "Helvetica", "winansi", 0);
pdf_setfont($pdf, $font, $fontsize);

// Display the message centered on the page
pdf_show_boxed($pdf, $message, 0, ($page_height-$fontsize)/2,
               $page_width, $fontsize, 'center');

// End the page and the document
pdf_end_page($pdf);
pdf_close($pdf);

// Get the contents of the document and delete it from memory
$pdf_doc = pdf_get_buffer($pdf);
pdf_delete($pdf);

// Send appropriate headers and the document contents
header('Content-Type: application/pdf');
header('Content-Length: ' . strlen($pdf_doc));
print $pdf_doc;