$members=<<<TEXT

Name               E-Mail Address
------------------------------------------------
Inky T. Ghost      inky@pacman.example.com
Donkey K. Gorilla  kong@banana.example.com
Mario A. Plumber   mario@franchise.example.org
Bentley T. Bear    bb@xtal-castles.example.net
TEXT;

print preg_replace('/[^@\s]+@([-a-z0-9]+\.)+[a-z]{2,}/',
                   '[ address removed ]', $members);