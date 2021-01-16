// Date declaration
var date = new Date();
// Date variables
var day = date.getDate();
var dayNr = date.getDay();
var month = date.getMonth();
var year = date.getFullYear();
// Months array
var months = new Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
// Showing the date variable 
var showDate = day + ' ' + months[month] + ' ' + year;
// Showing the date 
document.write(showDate);
