<?php
    list($fullName,$email,$phoneNumber)=$account;
    $retPermission = "";
    if($permission){
        foreach($permission as $row){
            $retPermission .= "<i class='material-icons'>$row->permission_icon</i>";
            $arrpermission[$row->permission_id] = $row->permission_id;
        }
    }
    $retListPermission = "";
    if($listPermission){
        foreach($listPermission as $key){
            if(isset($arrpermission[$key->permission_id])){
                $chk = "checked='true'";
            }else{
                $chk = "";
            }
            $retListPermission .= "
                <li>
                    <div class='collapsible-header'>
                        <input $chk type='checkbox' name='permission[]' id='pemr_$key->permission_id' value='$key->permission_id'/>
                        <label for='pemr_$key->permission_id'>
                        <i class='material-icons left'>$key->permission_icon</i>
                        $key->permission_name
                    </div>
                    <div class='collapsible-body'>
                        <p>$key->permission_ket</p>
                    </div>
                </li>
            ";
        }
    }
?>

<div class="col s12 m12 l6">
    <div class="card-panel">
        <div class="row">
            <h4 class="header2">User Detail Information</h4>
            <table class="bordered">
                <tbody>
                    <tr></tr>
                    <tr>
                        <td>Full Name</td>
                        <td><?=$fullName?></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td><?=$email?></td>
                    </tr>
                    <tr>
                        <td>Permission</td>
                        <td><?=$retPermission?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="col s12 m12 l6">
    <form class="col s12" id="updateuser">
        <div class="row">
            <ul class="collapsible collapsible-accordion" data-collapsible="accordion">
                <li>
                    <div class='collapsible-header'>
                        <h4 class="header2">Edit Permission</h4>
                    </div>
                </li>
                <?=$retListPermission?>
                <li>
                    <div class='collapsible-header'>
                        <button class='btn blue' type='submit'>Save</button>
                    </div>
                </li>
            </ul>
        </div>
    </form>
</div>

<script>
    
    $(document).ready(function(){
        $('.collapsible').collapsible();
    });
    

$('#updateuser').submit(function(event) {
    event.preventDefault();

    var form = $('#updateuser');	
    // $("#register").html('<span class="waves-effect waves-light btn gradient-45deg-light-blue-cyan box-shadow col s12">Loading....</span>');

	$.ajax({
		type : 'POST',
		url  : toUrl+"/settings/updateUser",
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
</script>