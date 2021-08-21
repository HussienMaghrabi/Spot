@if($iid == 'name')
    <div class="form-group">
        <label for="name" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label">{{__("dashboard.Name")}}</label>
        <div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">
            {!!Form::text('name', null, array('required', 'id' => 'name', 'placeholder'=>__('dashboard.Name'), 'class'=>'form-control','style'=>'width: 120%'))!!}
        </div>
    </div>
@endif
@if($iid == 'special_id')
    @if( Auth::guard('admin')->user()->super == 1)

        <div class="form-group">
            <label for="special_id" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label">{{__("dashboard.Special")}}</label>
            <div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">
                {!!Form::text('special_id', null, array( 'id' => 'special_id', 'placeholder'=>__('dashboard.Special'), 'class'=>'form-control','style'=>'width: 120%'))!!}
            </div>
        </div>
    @endif
@endif

@if($iid == 'gender')
    <div class="form-group">
        <label for="gender" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label">{{__("dashboard.Gender")}}</label>
        <div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">
            <select id="status" name="gender" class="form-control" style="width: 120%">
                @if(isset($item))
                    <option
                        selected
                        value="{{$item->gender}}"> {{__("dashboard.".$item->gender)}}
                    </option>
                    @if($item->gender == 'Male')
                        <option value="Female"> {{__("dashboard.Female")}}</option>
                    @else
                        <option value="Male"> {{__("dashboard.Male")}}</option>
                    @endif
                @endif
            </select>
        </div>
    </div>
@endif
