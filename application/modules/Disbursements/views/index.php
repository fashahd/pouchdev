<?php
	$optarr = array("pending"=>"Pending","failed"=>"Failed","completed"=>"Completed");
	$optstatus = "";
	foreach($optarr as $value => $ket){
		if($status == $value){
			$chkd = "selected";
		}else{
			$chkd = "";
		}
		$optstatus .= "<option $chkd value='$value'>$ket</option>";
	}
?>
<!-- Page header -->
<div id="batch_disbursement">
	<div class="page-header page-header-default">
		<div class="page-header-content">
			<div class="page-title">
				<h4><?=$module?></h4>
			</div>
		</div>
		<div class="breadcrumb-line">
			<div class="panel-flat">
				<div class="panel-body">
					<div class="col-lg-2">
						<div class="form-group">
							<select name="status" id="status_batch" data-placeholder="All Status" class="select">
								<option value="all">All Status</option>
								<?=$optstatus?>
							</select>
						</div>
					</div>
					<div class="col-md-4">
						<div class="content-group-lg">
						<div class="input-group">
							<span class="input-group-addon"><i class="icon-calendar22"></i></span>
							<input id="datecash" value="<?=$date?>" name="date" type="text" class="form-control pickadate-selectors" readonly>
						</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="content-group-lg">
						<div class="input-group">
							<span class="input-group-addon"><i class="icon-calendar22"></i></span>
							<input id="datecash2" value="<?=$date2?>" name="date" type="text" class="form-control pickadate-selectors" readonly>
						</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-flat">
					<div class="panel-heading">
						<h6 class="panel-title">List of Transactions</h6>
					</div>
					<div class="panel-body" id="disbursementdata">
						<?php if($datadisburse != ""){?>							
						<div class="row">
							<div class="col-md-12">
								<div class="table-responsive">
									<table id="tableDisbursement" class="table">
										<thead>
											<tr>
												<th>External ID</th>
												<th>Date</th>
												<th>Amount (Rp)</th>
												<th>Bank Code</th>
												<th>Account Name</th>
												<th>Account Number</th>
												<th>Status</th>
											</tr>
										</thead>
										<tbody>
											<?=$datadisburse?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					<?php }else{ ?>
						<div class="row">
							<div class="col-md-12">
								<div class="panel">
									<div class="panel-body text-center">
										<div class="icon-object border-success text-success"><i class="icon-wallet"></i></div>
										<h5 class="text-semibold">No disbursements found</h5>
										<p class="mb-15">We show disbursements by filter, try changing your filter</p>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$("#status_batch").select2();
</script>


<script>
    // Pikadate datepicker
    $('.pickadate-selectors').pickadate(
		{
			format: 'yyyy-mm-dd',
			selectYears: true,
			selectMonths: true
    	}
	);
	var from_$input = $('#datecash').pickadate();
    var from_picker = from_$input.pickadate('picker');

    var to_$input = $('#datecash2').pickadate();
    var to_picker = to_$input.pickadate('picker');


    // Check if there’s a “from” or “to” date to start with.
    if ( from_picker.get('value') ) 

    {        
       var today = new Date($('#datecash').val());
       today.setDate(today.getDate())
      to_picker.set('min', today)
    }
    if ( to_picker.get('value') ) 
    {
       var today = new Date($('#datecash2').val());
    today.setDate(today.getDate() - 1)
      from_picker.set('max', today)


    }
    // When something is selected, update the “from” and “to” limits.
    from_picker.on('set', function(event) 
    {

      if ( event.select ) 
      {
         var today = new Date($('#datecash').val());
    today.setDate(today.getDate() + 1)
        to_picker.set('min', today)    
      }

      else if ( 'clear' in event ) 
      {

        to_picker.set('min', false)
      }

    })

    to_picker.on('set', function(event) 
    {
      if ( event.select ) 
      {
        var today = new Date($('#datecash2').val());
    today.setDate(today.getDate() - 1)
        from_picker.set('max', today)
      }
      else if ( 'clear' in event ) 
      {

        from_picker.set('max', false)
      }
	})
</script>