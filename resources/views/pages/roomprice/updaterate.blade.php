<div class="contact-compose-sidebar rate">
  <div class="card quill-wrapper">
    <div class="card-content pt-0">
      <div class="card-header display-flex pb-2">
        <h3 id="headertitle" class="card-title contact-title-label"></h3>
        <div class="close close-icon">
          <i  class="material-icons closemodal">close</i>
        </div>
      </div>
      <div class="divider"></div>
      <!-- form start -->
      <form id="updaterate" class="edit-contact-item mb-5 mt-5" method="POST">
          @csrf
        <input type="hidden" id="category" name="category">
        <input type="hidden" id="RateTypeId" name="RateTypeId">
         <input type="hidden" id="categoryid" name="categoryid">
        <div class="row">
            <h6 style="text-align: center;">Low Weekdays</h6>
            <div class="col s4">
                <label for="deposit_amount">Base Occup.</label>
                <input onkeypress="return isNumberKey(event)" id="base_occupancy" name="base_occupancy"  type="text" >
            </div>
            <div class="col s4">
                <label for="deposit_amount">Extra Person</label>
                <input onkeypress="return isNumberKey(event)" id="extra_person" name="extra_person"  type="text" >
            </div><div class="col s4">
                <label for="deposit_amount">Extra Bed</label>
                <input onkeypress="return isNumberKey(event)" id="extra_bed" name="extra_bed"  type="text" >
            </div>
        </div>
        <div class="row">
            <h6 style="text-align: center;">Low Weekdays</h6>
            <div class="col s4">
                <label for="deposit_amount">Base Occup.</label>
                <input onkeypress="return isNumberKey(event)" id="base_occupancy_high" name="base_occupancy_high"  type="text" >
            </div>
            <div class="col s4">
                <label for="deposit_amount">Extra Person</label>
                <input onkeypress="return isNumberKey(event)" id="extra_person_high" name="extra_person_high"  type="text" >
            </div><div class="col s4">
                <label for="deposit_amount">Extra Bed</label>
                <input onkeypress="return isNumberKey(event)" id="extra_bed_high" name="extra_bed_high"  type="text" >
            </div>
        </div>
        <div class="row publishon">
            <h6 style="text-align: center;">Publish On</h6>
            <div class="col s4">
                <label for="web">Web</label>
               <input style="opacity:1; pointer-events: all;  position: relative;" name="web" id="web"  type="checkbox" />
            </div>
            <div class="col s4">
                <label for="corp">Corporate</label>
               <input style="opacity:1; pointer-events: all;  position: relative;" name="corp" id="corp"  type="checkbox" />
            </div><div class="col s4">
                <label for="agent">Agent</label>
               <input style="opacity:1; pointer-events: all;  position: relative;" name="agent" id="agent"  type="checkbox" />
            </div>
        </div>
        <br>
        <div class="row s12 center">
            <button type="button" onclick="saveRate()"  class="mb-6 btn waves-effect waves-light gradient-45deg-green-teal" >Update </button>
            <a  class="mb-6 btn waves-effect waves-light gradient-45deg-purple-deep-orange closemodal">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</div>

