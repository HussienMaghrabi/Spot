@if($iid == 'name')
    <div class="form-group">
        <label for="name" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label">{{__("dashboard.Name")}}</label>
        <div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">
            {!!Form::text('name', null, array('required', 'id' => 'name', 'placeholder'=>__('dashboard.Name'), 'class'=>'form-control','style'=>'width: 120%'))!!}
        </div>
    </div>
@endif

@if($iid == 'image')
    <div class="form-group">
        <label for="main_image" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label">{{__('dashboard.Image')}}</label>
        <div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">
            {!!Form::file('main_image', array('id' => 'main_image', 'class'=>'form-control','style'=>'width: 120%', isset($item) ? '' : 'required'))!!}
        </div>
    </div>
@endif

@if($iid == 'pin')
    <div class="form-group">
        <label for="pin" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label  d-flex">{{__("dashboard.pinned")}}</label>
        <div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">
            <select id="pinned" name="pinned" class="form-control" style="width: 120%">
                @if(isset($item))
                    @if($item->pinned == 1)
                        <option
                            selected
                            value="{{$item->pinned}}"> {{__("dashboard.pinned")}}
                        </option>
                        <option value="2"> {{__("dashboard.unpinned")}}</option>
                    @else
                        <option
                            selected
                            value="{{$item->pinned}}"> {{__("dashboard.unpinned")}}
                        </option>
                        <option value="1"> {{__("dashboard.pinned")}}</option>
                    @endif
                @endif
            </select>
        </div>
    </div>
@endif

@if($iid == 'official')
    <div class="form-group">
        <label for="official" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label  d-flex">{{__("dashboard.official")}}</label>
        <div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">
            <select id="official" name="official" class="form-control" style="width: 120%">
                @if(isset($item))
                    @if($item->member->official == 1)
                        <option
                            selected
                            value="{{$item->member->official}}"> {{__("dashboard.official")}}
                        </option>
                        <option value="0"> {{__("dashboard.notOfficial")}}</option>
                    @else
                        <option
                            selected
                            value="{{$item->member->official}}"> {{__("dashboard.notOfficial")}}
                        </option>
                        <option value="1"> {{__("dashboard.official")}}</option>
                    @endif
                @endif
            </select>
        </div>
    </div>
@endif

@if($iid == 'trend')
    <div class="form-group">
        <label for="trend" class="{{App::getLocale() == 'ar' ? 'col-md-push-10' : ''}} col-sm-2 control-label  d-flex">{{__("dashboard.trend")}}</label>
        <div class="{{App::getLocale() == 'ar' ? 'col-md-pull-2' : ''}} col-sm-10">
            <select id="trend" name="trend" class="form-control" style="width: 120%">
                @if(isset($item))
                    @if($item->member->trend == 1)
                        <option
                            selected
                            value="{{$item->member->trend}}"> {{__("dashboard.trend")}}
                        </option>
                        <option value="0"> {{__("dashboard.notTrend")}}</option>
                    @else
                        <option
                            selected
                            value="{{$item->member->trend}}"> {{__("dashboard.notTrend")}}
                        </option>
                        <option value="1"> {{__("dashboard.trend")}}</option>
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
