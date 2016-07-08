// Use SWF Version 6 to enable Actionscript
ming_UseSwfVersion(6);

// Create a new movie and set some parameters
$movie = new SWFMovie();
$movie->setRate(20.000000);
$movie->setDimension(550, 400);
$movie->setBackground(0xcc,0xcc,0xcc);

// Create the circle
$circle = new SWFShape();
$circle->setRightFill(33,66,99);
$circle->drawCircle(40);
$sprite= new SWFSprite();
$sprite->add($circle);
$sprite->nextFrame();

// Add the circle to the movie
$displayitem = $movie->add($sprite);
$displayitem->setName('circle');
$displayitem->moveTo(100,100);

// Add the Actionscript that implements the dragging
$movie->add(new SWFAction("
 circle.onPress=function(){ this.startDrag('');};
 circle.onRelease= circle.onReleaseOutside=function(){ stopDrag();};
"));

// Display the movie
header("Content-type: application/x-shockwave-flash");
$movie->output(1);