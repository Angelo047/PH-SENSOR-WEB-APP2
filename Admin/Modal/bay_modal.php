<div class="modal fade" id="addbay">
        <div class="modal-dialog">
          <div class="modal-content">
            <center><h4 class="modal-title" style="padding-top: 10px;">Register Bay and Placement</h4></center>
            <div class="modal-body">
            <form id="plantForm" class="row g-3" method="POST" action="code.php" enctype="multipart/form-data">

            <div class="col-md-12">
                <label for="bay" class="form-label">Bay<span style="color: red;"> *</span></label>
                <input type="text" name="bay" id="bay" class="form-control" required>
            </div>


            <div class="col-md-12">
                <label for="bay" class="form-label">Placement<span style="color: red;"> *</span></label>
                <input type="text" name="placement" id="placement" class="form-control" required>
            </div>

            </div>
            <div class="modal-footer d-flex justify-content-end align-items-center mt-3">
             <button type="button" class="btn btn-secondary" data-dismiss="modal" style="background-color: white; border: 1px solid #8f8f8f; border-radius: 4px; box-shadow: none; color: black;">Cancel</button>
              <button type="submit" class="btn btn-primary" name="add-bay-btn" style="background-color: #3f51b5; box-shadow: none;">
               Register
              </button>
            </form>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->


      <!-- Edit Modal -->
<div class="modal fade" id="editbay">
  <div class="modal-dialog">
    <div class="modal-content">
      <center><h4 class="modal-title" style="padding-top: 10px;">Edit Bay and Placement</h4></center>
      <div class="modal-body">
        <form class="form-horizontal" method="POST" action="code.php">
          <input type="hidden" class="bayid" name="id">
          <div class="form-group">
            <label for="edit_bay" class="col-sm-3 control-label">Bay</label>
            <div class="col-sm-12">
              <input type="text" class="form-control" id="edit_bay" name="bay">
            </div>
            <label for="edit_placement" class="col-sm-3 control-label">Placement</label>
            <div class="col-sm-12">
              <input type="text" class="form-control" id="edit_placement" name="placement">
            </div>

          </div>
        </div>
        <div class="modal-footer d-flex justify-content-end align-items-center mt-3">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background-color: white; border: 1px solid #8f8f8f; border-radius: 4px; box-shadow: none; color: black;">Cancel</button>
          <button type="submit" class="btn btn-primary" name="edit-bay-btn" style="background-color: #3f51b5; box-shadow: none;">Update</button>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- Delete Modal -->
<div class="modal fade" id="deletebay">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <form class="form-horizontal" method="POST" action="code.php">
          <input type="hidden" class="bayid" name="id">
          <div class="text-center">
          <p>Are you sure you want to delete this bay and placement?</p>
            <h2 class="bold delete_bay" id="delete_bay_name" name="bay"></h2>
          </div>
      </div>
      <div class="modal-footer d-flex justify-content-end align-items-center mt-3">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background-color: white; border: 1px solid #8f8f8f; border-radius: 4px; box-shadow: none; color: black;">No</button>
        <button type="submit" class="btn btn-danger" name="delete-bay-btn" style="box-shadow: none;">Yes</button>
        </form>
      </div>
    </div>
  </div>
</div>

