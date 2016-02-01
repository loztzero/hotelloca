<div id="modal" class="cust-pop-up-sm travelo-box">
  <form method="POST" action="{{ url('hotel/room-facility/save') }}">

    <input type="hidden" value="{{ $room->id }}" name="room_id">
    <input type="hidden" value="{{ csrf_token() }}" name="_token">
    <div class="row form-group">
      <div class="col-xs-12">
        <label>Facility *</label>
        <input type="text" name="facility" class="input-text full-width">
      </div>
    </div>

    <div class="row form-group">
      <div class="col-xs-12">
              <button type="submit" class="full-width">Add</button>
      </div>
    </div>

      </form>
</div>