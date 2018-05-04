/**
 * Created by Alex Xia on 2018-04-29.
 * This file should only be included in welcome.php.
 * Sets a timeout to login newly-created user after 5 seconds.
 */
$(document).ready(function(){

    setTimeout(function(){
    	// document.location.href = 'index.php?userid=' + $("#Userid").text();	
    	document.location.href = 'index.php';	
	},5000);


});
