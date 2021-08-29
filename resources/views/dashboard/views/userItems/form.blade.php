<div class="form-group">
    <label for="cat_id" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label   d-flex">{{__("dashboard.Categories")}}</label>
    <div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">
        <select id="cat_id" name="category_id"   class="form-control"  style="width: 120%">
            <option>
                {{('')==('Choose Categories')}}

            </option>
            @foreach($categories as $category)
                <option
                    @if(isset($item) &&$category->id == $item->cat_id)
                    selected
                    @endif
                    value="{{$category->id}}"> {{$category->name}}
                </option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-group">
    <label for="item_id" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label   d-flex">{{__("dashboard.Items")}}</label>
    <div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">
        <select id="item_id" name="item_id" class="form-control" style="width: 120%">
            <option>
                {{('')==('Choose Items')}}

            </option>
            @foreach($item_id as $it)
                <option
                    @if(isset($item) &&$it->id == $item->item_id)
                    selected
                    @endif
                    value="{{$it->id}}"> {{$it->name}}
                </option>
            @endforeach
        </select>
    </div>
</div>
<script >
    $(function() {
        $('#cat_id').on('change', function () {
            var val = $(this).val();
            console.log(val);
            $.ajax({
                url: '{{route('admin.userItems.ajax',App::getLocale())}}',
                dataType: 'html',
                data: {cat_id: val},
                success: function (data) {
                    $('#item_id').html(data);
                }
            });
        });
    });
</script>
