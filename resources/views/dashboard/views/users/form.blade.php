@if($iid == 'name')
    <div class="form-group">
        <label for="name" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label  d-flex">{{__("dashboard.Name")}}</label>
        <div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">
            {!!Form::text('name', null, array('required', 'id' => 'name', 'placeholder'=>__('dashboard.Name'), 'class'=>'form-control','style'=>'width: 120%'))!!}
        </div>
    </div>
@endif

@if($iid == 'special_id')
    @if( Auth::guard('admin')->user()->super == 1)

        <div class="form-group">
            <label for="special_id" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label  d-flex">{{__("dashboard.Special")}}</label>
            <div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">
                {!!Form::text('special_id', null, array( 'id' => 'special_id', 'placeholder'=>__('dashboard.Special'), 'class'=>'form-control','style'=>'width: 120%'))!!}
            </div>
        </div>
    @endif
@endif

@if($iid == 'recharge_no_level')
    @if( Auth::guard('admin')->user()->super == 1)

        <div class="form-group">
            <label for="amount" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label  d-flex">{{__("dashboard.Amount")}}</label>
            <div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">
                {!!Form::number('amount', null, array( 'id' => 'special_id', 'placeholder'=>__('dashboard.Amount'), 'class'=>'form-control','style'=>'width: 120%'))!!}
            </div>
        </div>
    @endif
@endif

@if($iid == 'recharge_with_level')
    @if( Auth::guard('admin')->user()->super == 1)

        <div class="form-group">
            <label for="amount" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label  d-flex">{{__("dashboard.Amount")}}</label>
            <div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">
                {!!Form::number('amount', null, array( 'id' => 'special_id', 'placeholder'=>__('dashboard.Amount'), 'class'=>'form-control','style'=>'width: 120%'))!!}
            </div>
        </div>
    @endif
@endif

@if($iid == 'reduce_coins')
    @if( Auth::guard('admin')->user()->super == 1)

        <div class="form-group">
            <label for="amount" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label  d-flex">{{__("dashboard.Amount")}}</label>
            <div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">
                {!!Form::number('amount', null, array( 'id' => 'special_id', 'placeholder'=>__('dashboard.Amount'), 'class'=>'form-control','style'=>'width: 120%'))!!}
            </div>
        </div>
    @endif
@endif

@if($iid == 'reduce_diamond')
    @if( Auth::guard('admin')->user()->super == 1)

        <div class="form-group">
            <label for="amount" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label  d-flex">{{__("dashboard.Amount")}}</label>
            <div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">
                {!!Form::number('amount', null, array( 'id' => 'special_id', 'placeholder'=>__('dashboard.Amount'), 'class'=>'form-control','style'=>'width: 120%'))!!}
            </div>
        </div>
    @endif
@endif

@if($iid == 'image')
    <div class="form-group">
        <label for="profile_pic" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label  d-flex">{{__('dashboard.Image')}}</label>
        <div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">
            {!!Form::file('profile_pic', array('id' => 'profile_pic', 'class'=>'form-control','style'=>'width: 120%', isset($item) ? '' : 'required'))!!}
        </div>
    </div>
@endif

@if($iid == 'vip_role')


    <div class="form-group">
        <label for="vip_id" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label  d-flex">{{__("dashboard.vip_role")}}</label>
        <div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">
            {!!Form::select('vip_id', $vip, null, array('required', 'id' => 'vip_id', 'placeholder'=>__('dashboard.vip_role'), 'class'=>'form-control','style'=>'width: 120%'))!!}
        </div>
    </div>
@endif

@if($iid == 'gender')
    <div class="form-group">
        <label for="gender" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label  d-flex">{{__("dashboard.Gender")}}</label>
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



<div class="form-group">
    <label for="desc" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label  d-flex">{{__("dashboard.Description")}}</label>
    <div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">
        {!!Form::textarea('desc', null, array( 'id' => 'desc', 'placeholder'=>__('dashboard.Description'), 'class'=>'form-control','style'=>'width: 120%'))!!}
    </div>
</div>
