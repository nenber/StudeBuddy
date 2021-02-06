AOS.init();

function refreshPage() {
    window.location.reload();
}
function charcountupdate(str) {
    var lng=document.getElementById("custom_user_account_description").value.lenght;
	var lng = str.length;
	document.getElementById("charcount").innerHTML = lng + ' ';
}
