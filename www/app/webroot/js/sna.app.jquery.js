$(window).load(function(){
	$("div.message").oneTime(2500, function() {
		$(this).fadeTo(750, .01);
	});
	$("div.message").oneTime(2501, function() {
		$(this).slideUp(200);
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