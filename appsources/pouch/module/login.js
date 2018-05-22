document.addEventListener('contextmenu', event => event.preventDefault());

$('#login').submit(function(event) {
    event.preventDefault();

    var form = $('#login');	
    $("#btnlogin").html('<span class="login100-form-btn" type="submit">Loading....</span>');

	$.ajax({
		type : 'POST',
		url  : toUrl+"/auth/validation",
		data : form.serialize(),
		// dataType: "json",
		success: function(data){
			console.log(data);
			// alert(data);
			// return;
			if(data =="Sukses"){
				window.location.href=toUrl+"/dashboard/cash";
				return;
			}else{
                $("#btnlogin").html('<button class="login100-form-btn" type="submit">Login</button>');
                $("#errormsg").html('<p><i class="fa fa-exclamation-circle"></i> Email not registered</p>');
			}
		},error: function(xhr, ajaxOptions, thrownError){            
			alert(xhr.responseText);
			$("#loginbutton").html('<button class="btn waves-effect waves-light col s12">Login</button>');
		}
	});
});

$('#regis').submit(function(event) {
    event.preventDefault();

    var form = $('#regis');	
    $("#btnregist").html('<span class="login100-form-btn" type="submit">Loading....</span>');

	$.ajax({
		type : 'POST',
		url  : toUrl+"/auth/createUser",
		data : form.serialize(),
		dataType: "json",
		success: function(data){
			if(data.status == 200){
				window.location.href=toUrl+"/auth/successfull/"+data.keterangan;
            }else{
                $("btnregist").html('<button class="login100-form-btn" type="submit">Create Account</button>');
                $("#errormsg").html('<p><i class="fa fa-exclamation-circle"></i> '+data.keterangan+'</p>');
            }
		},error: function(xhr, ajaxOptions, thrownError){            
			alert(xhr.responseText);
			$("#errormsg").html('<p><i class="fa fa-exclamation-circle"></i> Try again, make sure your connection is strong</p>');
		}
	});
});