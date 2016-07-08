$matches = $db->getAll('SELECT dish_name, price FROM dishes
                        WHERE dish_name LIKE ?',
                       array($_POST['dish_search']));