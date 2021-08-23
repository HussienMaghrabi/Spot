@php
    $title = __('dashboard.Confirmation');
    $body['en'] = 'Do you want to add coins with level up <strong></strong>?';
    $body['ar'] = 'هل تريد إضافة عملات مع زيادة المستوي ؟!';
@endphp
<div class="modal modal-danger fade" id="check-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="float: {{ App::getLocale() == 'ar' ? 'left' : 'right' }}">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{!! $body[App::getLocale()] !!}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline check updateNo">{{__('dashboard.recharge_no_level')}}</button>
                <button type="button" class="btn btn-outline check update">{{__('dashboard.recharge_with_level')}}</button>
                <button type="button" class="btn btn-outline check reduce"><strong>{{__('dashboard.reduce')}}</strong></button>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script>
    $('.update').on('click', function (e) {
        console.log("hhhhhh");
        e.preventDefault();
        $.ajax({
            url: '{{ url(App::getLocale().'/dashboard/vip-users/'.$id.'/edit/recharge_with_level' )}}',
            dataType: 'html',
            data: $('.edit').serialize(),
            success: function(data) {
                window.location.href = "{{ url(App::getLocale().'/dashboard/vip-users/'.$id.'/edit/recharge_with_level' )}}";


            }
        });
    })

    $('.updateNo').on('click', function (e) {
        console.log("hhhhhh");
        e.preventDefault();
        $.ajax({
            url: '{{ url(App::getLocale().'/dashboard/vip-users/'.$id.'/edit/recharge_no_level' )}}',
            dataType: 'html',
            data: $('.edit').serialize(),
            success: function(data) {
                window.location.href = "{{ url(App::getLocale().'/dashboard/vip-users/'.$id.'/edit/recharge_no_level' )}}";


            }
        });
    })

    $('.reduce').on('click', function (e) {
        console.log("hhhhhh");
        e.preventDefault();
        $.ajax({
            url: '{{ url(App::getLocale().'/dashboard/vip-users/'.$id.'/edit/recharge_no_level' )}}',
            dataType: 'html',
            data: $('.edit').serialize(),
            success: function(data) {
                window.location.href = "{{ url(App::getLocale().'/dashboard/vip-users/'.$id.'/edit/reduce_coins' )}}";


            }
        });
    })

</script>

