
//Global variables

//PAGE[0] initial, PAGE[1] cloud, PAGE[2] songs, PAGE[3] lyrics
var PAGE = [true, false, false, false];



//Method called when user searchs for artist
function search(){
    shiftDown();
	setVisible("back");
	setVisible("vis");
	document.getElementById("svgID").style.height = "75vh";
	setPage(1);

}

function home(){
	if(PAGE[1]){ //If the user is on the cloud page
		shiftCenter();
		setInvisible("back");
		setPage(0);
	}else if(!PAGE[0]){ //If the user is not on the initial page
		setPage(1);
		shiftDown();
		setVisible("back");
	}

}

function back(){
	if(PAGE[1]){
		shiftCenter();
		setInvisible("back");
		setPage(0);
	}else if(PAGE[2]){
		shiftDown();
		setPage(1);
	}else if(PAGE[3]){

	}
}

//Helper functions

//Animation Functions

function setPage(page){
	var length = PAGE.length;
	var i;
	for(i = 0; i < length; i++){
		PAGE[i] = false;
	}
	PAGE[page] = true;
}

function shiftDown(){
	document.getElementById("userInputs").style.paddingTop = "0%";
}

function shiftCenter(){
	document.getElementById("svgID").style.height = 1;
	setInvisible("vis");
	document.getElementById("userInputs").style.paddingTop = "20%";
}

function setInvisible(id){
	document.getElementById(id).style.visibility = "hidden";
}

function setVisible (id) {
	document.getElementById(id).style.visibility = "visible";
}