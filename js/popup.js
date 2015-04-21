/***************************/
//@Author: Adrian "yEnS" Mato Gondelle
//@website: www.yensdesign.com
//@email: yensamg@gmail.com
//@license: Feel free to use it, but keep this credits please!					
/***************************/

//SETTING UP OUR POPUP
//0 means disabled; 1 means enabled;
var popupStatus = 0;

//loading popup with jQuery magic!
function loadPopup(){
	//loads popup only if it is disabled
	if(popupStatus==0){
		$j("#background-popup").css({
			"opacity": "0.7"
		});
		$j("#background-popup").fadeIn("fast");
		$j("#popup-box").fadeIn("fast");
		popupStatus = 1;
	}
}

//disabling popup with jQuery magic!
function disablePopup(){
	//disables popup only if it is enabled
	if(popupStatus==1){
		$j("#background-popup").fadeOut("fast");
		$j("#popup-box").fadeOut("fast");
		popupStatus = 0;
	}
}

//centering popup
function centerPopup(){
	//request data for centering
	var windowWidth = document.documentElement.clientWidth;
	var windowHeight = document.documentElement.clientHeight;
	var popupHeight = $j("#popup-box").height();
	var popupWidth = $j("#popup-box").width();
	//centering
	$j("#popup-box").css({
		"position": "absolute",
		"top": windowHeight/2-popupHeight/2,
		"left": windowWidth/2-popupWidth/2
	});
	//only need force for IE6
	
	$j("#background-popup").css({
		"height": windowHeight
	});
	
}


//CONTROLLING EVENTS IN jQuery

$j(document).ready(function(){
				
	//CLOSING POPUP	
	//Click out event!
	$j("#background-popup").click(function(){
		disablePopup();
	});
	//Press Escape event!
	$j(document).keypress(function(e){
		if(e.keyCode==27 && popupStatus==1){
			disablePopup();
		}
	});

});