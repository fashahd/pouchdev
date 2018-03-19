<?php
    list($fullName,$email,$phoneNumber)=$account;
    $retPermission = "";
    if($permission){
        foreach($permission as $row){
            $retPermission .= "<i style='font-size:16pt;margin-right:10px' class='$row->permission_icon'></i> ";
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
            $retListPermission .= '
        
			<tr class="active border-double">
				<td><input '.$chk.' type="checkbox" name="permission[]" id="pemr_'.$key->permission_id.'" value="'.$key->permission_id.'"/></td>
				<td>
					<div class="media-left media-middle">
						<a href="#"><i class="'.$key->permission_icon.'"></i></a>
					</div>
					<div class="media-left">
						<div class=""><a href="#" class="text-default text-semibold">'.$key->permission_name.'</a></div>
						<div class="text-muted text-size-small">
							'.$key->permission_ket.'
						</div>
					</div>
				</td>
			</tr>
			';
        }
    }
?>
<div class="row">
    <form class="col s12" id="updateuser">
	<div class="col-md-12">
		<div class="col-md-6">
			<div class="table-responsive">
					<table class="table">
					<tbody>
						<tr><td colspan="2">Edit User</td></tr>
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
		<div class="col-md-6">
			<div class="table-responsive">
				<table class="table text-nowrap">
					<colgroup><col width="2%"></colgroup>
					<tbody>
						<tr><td colspan="2">Edit Permission</td></tr>
						<?=$retListPermission?>
						<tr>
							<td><button class='btn btn-primary' type='submit'>Save</button></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
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