document.write('<div class="event_space"><button id="event_button">CLICK ME</button></div>');
var clicks_count = 0;
document.getElementById('event_button').onclick = function() {
	clicks_count++;
	var body = document.querySelector("body")
	if(clicks_count % 2 == 0) {
		body.style.backgroundColor = "black";
	}
	else
	{
		body.style.backgroundColor = "white";
	}
}