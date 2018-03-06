<div class="col s12">
  <div class="row">
    <div class="col s12 m6 l12">
      <div class="row margin">
        <div class="input-field col l3 s12">
          <i class="material-icons prefix pt-5">date_range</i>
          <input id="datecash" value="<?=$date?>" name="date" type="text" class="datepicker" required>
        </div>
        <div class="input-field col l3 s12">
          <i class="material-icons prefix pt-5">date_range</i>
          <input id="datecash2" value="<?=$date2?>" name="date" type="text" class="datepicker" required>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col s12 m6 l3">
      <div class="card gradient-shadow gradient-45deg-light-blue-cyan border-radius-3 white-text">
        <div class="padding-4">
          <div class="col s12 m12 center-align">
            <i class="material-icons background-round mt-5">credit_card</i>
          </div>
          <div class="col s12 m12 center-align">
            <h6 class="mb-0">TOTAL BALANCE</h6>
            <h6 class="mb-0">Rp <?=$balance?></h6><br>
          </div>
        </div>
      </div>
    </div>
    <div class="col s12 m6 l3">
      <div class="card gradient-shadow gradient-45deg-green-teal gradient-shadow min-height-100 white-text">
        <div class="padding-4">
          <div class="col s12 m12 center-align">
            <i class="material-icons background-round mt-5">compare_arrows</i>
          </div>
          <div class="col s12 m12 center-align">
            <h6 class="mb-0">Money In</h6>
            <h6 class="mb-0" id="money_in">Rp <?=$income?></h6><br>
          </div>
        </div>
      </div>
    </div>
    <div class="col s12 m6 l3">
      <div class="card gradient-45deg-blue-indigo gradient-shadow min-height-100 white-text">
        <div class="padding-4">
          <div class="col s12 m12 center-align">
            <i class="material-icons background-round mt-5">swap_horiz</i>
          </div>
          <div class="col s12 m12 center-align">
            <h6 class="mb-0">Total Transactions</h6>
            <h6 class="mb-0" id="total_transaction"><?=$transactions?></h6><br>
          </div>
        </div>
      </div>
    </div>
    <div class="col s12 m6 l3">
      <div class="card gradient-shadow gradient-45deg-amber-amber border-radius-3 white-text">
        <div class="padding-4">
          <div class="col s12 m12 center-align">
            <i class="material-icons background-round mt-5">developer_mode</i>
          </div>
          <div class="col s12 m12 center-align">
            <h6 class="mb-0">Money Out</h6>
            <h6 class="mb-0">Rp <span id="money_out"><?=$outcome?></span></h6><br>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

