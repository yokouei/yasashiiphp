// First, do normal quoting of the value
$dish = $db->quoteSmart($_POST['dish_search']);
// Then, put backslashes before underscores and percent signs
$dish = strtr($dish, array('_' => '\_', '%' => '\%'));
// Now, $dish is sanitized and can be interpolated right into the query
$matches = $db->getAll("SELECT dish_name, price FROM dishes
                        WHERE dish_name LIKE $dish");