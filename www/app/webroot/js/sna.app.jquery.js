$(window).load(function(){
	// Remove messageBody
	$(".messageSubject").addClass('messageSubjectClickable');
	$(".messageBody").addClass('messageBodyHidden');
	// TheFlash
	$("#flashMessage").oneTime(2500, function() {
		$(this).fadeTo(750, .01);
	});
	$("#flashMessage").oneTime(2501, function() {
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
		$(this).parent().parent().find(".messageSubject").addClass('messageSubjectClickable');
		$(this).parent().find(".messageSubject").removeClass('messageSubjectClickable');
		$(this).parent().parent().find(".messageBody").addClass('messageBodyHidden');
		$(this).parent().next().find(".messageBody").removeClass('messageBodyHidden');
	});
	// SmoothScroll
	enable_smooth_scroll();
	
});