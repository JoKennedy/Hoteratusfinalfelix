<div class="contact-compose-sidebar other" style="width: 80%">
  <div class="card quill-wrapper">
    <div class="card-content pt-0">
      <div class="card-header display-flex pb-2">
        <h3 class="card-title contact-title-label" id="Titleother"></h3>
        <div class="close close-icon">
          <i  class="material-icons closemodal">close</i>
        </div>
      </div>
      <div class="divider"></div>
      <!-- form start -->
      <form id="otherdata" class="edit-contact-item mb-5 mt-5 mr-5" method="POST">
        @csrf
        <input type="hidden" name="othercategory" id="othercategory">
        <input type="hidden" name="othercategoryid" id="othercategoryid">
        <input type="hidden" name="otherroomtypeid" id="otherroomtypeid">
        <input type="hidden" name="otheroption" id="otheroption">
        <input type="hidden" name="othertype" id="othertype">
        <input type="hidden" name="otherid" id="otherid">
        <div class="row">
            <table id="policies" class="table">
                <thead>
                    <th></th>
                    <th>Title</th>
                    <th>Description</th>
                    <th class="action">Action</th>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
        <br>
        <div class="row s12 center">
            <button id="savebutton" type="button" onclick="saveOther()" class="mb-6 btn waves-effect waves-light gradient-45deg-green-teal" >Save </button>
            <a  class="mb-6 btn waves-effect waves-light gradient-45deg-purple-deep-orange closemodal">Close</a>
        </div>
      </form>
    </div>
  </div>
</div>

