$(function() {
	//Click on button
	// http://dinbror.dk/bpopup/
	$("#cme").click(function(){
		$('#test_message').bPopup();
	});

	//Photo slider
	$('.slider').glide({
            autoplay: 3500,
	    hoverpause: true, // set to false for nonstop rotate
	    arrowRightText: '&rarr;',
	    arrowLeftText: '&larr;'
	});

	//Smoothy slide on inner link
	$('a[href^="#"]').on('click',function (e) {
	    e.preventDefault();

	    var target = this.hash;
	    $target = $(target);

	    $('html, body').stop().animate({
	        'scrollTop': $target.offset().top
	    }, 900, 'swing', function () {
	        window.location.hash = target;
	    });
	});
})

