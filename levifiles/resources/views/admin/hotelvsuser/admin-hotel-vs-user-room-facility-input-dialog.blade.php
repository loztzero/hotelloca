<div id="modal" class="cust-pop-up-sm travelo-box">
  <form method="POST" action="{{ url('admin/hotel-vs-user/save-room-facility') }}">

    <input type="hidden" value="{{ csrf_token() }}" name="_token">
    <input type="hidden" value="{{ Request::get('room') }}" name="room">
    <div class="row form-group">
      <div class="col-xs-12">
        <label>Facility *</label>
        <input type="text" name="facility[]" class="input-text full-width">
      </div>
      <div class="col-xs-12">
        <label>&nbsp;</label>
        <input type="text" name="facility[]" class="input-text full-width">
      </div>
      <div class="col-xs-12">
        <label>&nbsp;</label>
        <input type="text" name="facility[]" class="input-text full-width">
      </div>
      <div class="col-xs-12">
        <label>&nbsp;</label>
        <input type="text" name="facility[]" class="input-text full-width">
      </div>
      <div class="col-xs-12">
        <label>&nbsp;</label>
        <input type="text" name="facility[]" class="input-text full-width">
      </div>
    </div>

    <div class="row form-group">
      <div class="col-xs-12">
              <button type="submit" class="full-width">Add</button>
      </div>
    </div>

  </form>
</div>
