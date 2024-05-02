<style>
    /* Custom CSS to center modal titles */
    .modal-header .modal-title {
        width: 100%;
        text-align: center;
    }

     /* Custom CSS for input boxes */
     .form-control {
        border-radius: 10px; /* Add rounded borders */
        border: 1px solid #ced4da; /* Add border */
    }

    /* Adjust spacing between input boxes */
    .modal-body .form-group {
        margin-bottom: 20px;
    }

    .btn-primary {
        background-color: #2C3090;
        border-color: #2C3090; /* Optional: If you want to change the border color */
    }

    .btn-primary:hover {
        background-color: #1d1f6d; /* Optional: Change the color on hover */
        border-color: #1d1f6d; /* Optional: Change the border color on hover */
    }

    .ph-level-input {
    margin-left: 10px;
}

.full-width-input {
        width: 105%;
    }
</style>

<div class="modal fade" id="addplantsdetails">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Register Plant
                </h4>
            </div>
            <div class="modal-body">
                <form id="plantForm" class="row g-6s" method="POST" action="code.php" enctype="multipart/form-data">

                    <div class="col-md-12 mt-1">
                        <label for="plant_name">Name of Plant</label>
                        <input type="text" name="plant_name" id="plant_name" class="form-control" placeholder="" required>
                    </div>

                    <div class="row">


                        <div class="col-md-6 mt-3"> <!-- Adjusted width and margin -->
                            <label for="pHLevelLow">Lowest pH Level</label>
                            <input type="number" step="0.1" name="ph_lvl_low" class="form-control full-width-input" id="ph_lvl_low"
                                placeholder="" style="margin-right: 10px;" required>
                        </div>

                        <div class="col-md-6 mt-3"> <!-- Adjusted width and margin -->
                            <label for="pHLevelHigh">Highest pH Level</label>
                            <input type="number" step="0.1" name="ph_lvl_high" class="form-control full-width-input" id="ph_lvl_high"
                                placeholder="" style="margin-left: 10px;" required>
                        </div>
                    </div>

                    <div class="col-md-12 mt-3">
                        <label for="days_harvest">Days before Harvest</label>
                        <input type="number" name="days_harvest" id="days_harvest" class="form-control" placeholder="" required>
                    </div>

            </div>
            <div class="modal-footer justify-content-end mt-3">
                <form id="plantForm" method="POST" action="code.php" enctype="multipart/form-data" class="d-flex">
                    <!-- Move the buttons to the right side using flexbox -->
                    <div class="ms-auto">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background-color: white; border: 1px solid #8f8f8f; border-radius: 4px; box-shadow: none; color: black;">Cancel</button>
                        <button type="submit" class="btn btn" name="add-plant-details-btn" style="background-color: #2C3090; color:white;">
                            Register
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Edit Modal -->
<div class="modal fade" id="editplant">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Plant Details</h4>

                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="code.php">
                    <input type="hidden" class="plantid" name="id">
                    <div class="form-group">
                        <label for="edit_plant" class="col-sm-6s control-label" style="margin-left: 10px;">Name of Plant</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="plant_name" name="plant_name" required>
                        </div>

                    <div class="row">

                        <div class="col-md-6 mt-3"> <!-- Adjusted margin and added a new row -->
                            <label for="pHLevelLow" style="margin-left: 10px;">Lowest pH Level</label>
                            <input type="number" step="0.1" class="form-control ph-level-input" id="ph_lvl_low" name="ph_lvl_low" placeholder="" style="width: 96%;" required>
                        </div>
                        <div class="col-md-6 mt-3"> <!-- Adjusted margin and added a new row -->
                            <label for="pHLevelHigh" style="margin-left: 10px;">Highest pH Level</label>
                            <input type="number" step="0.1" class="form-control " id="ph_lvl_high" name="ph_lvl_high" placeholder="" style="width: 96%;" required>
                        </div>
                    </div>

                    <div class="form-group"style="padding-top: 15px;">
                        <label for="days_harvest" class="col-sm-6s control-label" style="margin-left: 10px;">Days before Harvest</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="days_harvest" name="days_harvest" required>
                        </div>
                    </div>
            <div class="modal-footer justify-content-end mt-3">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background-color: white; border: 1px solid #8f8f8f; border-radius: 4px; box-shadow: none; color: black;">Cancel</button>
                <button type="submit" class="btn btn" name="edit-plant-details-btn" style="background-color: #2C3090; color:white;">Update</button>
                </form>
            </div>
        </div>
    </div>
</div></div>
</div>


<!-- Delete Modal -->
<div class="modal fade" id="deleteplant">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="code.php">
                    <input type="hidden" class="plantid" name="id">
                    <div class="text-center">
                        <p>Are you sure you want to delete this plant?</p>
                        <h2 class="bold delete_plant" id="delete_plant_name" name="plant_name"></h2>
                    </div>
            </div>
            <div class="modal-footer justify-content-between mt-3">
    <div class="ml-auto"> <!-- Use ml-auto to push buttons to the right -->
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background-color: white; border: 1px solid #8f8f8f; border-radius: 4px; box-shadow: none; color: black;">No</button>

        <button type="submit" class="btn btn-danger" name="delete-plant-btn">
           Yes
        </button>
                </form>
                </div>
              </div>
        </div>
    </div>
</div>