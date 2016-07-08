$db->query('INSERT INTO dishes (dish_name) VALUES (?)',
    array($_POST['new_dish_name']));