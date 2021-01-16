var clock = document.getElementById('clock');

function time() {
  var d = new Date();
  var s = d.getSeconds();
  var m = d.getMinutes();
  var h = d.getHours();

  if (m < 10) m = "0" + m;
  if (s < 10) s = "0" + s;

  clock.textContent = "Time: " + h + ":" + m + ":" + s;
  
}

setInterval(time, 1000);