$a = gmp_mul(35, gmp_pow(10,405));
$b = gmp_mul(28, gmp_pow(10,405));

$a_squared = gmp_pow($a, 2);
$b_squared = gmp_pow($b, 2);

$hypotenuse = gmp_sqrt(gmp_add($a_squared, $b_squared));

print gmp_strval($hypotenuse);