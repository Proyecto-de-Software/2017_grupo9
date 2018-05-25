$(document).on('click','.pagination a'), function(e){
	e.preventDefault();
	var page = $(this).attr('href');

	console.log(page);
});