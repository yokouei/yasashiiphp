An associative array whose keys are students' names and whose
values are associative arrays of grade and ID number.
$students = array('James D. McCawley' => array('grade' => 'A+','id' => 271231),
                  'Buwei Yang Chao' => array('grade' => 'A', 'id' => 818211));

An associative array whose key is the item name and whose value is the number in stock.
$stock = array('Woks' => 5, 'Steamers' => 3, 'Heavy Cleavers' => 2, 'Light Cleavers' => 6);

An associative array whose key is the day and whose
value is an associative array describing the meal. This associative
array has a key/value pair for cost and a key/value pair for each part
of the meal (entree, side dish, drink).

$lunches = array('Monday' => array('cost' => 1.50,
                                   'entree' => 'Beef Shiu-Mai',
                                   'side' => 'Salty Fried Cake',
                                   'drink' => 'Black Tea'),
                 'Tuesday' => array('cost' => 1.50,
                                    'entree' => 'Clear-steamed Fish',
                                    'side' => 'Turnip Cake',
                                    'drink' => 'Black Tea'),
                 'Wednesday' => array('cost' => 2.00,
                                      'entree' => 'Braised Sea Cucumber',
                                      'side' => 'Turnip Cake',
                                      'drink' => 'Green Tea'),
                 'Thursday' => array('cost' => 1.35,
                                     'entree' => 'Stir-fried Two Winters',
                                     'side' => 'Egg Puff',
                                     'drink' => 'Black Tea'),
                 'Friday' => array('cost' => 2.15,
                                   'entree' => 'Stewed Pork with Taro',
                                   'side' => 'Duck Feet',
                                   'drink' => 'Jasmine Tea'));

A numeric array whose values are the names of family members.

$family = array('Bart','Lisa','Homer','Marge','Maggie');

An associative array whose keys are the names of
family members and whose values are associative arrays of age and
relationship.

$family = array('Bart' => array('relation' => 'brother',
                                'age' => 10),
                'Lisa' => array('relation' => 'sister',
                                'age' => 7),
                'Homer' => array('relation' => 'father',
                                 'age' => 36),
                'Marge' => array('relation' => 'mother',
                                 'age' => 34),
                'Maggie' => array('relation' => 'self',
                                  'age' => 1));