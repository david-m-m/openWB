var doval;

function getgraph() {
	var source = "display/graph-live.php",
	timestamp = (new Date()).getTime(),
	newUrl = source + '?_=' + timestamp;
	if (document.getElementById("livegraph")) {
		document.getElementById("livegraph").src = newUrl;
	}
}

doval = setInterval(getgraph, 5000);

getgraph();
