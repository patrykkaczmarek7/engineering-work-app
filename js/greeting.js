
// downloading date and then hour
var hourNow = new Date().getHours();
// keepig greeting variable
var greeting;

// od 18:00
if (hourNow > 18) {
    greeting = 'Good evening!';
// od 12:00  
} else if (hourNow > 12) {
    greeting = 'Hi!';
// od 06:00    
} else if (hourNow > 6) {
    greeting = 'Good afternoon!';
// od 00:00  
} else if (hourNow > 1) {
    greeting = 'Not tired?';
} else {
    greeting = 'Hello';
}

document.write(greeting);
