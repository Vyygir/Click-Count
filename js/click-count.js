jQuery(document).ready(function($) {
	var els = $('.clco');

	if (els.length) {
		els.on('click', function(event) {
			var _, _id, _disable, _request;

			_ = $(this);
			_id = _.data('id');
			_disable = _.data('disable') || false;

			if (_id && _id % 1 === 0) {
				if (_disable) {
					event.preventDefault();
				}

				_request = $.ajax({
					url: window.clco_domain + '/wp-admin/admin-ajax.php',
					type: 'POST',
					data: {
						action: 'clco_count',
						id: _id
					}
				});

				if (window.clco_callbacks.hasOwnProperty('success')) {
					_request.success(window.clco_callbacks.success);
				}
			}
		});
	}
});