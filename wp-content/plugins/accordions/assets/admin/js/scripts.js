jQuery(document).ready(function($)
	{

		$('.accordions-tooltip').tooltipster();


		$(document).on('click', '#accordions_metabox .reset-active', function()
			{

				$('input[name="accordions_active_accordion"]').prop('checked', false);
				
			})






		$(document).on('keyup', '#accordions_metabox .section-panel input', function()
			{
				var text = $(this).val();
				
				if(text == '')
					{
						$(this).parent().parent().children('.section-header').children('.accordions-title-preview').html('start typing');
					}
				else
					{
						$(this).parent().parent().children('.section-header').children('.accordions-title-preview').html(text);
					}
				
				
			
			})



		$(document).on('click', '#accordions_metabox .section-header .expand-compress', function()
			{	
				if($(this).parent().parent().hasClass('active'))
					{
					$(this).parent().parent().removeClass('active');
					}
				else
					{
						$(this).parent().parent().addClass('active');
					}
				

			})





		$(document).on('click', '.accordions_icons_custom_plus', function()
			{	
			var icon_id = prompt("font awesome icon id ?","");
			if(icon_id != null && icon_id != '')
				{

					$(this).addClass(icon_id);
					$(".accordions_icons_custom_plus input").val(icon_id);
				}

			})
		
		
		$(document).on('click', '.accordions_icons_custom_minus', function()
			{	
			var icon_id = prompt("font awesome icon id ?","");
			if(icon_id != null && icon_id != '')
				{
		
					
					$(this).addClass(icon_id);
					$(".accordions_icons_custom_minus input").val(icon_id);
				}

			})		
		

		
		$(document).on('click', '#accordions_metabox .removeaccordions', function()
			{	
				var is_confirm = $(this).attr('confirm');
				
				if(is_confirm=='yes'){
					$(this).parent().parent().remove();
					}
				else{
					
					$(this).html(L10n_accordions.confirm_text);
					$(this).attr('confirm','yes');
					
					}
			})	
		

 		

	});