<div class="form-group">
    <label for="special_id" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label d-flex" >{{__("dashboard.Special")}}</label>
    <div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">
        {!!Form::text('special_id', null, array( 'id' => 'special_id', 'placeholder'=>__('dashboard.Special'), 'class'=>'form-control','style'=>'width: 120%'))!!}
    </div>
</div>

<div class="form-group">
    <label class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label d-flex" >{{__("dashboard.OR")}}</label>
</div>

<div class="form-group">
    <label for="email" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label d-flex">{{__("dashboard.Email")}}</label>
    <div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">
        {!!Form::text('email', null, array( 'id' => 'email', 'placeholder'=>__('dashboard.Email'), 'class'=>'form-control','style'=>'width: 120%'))!!}
    </div>
</div>


<div class="form-group">
    <label class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label d-flex" >{{__("dashboard.OR")}}</label>
</div>

<div class="form-group">
    <label for="mobile_id" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label d-flex">{{__("dashboard.MobileId")}}</label>
    <div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">
        {!!Form::text('mobile_id', null, array( 'id' => 'mobile_id', 'placeholder'=>__('dashboard.MobileId'), 'class'=>'form-control','style'=>'width: 120%'))!!}
    </div>
</div>



<div class="form-group">
    <label for="desc" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label  d-flex">{{__("dashboard.Description")}}</label>
    <div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">
        {!!Form::textarea('desc', null, array( 'id' => 'desc', 'placeholder'=>__('dashboard.Description'), 'class'=>'form-control','style'=>'width: 120%'))!!}
    </div>
</div>
