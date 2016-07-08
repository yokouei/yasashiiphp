$hamburger = 4.95;
$milkshake = 1.95;
$cola = .85;
$food = 2 * $hamburger + $milkshake + $cola;
$tax = $food * .075;
$tip = $food * .16;
$total = $food + $tax + $tip;
print "Total cost of the meal is \$$total";