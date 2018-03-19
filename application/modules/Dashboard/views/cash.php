
<!-- Page header -->
<div class="page-header page-header-default">
  <div class="page-header-content">
    <div class="page-title">
      <h4><?=$module?></h4>
    </div>

    <div class="heading-elements">
        <div class="col-md-6">
          <div class="content-group-lg">
            <div class="input-group">
              <span class="input-group-addon"><i class="icon-calendar22"></i></span>
              <input id="datecash" value="<?=$date?>" name="date" type="text" class="form-control pickadate-selectors" readonly>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="content-group-lg">
            <div class="input-group">
              <span class="input-group-addon"><i class="icon-calendar22"></i></span>
              <input id="datecash2" value="<?=$date?>" name="date" type="text" class="form-control pickadate-selectors" readonly>
            </div>
          </div>
        </div>        
    </div>
  </div>
</div>
<!-- /page header -->


<!-- Content area -->
<div class="content">
  <!-- Dashboard content -->
  <div class="row">
    <div class="col-lg-12">

      <!-- Quick stats boxes -->
      <div class="row">
        <div class="col-lg-3">
          <!-- Members online -->
          <div class="panel bg-teal-400">
            <div class="panel-body">
              <div class="heading-elements">
                <ul class="icons-list">
                  <li><i style="font-size:18pt" class="icon-wallet"></i></li>
                </ul>
              </div>
              <h3 class="no-margin">Rp <?=$balance?></h3>
              TOTAL BALANCE
              
            </div>
          </div>
          <!-- /members online -->
        </div>
        <div class="col-lg-3">
          <!-- Members online -->
          <div class="panel bg-blue-400">
            <div class="panel-body">
              <div class="heading-elements">
                <ul class="icons-list">
                  <li><i style="font-size:18pt" class="icon-database-arrow"></i></li>
                </ul>
              </div>
              <h3 class="no-margin">Rp <?=$income?></h3>
              MONEY IN
              
            </div>
          </div>
          <!-- /members online -->
        </div>
        <div class="col-lg-3">
          <!-- Members online -->
          <div class="panel bg-orange-400">
            <div class="panel-body">
              <div class="heading-elements">
                <ul class="icons-list">
                  <li><i style="font-size:18pt" class="icon-cash3"></i></li>
                </ul>
              </div>
              <h3 class="no-margin">Rp <?=$transactions?></h3>
              TOTAL TRANSACTION              
            </div>
          </div>
          <!-- /members online -->
        </div>
        <div class="col-lg-3">
          <!-- Members online -->
          <div class="panel bg-purple-800">
            <div class="panel-body">
              <div class="heading-elements">
                <ul class="icons-list">
                  <li><i style="font-size:18pt" class=" icon-database-export"></i></li>
                </ul>
              </div>
              <h3 class="no-margin">Rp <?=$outcome?></h3>
              MONEY OUT              
            </div>
          </div>
          <!-- /members online -->
        </div>
      </div>
      <!-- /quick stats boxes -->
    </div>
  </div>
  <!-- /dashboard content -->

</div>
<!-- /content area -->


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
