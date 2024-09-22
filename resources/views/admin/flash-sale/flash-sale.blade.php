@foreach($products as $key => $value)
    <tr class="text-center" style="border-top: 2px solid #e8e8e8">
        <td>
            <input type="text" name="sale[{{$key}}][product_id]" value="{{$value->id}}" hidden>
            <img class="" style="width: 50px; height: auto"
                 src="{{$value->infor->image}}">
        </td>
        <td style="padding-top: 20px">{{$value->name}}</td>

        <td style="padding-top: 20px"><input type="text" name="sale[{{$key}}][price_sale]" class="format-currency"></td>
        <td style="padding-top: 20px">
            <button type="button" class="btn btn-danger" onclick="deleteSP({{$value->id}})"><i class="fa fa-trash" aria-hidden="true"></i></button>
        </td>
    </tr>
@endforeach

