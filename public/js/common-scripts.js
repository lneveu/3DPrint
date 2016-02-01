var Script = function () {
    // tool tips
    $('.tooltips').tooltip();
    // popovers
    $('.popovers').popover();
}();

(function() {
    // DOM READY
    $( document ).ready(function()
    {
        // fadeout auto alert-fade elements
        $('.alert-fade').fadeTo(3000, 500).fadeOut(500, function()
        {
            $(this).alert('close');
        });
    });


	$('<i id="back-to-top"></i>').appendTo($('body'));

	$(window).scroll(function() {

		if($(this).scrollTop() != 0) {
			$('#back-to-top').fadeIn();
		} else {
		          $('#back-to-top').fadeOut();
		}

	});

	$('#back-to-top').click(function() {
		$('body,html').animate({scrollTop:0},600);
	});
})();
