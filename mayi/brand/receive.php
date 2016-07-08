<?php
/**
 * Created by PhpStorm.
 * User: rosui
 * Date: 2016/05/08
 * Time: 18:10
 */
$_POST = file_get_contents('php://input');
print_r($_POST);
print_r($_POST['recipe_name']);