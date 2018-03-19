$("#deleteBatch").click(function(){
	$('#modal_small').modal('open');
})

$("#approveBatch").click(function(){
	$('#modal_small').modal('open');
})

$('#setDelete').submit(function(event) {
	event.preventDefault();

    var form = $('#setDelete');	
    // $("#register").html('<span class="waves-effect waves-light btn gradient-45deg-light-blue-cyan box-shadow col s12">Loading....</span>');
	$.ajax({
		type : 'POST',
		url  : toUrl+"/batch/checkPin",
		data : form.serialize(),
		dataType: "json",
		success: function(data){
			if(data.status == "match"){
				SetDeleteBatch();        
			}
			else{
				$("#notepin").html("<span class='red-text'>PIN is Wrong</span><br><br>");
				return; 
				// return alert(JSON.stringify(data));
			}
		},error: function(xhr, ajaxOptions, thrownError){            
			alert(xhr.responseText);
		}
	});
});

$('#setApprove').submit(function(event) {
    event.preventDefault();

    var form = $('#setApprove');	
    // $("#register").html('<span class="waves-effect waves-light btn gradient-45deg-light-blue-cyan box-shadow col s12">Loading....</span>');

	$.ajax({
		type : 'POST',
		url  : toUrl+"/batch/checkPin",
		data : form.serialize(),
		dataType: "json",
		success: function(data){
			if(data.status == "match"){
				SetApproveBatch();        
			}
			else{
				$("#notepin").html("<span class='red-text'>PIN is Wrong</span><br><br>");
				return; 
				// return alert(JSON.stringify(data));
			}
		},error: function(xhr, ajaxOptions, thrownError){            
			alert(xhr.responseText);
		}
	});
});

function SetDeleteBatch(){	
	var val = [];
	$("input[name='batch_disburse[]']:checked").each( function (i) {
		val[i] = $(this).val();
	});

	if(val == null || val == ''){
		Materialize.toast('Please Select One Batch', 1000, 'rounded');
		return;
	}

	$.ajax({
		type : 'POST',
		url  : toUrl+"/batch/deleteBatch",
		data : {val:val},
		dataType: "json",
		success: function(data){
			if(data.status == 200){
				swal({    
					title: "Sorry !",
					text: "Deleted Success",
					type: "success",
					closeOnConfirm: false },
					function(){
					window.location.href=toUrl+"/disbursements";
				});
				return;
			}else{
				swal("Yeay!", "Delete Failed, Try Again", "error");
				return;
			}
		},error: function(xhr, ajaxOptions, thrownError){            
			// alert(xhr.responseText);
			// $("#batch_disbursement").html('');
			swal("Huffft!", "Check Your Connecton or Please Call Our Customer Care", "error");
			return;
		}
	});
}

function SetApproveBatch(){	
	var val = [];
	$("input[name='batch_disburse[]']:checked").each( function (i) {
		val[i] = $(this).val();
	});

	if(val == null || val == ''){
		Materialize.toast('Please Select One Batch', 1000, 'rounded');
		return;
	}

	$.ajax({
		type : 'POST',
		url  : toUrl+"/batch/approveBatch",
		data : {val:val},
		dataType: "json",
		success: function(data){
			// alert(data);
			// return;
			if(data.status == 401){
				swal("Oooooops", "Your Account Balance is Not Enough", "warning");
				return;
			} 
			if(data.status == 200){
				swal({    
					title: "Great",
					text: "Approve Success",
					type: "success",
					closeOnConfirm: false },
					function(){
					window.location.href=toUrl+"/disbursements";
				});
				return;
			}else{
				// alert(xhr.responseText);
				swal("Yeay!", "Delete Failed, Try Again", "error");
				return;
			}
		},error: function(xhr, ajaxOptions, thrownError){            
			// alert(xhr.responseText);
			// $("#batch_disbursement").html('');
			swal("Huffft!", "Check Your Connecton or Please Call Our Customer Care", "error");
			return;
		}
	});
}

function showDetailBatch(transaction_id){
	$.ajax({
		type : 'POST',
		url  : toUrl+"/batch/detailBatch",
		data : {transaction_id:transaction_id},
		success: function(data){
			$("#batch_disbursement").html(data);
		},error: function(xhr, ajaxOptions, thrownError){            
			alert(xhr.responseText);
			$("#batch_disbursement").html('');
		}
	});
}

function showDownloadTemplate(){
    $.ajax({
		type : 'POST',
		url  : toUrl+"/batch/uploadform",
		// data : form.serialize(),
		// dataType: "json",
		success: function(data){
			$("#batch_disbursement").html(data);
		},error: function(xhr, ajaxOptions, thrownError){            
			alert(xhr.responseText);
			$("#batch_disbursement").html('');
		}
	});
}

function setTab(type){
	$('#btnneed').show();
	if(type == "approved"){
		$('#btnneed').hide();
	}
    $.ajax({
		type : 'POST',
		url  : toUrl+"/batch/setTab",
		data : {type:type},
		dataType: "json",
		success: function(data){
			$("#tab").html(data.contentTab);
			$("#content_approve").html(data.content);
		},error: function(xhr, ajaxOptions, thrownError){            
			alert(xhr.responseText);
			$("#tab").html('');
			$("#content_approve").html('');
		}
	});
}

function checkAll(ele) {
	var checkboxes = document.getElementsByTagName('input');
	if (ele.checked) {
		for (var i = 0; i < checkboxes.length; i++) {
			if (checkboxes[i].type == 'checkbox') {
				checkboxes[i].checked = true;
			}
		}
	} else {
		for (var i = 0; i < checkboxes.length; i++) {
			console.log(i)
			if (checkboxes[i].type == 'checkbox') {
				checkboxes[i].checked = false;
			}
		}
	}
}