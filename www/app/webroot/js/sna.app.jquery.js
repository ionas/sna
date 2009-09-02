$(window).load(function(){
	$("div.message").oneTime(2000, function() {
		$(this).fadeTo(1000, .01);
	});
	$("div.message").oneTime(2001, function() {
		$(this).slideUp(500);
	});
	$("form").submit(function () { 
		$("input[type=submit]").removeClass("userHasNotSubmitted");
		$("input[type=submit]").addClass("userHasSubmitted");
		$("input[type=submit]").attr("disabled", "disabled");
		$("input[type=submit]").blur();
		return true;
	});
	enable_smooth_scroll();
});