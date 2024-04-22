function laravel_visitors(url) {
	var xhr = new XMLHttpRequest();
	xhr.open("GET", url + "?w=" + screen.width + "&h=" + screen.height + "&p=" + window.devicePixelRatio + "&c=" + screen.colorDepth + "&vw=" + window.innerWidth + "&vh=" + window.innerHeight, true);
	xhr.send();
}
