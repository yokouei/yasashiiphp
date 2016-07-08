$sea_creatures = "cucumber;jellyfish, conger eel,shrimp, crab roe; bluefish";
// Break apart the string into at most three elements
$creature_list = preg_split('/, ?/',$sea_creatures, 3);
print "The last element is $creature_list[2]";