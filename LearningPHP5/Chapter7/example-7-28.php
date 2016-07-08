$db->query('INSERT INTO dishes (dish_name,price,is_spicy) VALUES (?,?,?)',
           array($_POST['new_dish_name'], $_POST['new_price'],
                 $_POST['is_spicy']));