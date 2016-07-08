$dish_id = $db->nextID('dishes');
$db->query("INSERT INTO orders (dish_id, dish_name, price, is_spicy)
    VALUES ($dish_id, 'Fried Bean Curd', 1.50, 0)");