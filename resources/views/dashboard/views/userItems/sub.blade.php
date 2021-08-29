<select id="item_id" name="item_id" class="form-control" >

    @foreach($item_id as $it)
        <option
            @if(isset($item) &&$it->id == $item->item_id)
            selected
            @endif
            value="{{$it->id}}"> {{$it->name}}
        </option>
    @endforeach
</select>
