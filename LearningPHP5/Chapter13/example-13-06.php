<?php

$mail_body=<<<_TXT_
Your order is:
* 2 Fried Bean Curd
* 1 Eggplant with Chili Sauce
* 3 Pineapple with Yu Fungus
_TXT_;
mail('hungry@example.com','Your Order',$mail_body);

?>