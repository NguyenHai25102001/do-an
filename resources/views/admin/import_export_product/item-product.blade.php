@foreach($listData as $key => $value)
    <tr class="text-center" style="border-top: 2px solid #e8e8e8">
        <td>
            <img class="" style="width: 50px; height: auto"
                 src="{{$value->infor->image}}">
        </td>
        <td style="padding-top: 20px">{{$value->product->name}}</td>
        <td style="padding-top: 20px">{{$value->name}}</td>
        <td style="padding-top: 20px">{{$value->quantity}}</td>
        <td style="padding-top: 20px">
            <button type="button" class="btn btn-success" onclick="idSP({{$value->id}})"><i class="fa fa-plus" aria-hidden="true"></i></button>
        </td>
    </tr>
@endforeach
