$(document).on('change', '#image_upload_file', function () {
	var progressBar = $('.progressBar'), bar = $('.progressBar .bar'), percent = $('.progressBar .percent');

	$('#image_upload_form').ajaxForm({
		beforeSend: function() {
			progressBar.fadeIn();
			var percentVal = '0%';
			bar.width(percentVal)
			percent.html(percentVal);
		},
		uploadProgress: function(event, position, total, percentComplete) {
			var percentVal = percentComplete + '%';
			bar.width(percentVal)
			percent.html(percentVal);
		},
		success: function(html, statusText, xhr, $form) {	
			obj = $.parseJSON(html);
			if(obj.status == 200){
				var percentVal = '100%';
				bar.width(percentVal)
				percent.html(percentVal);
				$("#imgArea>img").prop('src',obj.image_medium);
				window.location.reload();
			}else{
				alert(obj.error);
			}
		},
		complete: function(xhr) {
			progressBar.fadeOut();
		}	
	}).submit();
});

$('#account_information').submit(function(event) {
    event.preventDefault();

    var form = $('#account_information');	
    // $("#register").html('<span class="waves-effect waves-light btn gradient-45deg-light-blue-cyan box-shadow col s12">Loading....</span>');

	$.ajax({
		type : 'POST',
		url  : toUrl+"/settings/updateAccountInformation",
		data : form.serialize(),
		dataType: "json",
		success: function(data){
			if(data.status == 200){
				swal({    
					title: "Good Job !",
					text: "Account Update Success",
					type: "success",
					closeOnConfirm: false
				 });               
            }else{
				swal("Ooopps!", "Try again, Please Check Your Correct Data", "error");
				return;
			}
		},error: function(xhr, ajaxOptions, thrownError){            
			alert(xhr.responseText);
		}
	});
});

$('#business_information').submit(function(event) {
    event.preventDefault();

    var form = $('#business_information');	
    // $("#register").html('<span class="waves-effect waves-light btn gradient-45deg-light-blue-cyan box-shadow col s12">Loading....</span>');

	$.ajax({
		type : 'POST',
		url  : toUrl+"/settings/updateBusinessInformation",
		data : form.serialize(),
		dataType: "json",
		success: function(data){
			if(data.status == 200){
				swal({    
					title: "Good Job !",
					text: "Business Update Success",
					type: "success",
					closeOnConfirm: false
				 });               
            }else{
				swal("Ooopps!", "Try again, Please Check Your Correct Data", "error");
				return;
			}
		},error: function(xhr, ajaxOptions, thrownError){            
			alert(xhr.responseText);
		}
	});
});

function changePassword(){
	$('#modal1').modal('open');
}

function changePIN(){
	$('#modal2').modal('open');
}

$('#changePassword').submit(function(event) {
    event.preventDefault();

    var form = $('#changePassword');	
    // $("#register").html('<span class="waves-effect waves-light btn gradient-45deg-light-blue-cyan box-shadow col s12">Loading....</span>');

	$.ajax({
		type : 'POST',
		url  : toUrl+"/settings/updateNewPassword",
		data : form.serialize(),
		dataType: "json",
		success: function(data){
			if(data.status == "success"){
				swal({    
					title: "Great",
					text: "Update Password Updated",
					type: "success",
					closeOnConfirm: true },
					function(){
						$("#cur_pass").val("");
						$("#new_pass").val("");
						$("#re_new_pass").val("");
						$('#modal1').modal('close');
				});
				return;               
			}
			if(data.status == "not_match"){
				swal({    
					title: "Oppsss !",
					text: "Password is Wrong",
					type: "warning",
					closeOnConfirm: true });
				return;               
			}
			if(data.status == "new_not_match"){
				swal({    
					title: "Oppsss !",
					text: "Password is Not Same, Check Again",
					type: "warning",
					closeOnConfirm: true });
				return;               
			}
			else{
				swal({    
					title: "Oppsss !",
					text: "Failed to Connect, Try Again",
					type: "error",
					closeOnConfirm: true });
				return; 
				// return alert(JSON.stringify(data));
			}
		},error: function(xhr, ajaxOptions, thrownError){            
			alert(xhr.responseText);
		}
	});
});

$('#changePIN').submit(function(event) {
    event.preventDefault();

    var form = $('#changePIN');	
    // $("#register").html('<span class="waves-effect waves-light btn gradient-45deg-light-blue-cyan box-shadow col s12">Loading....</span>');

	$.ajax({
		type : 'POST',
		url  : toUrl+"/settings/updateNewPIN",
		data : form.serialize(),
		dataType: "json",
		success: function(data){
			if(data.status == "success"){
				swal({    
					title: "Great",
					text: "Your PIN has been updated",
					type: "success",
					closeOnConfirm: true },
					function(){
						$("#txtChar").val("");
						$('#modal2').modal('close');
				});
				return;               
			}
			else{
				swal({    
					title: "Oppsss !",
					text: "Failed to Connect, Try Again",
					type: "error",
					closeOnConfirm: true });
				return; 
				// return alert(JSON.stringify(data));
			}
		},error: function(xhr, ajaxOptions, thrownError){            
			alert(xhr.responseText);
		}
	});
});

