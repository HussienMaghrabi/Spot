<div class="form-group">
    <label for="title" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label  d-flex">{{__("dashboard.Title")}}</label>
    <div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">
        {!!Form::text('title', null, array('required', 'id' => 'title', 'placeholder'=>__('dashboard.Title'), 'class'=>'form-control','style'=>'width: 120%'))!!}
    </div>
</div>

<div class="form-group">
    <label for="body" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label  d-flex">{{__("dashboard.Description")}}</label>
    <div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">
        {!!Form::textarea('body', null, array( 'id' => 'body', 'placeholder'=>__('dashboard.Description'), 'class'=>'form-control','style'=>'width: 120%'))!!}
    </div>
</div>
