<div class="modal fade" id="createMenu" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title user-create-update" id="exampleModalLabel">Thêm mới</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Tên <span
                            class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" required>
                </div>
                <div class="form-group">
                    <label for="message-text" class="col-form-label">Email <span
                            class="text-danger">*</span></label>
                    <input class="form-control" id="email" type="email" required>
                </div>
                <div class="form-group">
                    <label for="message-text" class="col-form-label">Mật khẩu (Tối đa 8 ký tự) <span
                            class="text-danger">*</span></label>
                    <input class="form-control" id="password" type="password" maxlength="8" required>
                </div>
                <input type="text" id="user_id" hidden>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" id="submitCreateMenu" style="display: none">Xác nhận</button>
                <button type="button" class="btn btn-primary" id="submitUpdateMenu" style="display: none">Xác nhận</button>
            </div>
        </div>
    </div>
</div>

