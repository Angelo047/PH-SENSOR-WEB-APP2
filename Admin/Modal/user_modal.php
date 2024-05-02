
<!-- Add -->
<div class="modal fade" id="addnew">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><b>Add New User</b></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="code.php">
                    <div class="form-group mb-3">
                        <label for="full-name">Full Name <span style="color: red;">*</span></label>
                        <input type="text" id="full-name" name="full-name" placeholder="Jhon Doe" class="form-control" required>
                    </div>
                    <!-- <div class="form-group mb-3">
                        <label for="phone">Phone Number <span style="color: red;">*</span></label>
                        <input type="text" id="phone" name="phone" placeholder="+91" class="form-control" pattern="^\d{10}$" title="Please enter a 10-digit phone number" required>
                    </div> -->
                    <div class="form-group mb-3">
                        <label for="email">Email Address <span style="color: red;">*</span></label>
                        <input type="email" id="email" name="email" placeholder="@gmail.com" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="role_as">User Role <span style="color: red;">*</span></label>
                        <select id="role_as" name="role_as" class="form-control" required>
                            <option value="">-Select Role-</option>
                            <option value="admin">Admin</option>
                            <option value="gardener">Staff</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="password">Password <span style="color: red;">*</span></label>
                        <input type="password" id="password" name="password" placeholder="********" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="confirm_password">Confirm Password <span style="color: red;">*</span></label>
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="********" class="form-control" required>
                        <div id="password_match" class="text-muted">
                            <span id="retypePasswordError" class="text-danger" style="display: none;">Passwords do not match.</span>
                            <span id="retypePasswordSuccess" class="text-success" style="display: none;">Passwords match.</span>
                        </div>
                    </div>
                    <div id="password_error" class="text-danger"></div>
                </div>
                <div class="modal-footer  justify-content-end mt-3">
                <button type="button" class="btn btn-secondary" data-mdb-ripple-init data-dismiss="modal" style="background-color: white; border: 1px solid #8f8f8f; border-radius: 10px; box-shadow: none; color: black;">Cancel
                    <button type="submit" class="btn btn" style="background-color: #2C3090; color:white;" name="register-btn">
                     Add User
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>



<!-- Edit Modal -->
<div class="modal fade" id="edituser">
    <div class="modal-dialog">
        <div class="modal-content">
        <center><h4 class="modal-title" style="padding-top: 10px;">Edit User Details</h4></center>
            <div class="modal-body">
                <form id="editUserForm" class="form-horizontal" method="POST" enctype="multipart/form-data">
                    <input type="hidden" class="userid" name="id">
                    <!-- <div class="form-group">
                        <label for="full-name" class="col-sm-6 control-label">Full Name <span style="color: red;">*</span></label>
                        <div class="col-sm-12">
                            <input type="text" id="full-name" name="full-name" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-sm-6 control-label">Email Address <span style="color: red;">*</span></label>
                        <div class="col-sm-12">
                            <input type="email" id="email" name="email" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="phone" class="col-sm-6 control-label">Phone Number <span style="color: red;">*</span></label>
                        <div class="col-sm-12">
                            <input type="text" id="phone" name="phone" class="form-control">
                        </div>
                    </div> -->
                    <div class="form-group">
                        <label for="role_as" class="col-sm-6 control-label">User Role <span style="color: red;">*</span></label>
                        <div class="col-sm-12">
                            <select id="role_as" name="role_as" class="form-control">
                                <option value="admin">Admin</option>
                                <option value="gardener">Staff</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="status" class="col-sm-6 control-label">Status <span style="color: red;">*</span></label>
                        <div class="col-sm-12">
                            <select id="status" name="status" class="form-control">
                                <option value="true">Disabled</option>
                                <option value="false">Active</option>
                            </select>
                        </div>
                    </div>
            </div>
            <div class="modal-footer justify-content-end mt-3">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background-color: white; border: 1px solid #8f8f8f; border-radius: 4px; box-shadow: none; color: black;">Cancel</button>

                <button type="submit" class="btn btn" style="background-color: #2C3090; color:white;" name="edit-user-details-btn"> Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

  <!-- Delete Modal -->
<div class="modal fade" id="deleteuser">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <form id="deleteUserForm" method="POST" action="code.php">
                    <input type="hidden" class="userId" name="id">
                    <div class="text-center">
                        <p>Are you sure you want to delete this user account?</p>
                        <h2 class="bold" id="deleteUserName"></h2>
                    </div>
            </div>
            <div class="modal-footer justify-content-end mt-3">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background-color: white; border: 1px solid #8f8f8f; border-radius: 4px; box-shadow: none; color: black;">No</button>
                <button type="submit" class="btn btn-danger" name="delete-user-btn"> Yes</button>
                </form>
            </div>
        </div>
    </div>
</div>