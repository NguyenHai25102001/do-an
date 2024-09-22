<div class="mt-3 border-bottom data-variant pb-3">
    <div class="row m-0">
        <div class="col-lg-3 p-1">
            <input type="text" name="variant[{{$count}}][name]" class="form-control" placeholder="Tên loại sản phẩm" required>
        </div>
        <div class="col-lg-2 p-1">
            <button type="button" class="btn btn-success btn-add-size form-control"><i class="bi bi-plus-lg"></i> Thêm Màu</button>
        </div>
        <div class="col-lg-3 p-1">
            <button type="button" class="btn btn-primary btn-add-color form-control"><i class="bi bi-plus-lg"></i>Thêm Loại Sản Phẩm</button>
        </div>
        <div class="col-lg-2 p-1">
            <button type="button" class="btn btn-danger btn-clear-color">
                <i class="bi bi-trash"></i> Xóa</button>
        </div>
    </div>
    <div class="list-size">
        <div class="row m-0 pb-1">
            <div class="col-lg-2 p-1 d-flex align-items-center" style="padding-left: 15px!important;">
                <p class="m-0">Thông tin  :</p>
            </div>
            <div class="col-lg-2 p-1">
                <input name="variant[{{$count}}][own_parameter]" type="text" class="form-control" placeholder="Bộ nhớ trong">
            </div>
            <div class="form-check form-switch col-lg-2 p-1">
                <input class="form-check-input" name="variant[{{$count}}][featured_products]" type="checkbox"
                       id="flexSwitchCheckChecked" style="margin-left: 0px!important;margin-top: 13px">
                <label class="form-check-label" for="flexSwitchCheckChecked" style="margin-top: 9px;margin-left: 8px">Sản phẩm nổi bật</label>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-header bg-info text-white">
                Thông số kỹ thuật
            </div>
            <div class="card-body mt-2" id="card_ckeditor_{{$count}}">
            </div>
        </div>
        <div class="row m-0">
            <div class="col-lg-3 p-1">
                <input type="text" name="variant[{{$count}}][data][0][color]" class="form-control" placeholder="Tên màu sản phẩm" required>
            </div>
            <div class="col-lg-3 p-1">
                <input name="variant[{{$count}}][data][0][price]" type="text" class="form-control price format-currency" placeholder="Gía gốc">
            </div>
            <div class="col-lg-3 p-1">
                <input name="variant[{{$count}}][data][0][promotion_price]" type="text" class="form-control promotion_price format-currency" placeholder="Gía bán">
            </div>
        </div>
    </div>
</div>
