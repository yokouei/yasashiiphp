Here's a sample template file, article.html:

<html>
<head><title>{title}</title></head>
<body>
<h1>{headline}</h1>
<h2>By {byline}</h2>

{article}

<hr/>
<h4>Page generated: {date}</h4>
</body>
</html>

Here's the program that replaces the template fields with actual
values. It stores the field names and values in an array and then uses
foreach() to iterate through that array and do the
replacement:

<?php
$page = file_get_contents('article.html');
if ($page === false) {
    die("Can't read article.html: $php_errormsg");
}
$vars = array('{title}' => 'Man Bites Dog',
              '{headline}' => 'Man and Dog Trapped in Biting Fiasco',
              '{byline}' => 'Ireneo Funes',
              '{article}' => "<p>While walking in the park today,
Bioy Casares took a big juicy bite out of his dog, Santa's Little
Helper. When asked why he did it, he said, \"I was hungry.\"</p>",
              '{date}' => date('l, F j, Y'));

foreach ($vars as $field => $new_value) {
    $page = str_replace($field, $new_value, $page);
}

$result = file_put_contents('dog-article.html', $page);
if (($result === false) || ($result == -1)) {
    die("Couldn't write dog-article.html: $php_errormsg");
}
?>