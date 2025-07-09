<div class="modal fade" id="updateMenu" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title user-create-update" id="exampleModalLabel">Chỉnh sửa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Menu cha</label>
                    <select class="form-control select2" style="width: 100%;" id="parent_id" name="parent_id">

                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Tên</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Nhập tên">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">URL</label>
                    <input type="text" class="form-control" id="url" name="url"
                           placeholder="Nhập URL">
                </div>
                <div class="form-group">
                    <label for="">Icon</label>
                    <input type="text" class="form-control" id="icon" name="icon" placeholder="Nhập icon">
                </div>
                <div class="form-group">
                    <label for="">Thứ tự</label>
                    <input type="text" class="form-control" id="display_order" name="display_order" placeholder="Nhập thứ tự">
                </div>
                <input type="text" id="menu_id" hidden>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" id="submitUpdateMenu">Xác nhận
                </button>
            </div>
        </div>
    </div>
</div>
