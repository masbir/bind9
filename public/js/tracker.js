$(function(){
	$.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });
	$.ajax({
		"url" : "/stats/track",
		"type" : "POST"
	});
})