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


