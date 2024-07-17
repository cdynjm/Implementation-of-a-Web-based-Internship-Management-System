<!-- The Modal -->
<div class="modal fade" id="resetPasswordModal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reset your password</h5>
                <button type="button" class="btn-close bg-dark" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body text-center">
                    <form action="" id="reset-user-password">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <p class="fw-bolder">Your Credentials</p>
                                <p class="text-sm">
                                    We will send a code to your registered gmail account to reset your password.
                                </p>
                            </div>

                            <div class="col-md-12 mb-2 text-start" id="email">
                                <label for="">E-mail</label>
                                <input type="text" class="form-control" id="reset-email" name="email">
                            </div>

                            <div class="col-md-12 mb-2 text-start" id="code" style="display: none;">
                                <label for="">Reset Code</label>
                                <input type="text" class="form-control" id="reset-code" name="code">
                            </div>

                            <div class="col-md-12 mb-2 text-start" id="password" style="display: none;">
                                <label for="">New Password</label>
                                <input type="text" class="form-control" name="password" required>
                            </div>
                    
                            <div class="justify-content-center mt-2" id="send-code-btn">
                                <button type="button" id="send-code" class="btn btn-sm bg-gradient-info">Send Code</button>
                            </div>

                            <div class="justify-content-center mt-2" id="reset-code-btn" style="display: none;">
                                <button type="button" id="reset-code-password" class="btn btn-sm bg-gradient-info">Reset</button>
                            </div>

                            <div class="justify-content-center mt-2" id="change-password-btn" style="display: none;">
                                <button type="submit" class="btn btn-sm bg-gradient-info">Change Password</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> 