$hamburger = 4.95;
$milkshake = 1.95;
$cola = .85;
$food = 2 * $hamburger + $milkshake + $cola;
$tax = $food * .075;
$tip = $food * .16;

printf("%1d %9s at \$%.2f each: \$%.2f\n", 2, 'Hamburger', $hamburger, 2 * $hamburger);
printf("%1d %9s at \$%.2f each: \$%.2f\n", 1, 'Milkshake', $milkshake, $milkshake);
printf("%1d %9s at \$%.2f each: \$%.2f\n", 1, 'Cola', $cola, $cola);
printf("%25s: \$%.2f\n", 'Food and Drink Total', $food);
printf("%25s: \$%.2f\n", 'Total with Tax', $food + $tax);
printf("%25s: \$%.2f\n", 'Total with Tax and Tip', $food + $tax + $tip);