// These lines add /home/ireneo/php to the end of the include_path
$include_path = ini_get('include_path');
ini_set('include_path',$include_path . ':/home/ireneo/php');