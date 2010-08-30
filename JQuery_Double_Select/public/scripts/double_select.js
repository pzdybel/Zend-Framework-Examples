function clearOptions(name)
{
	if(name == null) return false;
	var element = $('<option />').attr('value', '-1');
	$('#' + name + ' option').each(function(option) {
		if($(this).attr('value') == '-1')
		{
			element.text($(this).text());
		}
	});
	$('#' + name).html(element);
}

function getCategories(idAlbum)
{
	$('#albums_categories').attr("disabled", true);
	var active_option = $('#albums_categories [selected]').val();
	if(idAlbum == null) {
		idAlbum = $('#albums').val();	
	}
	if(idAlbum < 0) {
		clearOptions('albums_categories');
		return false;
	} else {
		$.ajax({
			  url: '/index/ajax/id/' + idAlbum,
			  dataType: 'json',
			  success: function(options) {
				clearOptions('albums_categories');
			  	for(var option in options){
				  	element = $('<option />');
				  	element.attr('value', option);
				  	element.text(options[option]);
				  	if(option == active_option) element.attr('selected', true);
				  	$('#albums_categories').append(element);
				}			
			  	$('#albums_categories').removeAttr("disabled"); 		
			  }
		});
	}				
}
$(document).ready(function()
{
	$('#albums').change(function() {
		getCategories($(this).val());
	});
	getCategories();
});