document.addEventListener('contextmenu', event => event.preventDefault());

$('#login').submit(function(event) {
    event.preventDefault();

    var form = $('#login');	
    $("#loginbutton").html('<span class="btn waves-effect waves-light col s12">Loading....</span>');

	$.ajax({
		type : 'POST',
		url  : toUrl+"/auth/validation",
		data : form.serialize(),
		// dataType: "json",
		success: function(data){
			// alert(data);
			// return;
			if(data =="Sukses"){
				window.location.href=toUrl+"/dashboard/cash";
				return;
			}else{
				swal("Ooopps!", "Password Or Email is Wrong", "warning");
				$("#loginbutton").html('<button class="btn waves-effect waves-light col s12">Login</button>');
				return;
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
    $("#register").html('<span class="waves-effect waves-light btn gradient-45deg-light-blue-cyan box-shadow col s12">Loading....</span>');

	$.ajax({
		type : 'POST',
		url  : toUrl+"/auth/createUser",
		data : form.serialize(),
		dataType: "json",
		success: function(data){
			if(data.status == 200){
				swal({    
					title: "Good Job !",
					text: "Registration Success",
					type: "success",
					closeOnConfirm: false },
					function(){
					window.location.href=toUrl+"/auth/login";
				});               
            }else{
                swal("Ooopps!", "Try again, make sure your username unique", "error");
                $("#register").html('<button class="waves-effect waves-light btn gradient-45deg-light-blue-cyan box-shadow col s12">Register Now</button>');
            }
		},error: function(xhr, ajaxOptions, thrownError){            
			alert(xhr.responseText);
			$("#register").html('<button class="waves-effect waves-light btn gradient-45deg-light-blue-cyan box-shadow col s12">Register Now</button>');
		}
	});
});