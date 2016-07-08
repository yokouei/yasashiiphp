Using sprintf() is necessary to ensure that one digit hex numbers (like 0) get padded with a leading 0.
function build_color($red, $green, $blue) {
    $redhex   = dechex($red);
    $greenhex = dechex($green);
    $bluehex  = dechex($blue);
    return sprintf('#%02s%02s%02s', $redhex, $greenhex, $bluehex);
}

You can also rely on sprintf()'s built-in hex-to-decimal conversion with the %x format character:

function build_color($red, $green, $blue) {
    return sprintf('#%02x%02x%02x', $red, $green, $blue);
}