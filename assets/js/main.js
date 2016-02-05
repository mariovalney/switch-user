jQuery(document).ready(function($) {
	$('.js-su-user').on('click', function(event) {
		event.preventDefault();
		if (!$('.su-wrapper').hasClass('working')) {
			$('.su-wrapper').addClass('working');
			$('.su-wrapper').removeClass('open');

			var user_id = $(this).attr('data-user-id');
			var su_security = $('.su-wrapper').find('#su-change-user-security').val();

			$.ajax({
				url: SU.ajaxurl,
				type: 'POST',
				data: {action: 'su_change_user', user_id: user_id, su_nonce: su_security},
			})
			.done(function(data) {
				if (data.status == 'ok') {
					alert('<?php _e("Current user successfully changed.", SU_TEXTDOMAIN) ?>');
					window.location.reload(true);
				} else if (data.msg != '') {
					alert(data.msg);
				} else {
					alert('<?php _e("Oops... error: please try again.", SU_TEXTDOMAIN) ?>');
				}
			})
			.fail(function() {
				alert('<?php _e("There was a connection error, please try again.", SU_TEXTDOMAIN) ?>');
			});
		}
	});

	$('.su-wrapper-toggle').on('click', function(event) {
		event.preventDefault();
		$('.su-wrapper').toggleClass('open');
	});
});
