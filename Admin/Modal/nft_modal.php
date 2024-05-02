<div class="modal fade" id="addnft">
        <div class="modal-dialog">
          <div class="modal-content">
          <center><h4 class="modal-title" style="padding-top: 10px;">Register Placement</h4></center>
            <div class="modal-body">
            <form id="plantForm" class="row g-3" method="POST" action="code.php">

            <div class="col-md-12">
                <label for="nft" class="form-label">Placement<span style="color: red;"> *</span></label>
                <input type="text" name="nft" id="nft" class="form-control" required>
            </div>

            </div>
            <div class="modal-footer d-flex justify-content-end align-items-center mt-3">
              <button type="button" class="btn btn-secondary" data-dismiss="modal" style="background-color: white; border: 1px solid #8f8f8f; border-radius: 4px; box-shadow: none; color: black;">Cancel</button>
              <button type="submit" class="btn btn-primary" name="add-nft-btn" style="background-color: #2C3090; box-shadow: none;">Register</button>
            </form>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
      </div>


<!-- Edit Modal -->
<div class="modal fade" id="editnft">
  <div class="modal-dialog">
    <div class="modal-content">
      <center><h4 class="modal-title" style="padding-top: 10px;">Placement</h4></center>
      <div class="modal-body">
        <form class="form-horizontal" method="POST" action="code.php">
          <input type="hidden" class="nftid" name="id">
          <div class="form-group">
            <label for="edit_nft" class="col-sm-3 control-label">Placement</label>
            <div class="col-sm-12">
              <input type="text" class="form-control" id="edit_nft" name="nft">
            </div>
          </div>
      </div>
      <div class="modal-footer d-flex justify-content-end align-items-center mt-3">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background-color: white; border: 1px solid #8f8f8f; border-radius: 4px; box-shadow: none; color: black;">Cancel</button>
        <button type="submit" class="btn btn-primary" name="edit-nft-btn" style="background-color: #2C3090; box-shadow: none;">Update</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deletenft">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <form class="form-horizontal" method="POST" action="code.php">
          <input type="hidden" class="nftid" name="id">
          <div class="text-center">
            <p>Are you sure you want to remove this placement</p>
            <h2 class="bold delete_nft" id="delete_nft_name" name="nft"></h2>
          </div>
      </div>
      <div class="modal-footer d-flex justify-content-end align-items-center mt-3">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background-color: white; border: 1px solid #8f8f8f; border-radius: 4px; box-shadow: none; color: black;">No</button>
        <button type="submit" class="btn btn-danger" name="delete-nft-btn" style="box-shadow: none;">Yes</button>
        </form>
      </div>
    </div>
  </div>
</div>
