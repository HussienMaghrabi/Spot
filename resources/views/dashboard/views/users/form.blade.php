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
    @if( Auth::guard('admin')->user()->super == 1)
        <div class="form-group">
            <label for="vip_role" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label  d-flex">{{__("dashboard.vip_role")}}</label>
            <div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">
                {!!Form::select('vip_role', $vip, null, array('required', 'id' => 'vip_role', 'placeholder'=>__('dashboard.vip_role'), 'class'=>'form-control','style'=>'width: 120%'))!!}
            </div>
        </div>
    @endif
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

@if($iid == 'freeze')
    <div class="form-group">
        <label for="freeze" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label  d-flex">{{__("dashboard.Freeze")}}</label>
        <div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">
            <select id="freeze" name="freeze" class="form-control" style="width: 120%">
                @if(isset($item))
                    @if($item->freeze_gems == 1)
                        <option
                            selected
                            value="{{$item->freeze_gems}}"> {{__("dashboard.Freeze")}}
                        </option>
                        <option value="0"> {{__("dashboard.notFreeze")}}</option>
                    @else
                        <option
                            selected
                            value="{{$item->freeze_gems}}"> {{__("dashboard.notFreeze")}}
                        </option>
                        <option value="1"> {{__("dashboard.Freeze")}}</option>
                    @endif
                @endif
            </select>
        </div>
    </div>
@endif

@if($iid == 'ranking')
    <div class="form-group">
        <label for="ranking" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label  d-flex">{{__("dashboard.Ranking")}}</label>
        <div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">
            <select id="ranking" name="ranking" class="form-control" style="width: 120%">
                @if(isset($item))
                    @if($item->ranking == 1)
                        <option
                            selected
                            value="{{$item->ranking}}"> {{__("dashboard.Ranking")}}
                        </option>
                        <option value="0"> {{__("dashboard.noRanking")}}</option>
                    @else
                        <option
                            selected
                            value="{{$item->freeze_gems}}"> {{__("dashboard.noRanking")}}
                        </option>
                        <option value="1"> {{__("dashboard.Ranking")}}</option>
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
