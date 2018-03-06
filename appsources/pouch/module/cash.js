$(document).on('change', '#datecash', function () {
    var vdt      = $('#datecash').val();
    var vdt2     = $('#datecash2').val();
    $.ajax({
		type : 'POST',
		url  : toUrl+"/dashboard/checkData",
		data : {vdt:vdt, vdt2:vdt2},
		dataType: "json",
		success: function(data){
			$("#total_transaction").html(data.total_transaction);
			$("#money_out").html(data.outcome);
		},error: function(xhr, ajaxOptions, thrownError){            
			alert(xhr.responseText);
		}
	});
});

$(document).on('change', '#datecash2', function () {
	var vdt      = $('#datecash').val();
    var vdt2     = $('#datecash2').val();
    $.ajax({
		type : 'POST',
		url  : toUrl+"/dashboard/checkData",
		data : {vdt:vdt, vdt2:vdt2},
		dataType: "json",
		success: function(data){
			$("#total_transaction").html(data.total_transaction);
			$("#money_out").html(data.outcome);
		},error: function(xhr, ajaxOptions, thrownError){            
			alert(xhr.responseText);
		}
	});
});