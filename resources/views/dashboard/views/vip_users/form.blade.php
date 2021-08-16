<div class="form-group">
    <label for="name" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label">{{__("dashboard.Name")}}</label>
    <div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">
        {!!Form::text('name', null, array('required', 'id' => 'name', 'placeholder'=>__('dashboard.Name'), 'class'=>'form-control','style'=>'width: 120%'))!!}
    </div>
</div>

<div class="form-group">
    <label for="email" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label">{{__("dashboard.Email")}}</label>
    <div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">
        {!!Form::text('email', null, array('required', 'id' => 'email', 'placeholder'=>__('dashboard.Email'), 'class'=>'form-control','style'=>'width: 120%'))!!}
    </div>
</div>

<div class="form-group">
    <label for="password" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label">{{__("dashboard.Password")}}</label>
    <div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">
        {!!Form::password('password', array(isset($item->password) ? '' : 'required', 'id' => 'password', 'placeholder'=>__('dashboard.Password'), 'class'=>'form-control','style'=>'width: 120%'))!!}
    </div>
</div>
@if( Auth::guard('admin')->user()->super == 1)

    <div class="form-group">
        <label for="special_id" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label">{{__("dashboard.Special")}}</label>
        <div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">
            {!!Form::text('special_id', null, array( 'id' => 'special_id', 'placeholder'=>__('dashboard.Special'), 'class'=>'form-control','style'=>'width: 120%'))!!}
        </div>
    </div>

@endif

<div class="form-group">
    <label for="profile_pic" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label">{{__('dashboard.Image')}}</label>
    <div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">
        {!!Form::file('profile_pic', array('id' => 'profile_pic', 'class'=>'form-control','style'=>'width: 120%', isset($item) ? '' : 'required'))!!}
    </div>
</div>

<div class="form-group">
    <label for="gender" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label">{{__("dashboard.Gender")}}</label>
    <div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">
        <select id="status" name="gender" class="form-control" style="width: 120%">
            @if(isset($item))
                <option
                    selected
                    value="{{$item->gender}}"> {{$item->gender}}
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
