<div class="row m-0">
    <div class="col-lg-3 p-1">
        <input type="text" name="variant[{{$index}}][data][{{$count}}][color]" required class="form-control" placeholder="Tên màu sản phẩm">
    </div>
    <div class="col-lg-3 p-1">
        <input name="variant[{{$index}}][data][{{$count}}][price]" type="text" class="form-control price format-currency" placeholder="Gía gốc">
    </div>
    <div class="col-lg-3 p-1">
        <input name="variant[{{$index}}][data][{{$count}}][promotion_price]" type="text" class="form-control promotion_price format-currency" placeholder="Gía bán">
    </div>
    <div class="col-lg-2 p-1">
        <button type="button" class="btn btn-danger btn-clear-size">
            <i class="bi bi-trash"></i> Xóa</button>
    </div>
</div>
