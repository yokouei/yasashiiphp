function process_form() {
    // Access the global variable $db inside this function
    global $db;
    
    // build up the query 
    $sql = 'SELECT dish_name, price, is_spicy FROM dishes WHERE ';
    
    // add the minimum price to the query
    $sql .= "price >= '" .
            mysqli_real_escape_string($db, $_POST['min_price']) . "' ";

    // add the maximum price to the query
    $sql .= " AND price <= '" .
            mysqli_real_escape_string($db, $_POST['max_price']) . "' ";

    // if a dish name was submitted, add to the WHERE clause
    // we use mysqli_real_escape_string() and strtr() to prevent
    // user-entered wildcards from working
    if (strlen(trim($_POST['dish_name']))) {
        $dish = mysqli_real_escape_string($db, $_POST['dish_name']);
        $dish = strtr($dish, array('_' => '\_', '%' => '\%'));
        // mysqli_real_escape_string() doesn't add the single quotes
        // around the value so you have to put those around $dish in
        // the query:
        $sql .= " AND dish_name LIKE '$dish'";
    }

    // if is_spicy is "yes" or "no", add appropriate SQL
    // (if it's either, we don't need to add is_spicy to the WHERE clause)
    $spicy_choice = $GLOBALS['spicy_choices'][ $_POST['is_spicy'] ];
    if ($spicy_choice == 'yes') {
        $sql .= ' AND is_spicy = 1';
    } elseif ($spicy_choice == 'no') {
        $sql .= ' AND is_spicy = 0';
    }

    // Send the query to the database program and get all the rows back
    $q = mysqli_query($db, $sql);

    if (mysqli_num_rows($q) == 0) {
        print 'No dishes matched.';
    } else {
        print '<table>';
        print '<tr><th>Dish Name</th><th>Price</th><th>Spicy?</th></tr>';
        while ($dish = mysqli_fetch_object($q)) {
            if ($dish->is_spicy == 1) {
                $spicy = 'Yes';
            } else {
                $spicy = 'No';
            }
            printf('<tr><td>%s</td><td>$%.02f</td><td>%s</td></tr>',
                   htmlentities($dish->dish_name), $dish->price, $spicy);
        }
    }
}