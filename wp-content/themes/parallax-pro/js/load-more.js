jQuery(function($){

	$( document ).on( 'click' , '.loadmore' , function() {
		var that = $(this);
		var page = that.data('page');
		var newPage = page+1;
		var ajaxurl = that.data('url');
		var category = that.data('category');
		$.ajax({

			url: ajaxurl,
			type: 'post',
			data: {
				page: page,
				category: category,
				action: 'ajax_load_more'
			},
			error: function( response ) {
				console.log(response);
			},
			success: function( response ) {
				that.data('page', newPage);
				$('#loadmore-data').append( response );
			}

		});
		console.log(page);

	});

});