$('#createUser').submit(function(event) {
    event.preventDefault();

    var form = $('#createUser');	
    // $("#register").html('<span class="waves-effect waves-light btn gradient-45deg-light-blue-cyan box-shadow col s12">Loading....</span>');

	$.ajax({
		type : 'POST',
		url  : toUrl+"/settings/createNewUser",
		data : form.serialize(),
		dataType: "json",
		success: function(data){
			if(data.status == 200){
				swal({    
					title: "Great",
					text: data.keterangan,
					type: "success",
					closeOnConfirm: true 
				},
					function(){
						$("#txtChar").val("");
						$('#modal4').modal('close');
						window.location.reload();
				});
				return;               
			}
			else{
				swal({    
					title: "Oppsss !",
					text: data.keterangan,
					type: "warning",
					closeOnConfirm: true });
				return; 
				// return alert(JSON.stringify(data));
			}
		},error: function(xhr, ajaxOptions, thrownError){            
			alert(xhr.responseText);
		}
	});
});

function deletewithdrawbank(id){
	$.ajax({
		type : 'POST',
		url  : toUrl+"/settings/deleteBank",
		data : {id:id},
		dataType: "json",
		success: function(data){
			if(data.status == 200){
				swal({    
					title: "Great",
					text: data.keterangan,
					type: "success",
					closeOnConfirm: true 
				},
					function(){
						window.location.reload();
				});
				return;               
			}
			else{
				swal({    
					title: "Oppsss !",
					text: data.keterangan,
					type: "warning",
					closeOnConfirm: true });
				return; 
				// return alert(JSON.stringify(data));
			}
		},error: function(xhr, ajaxOptions, thrownError){            
			alert(xhr.responseText);
		}
	});
}

$('#createBank').submit(function(event) {
    event.preventDefault();

    var form = $('#createBank');	
    // $("#register").html('<span class="waves-effect waves-light btn gradient-45deg-light-blue-cyan box-shadow col s12">Loading....</span>');

	$.ajax({
		type : 'POST',
		url  : toUrl+"/settings/createNewBank",
		data : form.serialize(),
		dataType: "json",
		success: function(data){
			if(data.status == 200){
				swal({    
					title: "Great",
					text: data.keterangan,
					type: "success",
					closeOnConfirm: true 
				},
					function(){
						$("#txtChar").val("");
						$('#modal5').modal('close');
						window.location.reload();
				});
				return;               
			}
			else{
				swal({    
					title: "Oppsss !",
					text: data.keterangan,
					type: "warning",
					closeOnConfirm: true });
				return; 
				// return alert(JSON.stringify(data));
			}
		},error: function(xhr, ajaxOptions, thrownError){            
			alert(xhr.responseText);
		}
	});
});

function isNumberKey(evt)
{
   	var charCode = (evt.which) ? evt.which : event.keyCode
   	if (charCode > 31 && (charCode < 48 || charCode > 57)){
	   	$("#notepin").html("<span class='red-text'>Numeric Only</span><br><br>");
		return false;
   	}
	  
	$("#notepin").html("");
   	return true;
}

function loader(){
	// var light_6 = document.getElementById("settings");
	$("#settings").html('<div style="text-align:center">'
	+'loading......</div>');
}

$("#users").click(function(){
	loader();

	$.ajax({
		type : 'POST',
		url  : toUrl+"/settings/tabSettingAjax/users",
		success: function(data){
			$("#settings").html(data);
		},error: function(xhr, ajaxOptions, thrownError){            
			alert(xhr.responseText);
		}
	});
})

$("#billing").click(function(){
	loader();

	$.ajax({
		type : 'POST',
		url  : toUrl+"/settings/tabSettingAjax/billing",
		success: function(data){
			$("#settings").html(data);
		},error: function(xhr, ajaxOptions, thrownError){            
			alert(xhr.responseText);
		}
	});
})

$("#withdraw").click(function(){
	loader();

	$.ajax({
		type : 'POST',
		url  : toUrl+"/settings/tabSettingAjax/withdraw",
		success: function(data){
			$("#settings").html(data);
		},error: function(xhr, ajaxOptions, thrownError){            
			alert(xhr.responseText);
		}
	});
})

$("#general").click(function(){
	loader();

	$.ajax({
		type : 'POST',
		url  : toUrl+"/settings/tabSettingAjax/general",
		success: function(data){
			$("#settings").html(data);
		},error: function(xhr, ajaxOptions, thrownError){            
			alert(xhr.responseText);
		}
	});
})

$("#developer").click(function(){
	loader();

	$.ajax({
		type : 'POST',
		url  : toUrl+"/settings/tabSettingAjax/developer",
		success: function(data){
			$("#settings").html(data);
		},error: function(xhr, ajaxOptions, thrownError){            
			alert(xhr.responseText);
		}
	});
})

function addUser(){
	$('#modal4').modal('open');
}

function addBankWithdraw(){
	$('#modal5').modal('open');
}

function editUser(userID){
	loader();
	$.ajax({
		type : 'POST',
		url  : toUrl+"/settings/formEditUser",
		data : {userID:userID},
		success: function(data){
			$("#settings").html(data);
		},error: function(xhr, ajaxOptions, thrownError){            
			alert(xhr.responseText);
		}
	});
}

function deleteuser(userID){
	swal({    
		title: "Are You Sure ?",
		text: "User will be deactivated",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#DD6B55",
		confirmButtonText: "Yes, delete it!",
		closeOnConfirm: false 
	},
	function(){
		$.ajax({
			type : 'POST',
			url  : toUrl+"/settings/deleteUser",
			data: {userID:userID},
			success: function(data){
				if(data == "sukses"){
					swal({    
						title: "Success",
						text: "User has been deleted",
						type: "success",
						closeOnConfirm: false 
					},
					function(){
						window.location.reload();
					});
					return;
				}
			},error: function(xhr, ajaxOptions, thrownError){            
				alert(xhr.responseText);
			}
		});
	});
}