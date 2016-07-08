$db->query('UPDATE dishes SET price = 1 WHERE dish_name LIKE ?',
           array($_POST['dish_name']));