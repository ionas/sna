$(window).load(function(){
	$("div.message").oneTime(2000, function() {
		$(this).fadeTo(2000, .01);
	});
	$("form").submit(function () { 
		$("input[type=submit]").removeClass("userHasNotSubmitted");
		$("input[type=submit]").addClass("userHasSubmitted");
		$("input[type=submit]").attr("disabled", "disabled");
		$("input[type=submit]").blur();
		return true;
	});
});