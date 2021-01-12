<div class="contact-compose-sidebar web" >
  <div class="card quill-wrapper">
    <div class="card-content pt-0">
      <div class="card-header display-flex pb-2">
        <h3 class="card-title contact-title-label">Web Reservation Policy</h3>
        <div class="close close-icon">
          <i  class="material-icons closemodal">close</i>
        </div>
      </div>
      <div class="divider"></div>
      <!-- form start -->
      <form id="webdata" class="edit-contact-item mb-5 mt-5" method="POST">
          @csrf
        <div class="row">
          <div class="input-field col s12 p-0">

            <select onchange="optional()" class="browser-default" name="web_policy_type_id" id="web_policy_type_id">
                @foreach ($webPolicyTypes as $item)
                    <option  value="{{$item->id}}">{{$item->name}}</option>
                @endforeach
            </select>

            <div id="web_policy_type_id_error" class="validaciones">
            </div>
          </div>
        </div>
        <div class="row optional">
            <label>
                <input onclick="depositType(1)" id="deposit_type1" name="deposit_type[]" value="1" name="type" type="radio"  />
                <span>Deposit</span>
            </label>
            <label>
                <input onclick="depositType(2)" id="deposit_type2"  name="deposit_type[]"  value="2" name="type" type="radio"  />
                <span>As Per Booking Policy</span>
            </label>
        </div>
         <div class="row optional deposit">
            <label for="deposit_amount">Value</label>
            <div class="input-field col s12">
                <input onkeypress="return isNumberKey(event)" id="deposit_amount" name="deposit_amount"  type="text" >
                <div id="accounterrorscode" class="validaciones"></div>
            </div>
        </div>
        <div class="row optional deposit">
            <label>
                <input  value="1" name="value_type[]" id="value_type1" type="radio"  />
                <span><i  class="material-icons">%</i></span>
            </label>
            <label>
                <input value="2" name="value_type[]" id="value_type2" type="radio"  />
                <span><i  class="material-icons">attach_money</i></span>
            </label>
        </div>
        <input type="hidden" name="webid" id="webid">
        <div class="row s12 center">
            <button type="button" onclick="saveWeb()" class="mb-6 btn waves-effect waves-light gradient-45deg-green-teal" >Save </button>
            <a  class="mb-6 btn waves-effect waves-light gradient-45deg-purple-deep-orange closemodal">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</div>

