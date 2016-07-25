<?php
// Figure out hypotenuse of a giant right triangle
// The sides are 3.5e406 and 2.8e406

$a = bcmul(3.5, bcpow(10, 406));
$b = bcmul(2.8, bcpow(10, 406));

$a_squared = bcpow($a, 2);
$b_squared = bcpow($b, 2);

$hypotenuse = bcsqrt(bcadd($a_squared, $b_squared));

print $hypotenuse;

?>