<div class="form-group">
    <label for="name" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label">{{__("dashboard.Name")}}</label>
    <div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">
        {!!Form::text('name', null, array('required', 'id' => 'name', 'placeholder'=>__('dashboard.Name'), 'class'=>'form-control','style'=>'width: 120%'))!!}
    </div>
</div>

<div class="form-group">
    <label for="img_link" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label  d-flex">{{__('dashboard.Image')}}</label>
    <div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">
        {!!Form::file('img_link', array('id' => 'img_link', 'class'=>'form-control','style'=>'width: 120%', isset($item) ? '' : 'required'))!!}
    </div>
</div>

<div class="form-group">
    <label for="amount" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label  d-flex">{{__("dashboard.Amount")}}</label>
    <div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">
        {!!Form::number('amount', null, array( 'id' => 'special_id', 'placeholder'=>__('dashboard.Amount'), 'class'=>'form-control','style'=>'width: 120%'))!!}
    </div>
</div>

<div class="form-group">
    <label for="desc" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label  d-flex">{{__("dashboard.Description")}}</label>
    <div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">
        {!!Form::textarea('desc', null, array( 'id' => 'desc', 'placeholder'=>__('dashboard.Description'), 'class'=>'form-control','style'=>'width: 120%'))!!}
    </div>
</div>
