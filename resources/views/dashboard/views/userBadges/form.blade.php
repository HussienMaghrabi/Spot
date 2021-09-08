<div class="form-group">
    <label for="badge_id" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label  d-flex">{{__("dashboard.Badges")}}</label>
    <div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">
        {!!Form::select('badge_id', $badges, null, array('required', 'id' => 'badge_id', 'placeholder'=>__('dashboard.Badges'), 'class'=>'form-control','style'=>'width: 120%'))!!}
    </div>
</div>
