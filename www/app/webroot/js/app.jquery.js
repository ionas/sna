$(window).load(function(){
	// Remove messageBody
	$(".messageSubject").addClass('messageSubjectClickable');
	$(".messageBody").addClass('messageBodyHidden');
	// TheFlash
	// hidden
	$("#authMessage").fadeTo(0, 0);
	$("#flashMessage").fadeTo(0, 0);
	// show rapidly first
	$("#authMessage").oneTime(400, function() {
		$(this).fadeTo(250, 1);
	});
	$("#flashMessage").oneTime(400, function() {
		$(this).fadeTo(250, 1);
	});
	// hide shortly after, slowy
	$("#authMessage").oneTime(2500, function() {
		$(this).fadeTo(750, .01);
	});
	$("#flashMessage").oneTime(2500, function() {
		$(this).fadeTo(750, .01);
	});
	// FormSubmitAnimation
	$("form").submit(function () { 
		$("input[type=submit]").addClass("userHasSubmitted");
		$("input[type=submit]", this).addClass("userHasSubmittedWheel");
		$("input[type=submit]", this).attr("disabled", "disabled");
		$("input[type=submit]", this).oneTime(3000, function() {
			$(this).removeAttr("disabled");
		});
		$("input[type=submit]", this).blur();
		return true;
	});
	// Messages clickToRead
	$(".messageSubject").click(function(){
		// Making subjects clickable
		$(this).parent().parent().find(".messageSubject").addClass('messageSubjectClickable');
		$(this).parent().find(".messageSubject").removeClass('messageSubjectClickable');
		$(this).parent().find(".messageSubject").addClass('messageSubjectClicked');
		// Toggling the messageBody
		$(this).parent().parent().find(".messageBody").addClass('messageBodyHidden');
		$(this).parent().next().find(".messageBody").removeClass('messageBodyHidden');
		// Moving around the subject
		$(this).parent().parent().find(".messageBodySubject").remove();
		currentSubject = '<h3 class="messageBodySubject">' + $(this).html() + '</h3>';
		$(this).parent().next().find(".messageBody").prepend(currentSubject);
	});
	// SmoothScroll
	enable_smooth_scroll();
	
});