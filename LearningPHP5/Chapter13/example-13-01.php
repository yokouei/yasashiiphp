<?php

// GD's built-in fonts are numbered from 1 - 5
$font = 3;

// Calculate the appropriate image size
$image_height = intval(imageFontHeight($font) * 2);
$image_width = intval(strlen($_GET['button']) * imageFontWidth($font) * 1.3);

// Create the image
$image = imageCreate($image_width, $image_height);

// Create the colors to use in the image
// gray background
$back_color = imageColorAllocate($image, 216, 216, 216);
// blue text
$text_color = imageColorAllocate($image, 0,   0,   255);
// black border
$rect_color = imageColorAllocate($image, 0,   0,   0);

// Figure out where to draw the text
// (Centered horizontally and vertically 
$x = ($image_width - (imageFontWidth($font) * strlen($_GET['button']))) / 2;
$y = ($image_height - imageFontHeight($font)) / 2;

// Draw the text
imageString($image, $font, $x, $y, $_GET['button'], $text_color);
// Draw a black border
imageRectangle($image, 0, 0, imageSX($image) - 1, imageSY($image) - 1, $rect_color);

// Send the image to the browser
header('Content-Type: image/png');
imagePNG($image);
imageDestroy($image);
?>