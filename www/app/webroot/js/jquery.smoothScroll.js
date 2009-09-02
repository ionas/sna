/* source: http://www.learningjquery.com/2007/09/animated-scrolling-with-jquery-12 */
/* source: http://www.zachstronaut.com/posts/2009/01/18/jquery-smooth-scroll-bugs.html */
function enable_smooth_scroll() {
	function filterPath(string) {
		return string
				.replace(/^\//,'')
				.replace(/(index|default).[a-zA-Z]{3,4}$/,'')
				.replace(/\/$/,'');
	}
	var locationPath = filterPath(location.pathname);
	var scrollElement = 'html, body';
	$('html, body').each(function () {
		var initScrollTop = $(this).attr('scrollTop');
		$(this).attr('scrollTop', initScrollTop + 1);
		if ($(this).attr('scrollTop') == initScrollTop + 1) {
			scrollElement = this.nodeName.toLowerCase();
			$(this).attr('scrollTop', initScrollTop);
			return false;
		}
	});
	$('a[href*=#]').each(function() {
		var thisPath = filterPath(this.pathname) || locationPath;
		if (locationPath == thisPath
			&& (location.hostname == this.hostname || !this.hostname)
			&& this.hash.replace(/#/, '')
		) {
			if ($(this.hash).length) {
				$(this).click(function(event) {
					var targetOffset = $(this.hash).offset().top;
					var target = this.hash;
					event.preventDefault();
					$(scrollElement).animate(
						{scrollTop: targetOffset},
						250,
						function() {
							location.hash = target;
					});
				});
			}
		}
	});
}