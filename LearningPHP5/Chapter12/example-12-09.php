function database_error($error_object) {
    print "We're sorry, but there is a temporary problem with the database.";
    $detailed_error = $error_object->getDebugInfo();
    error_log($detailed_error);
}