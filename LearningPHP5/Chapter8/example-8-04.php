// The cookie expires one hour from now
setcookie('short-userid','ralph',time() + 60*60);

// The cookie expires one day from now
setcookie('longer-userid','ralph',time() + 60*60*24);

// The cookie expires at noon on October 1, 2006
setcookie('much-longer-userid','ralph',mktime(12,0,0,10,1,2006));