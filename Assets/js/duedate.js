window.onload = function() {
	if (Cookies.get('currentToggle')==='on') {
		$(".project-header").css('display','block');
	} else {
		$(".project-header").css('display','none');
    }
};
KB.on('dom.ready', function () {

	function goToLink (selector) {
        if (! KB.modal.isOpen()) {
            var element = KB.find(selector);

            if (element !== null) {
                window.location = element.attr('href');
            }
        }
    }

    KB.onKey('v+d', function () {
        goToLink('a.view-duedate');
    });

	
	$('.duedate-menu-button').on("click",function(){
    $(".project-header").slideToggle('slow', function() {
		// Animation complete.
		Cookies.set('currentToggle', $(".project-header").is(":visible")?'on':'off' );
	});
  });
});
/*/
var resizeTimer;
$(window).on('resize', function (e) {
	clearTimeout(resizeTimer);
	resizeTimer = setTimeout(function () {
		if ($(window).width() > 1165) {
			$('.project-header').show();
		} else {
			$('.project-header').hide();
		}
	}, 250);
});
//*/