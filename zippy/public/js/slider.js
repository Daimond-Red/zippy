(function( $ ){
	var i = 1;

	$.fn.slider = function( options ) {

		// this.mouseenter(function(){isOnDiv=true;});
		var settings = $.extend({
			slides : 3,
			animation_time : 1000,
		}, options );
		
		var count_slide = this.find('.slide').length;
		var show_slide = settings.slides - 1;
		
		if(i == (count_slide - show_slide) || settings.slides > count_slide ) {
			i = 0;
		}
		var slide_width = this.find('.slide').width() + settings.margin;

		$('#slider').css('width', settings.slides*slide_width);

		this.animate({
			left : -i++*slide_width+"px"
		}, settings.animation_time);
	};
}(jQuery));