// for tinyMCE editor
tinymce.init({selector:'textarea'});

$(document).ready(function(){

	// selectAllBoxes function in view_all_post.php
	$('#selectAllBoxes').click(function(event){

		if(this.checked) {// this refers to #selectAllBoxes
			$('.checkBoxes').each(function(){

			    this.checked = true; // this refers to .classBoxes

			});

		} else {

			$('.checkBoxes').each(function(){

			    this.checked = false;

			});

		}

	});

	// Adding a LOADER to the CMS Admin 
	var div_box = "<div id='load-screen'><div id='loading'></div></div>";
	$("body").prepend(div_box);
	$('#load-screen').delay(700).fadeOut(600, function(){
	   $(this).remove();
	});


});


function loadUsersOnline() {

	// to use users_online() in functions.php
	// put result in class="usersonline" in admin_navigation.php
	$.get("functions.php?onlineusers=result", function(data){

		$(".usersonline").text(data);

	});

}

// Instant Users Online count without refreshing
// call this function in every 0.5 sec
setInterval(function(){

	loadUsersOnline();

},500);













