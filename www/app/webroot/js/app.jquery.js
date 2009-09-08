$(window).load(function(){
	// Remove messageBody
	$(".messageSubject").addClass('messageSubjectClickable');
	$(".messageBody").addClass('messageBodyHidden');
	// TheFlash
	$("#flashMessage").oneTime(2500, function() {
		$(this).fadeTo(750, .01);
	});
	$("#authMessage").oneTime(2500, function() {
		$(this).fadeTo(750, .01);
	});
	$("#flashMessage").oneTime(2501, function() {
		$(this).slideUp(200);
	});
	$("#authMessage").oneTime(2501, function() {
		$(this).slideUp(200);
	});
	// FormSubmitAnimation
	$("form").submit(function () { 
		$("input[type=submit]").removeClass("userHasNotSubmitted");
		$("input[type=submit]").addClass("userHasSubmitted");
		// $("input[type=submit]").attr("disabled", "disabled");
		$("input[type=submit]").blur();
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