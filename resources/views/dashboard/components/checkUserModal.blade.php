@php
    $title = __('dashboard.Confirmation');
    $body['en'] = 'Do you want to add coins with level up <strong></strong>?';
    $body['ar'] = 'هل تريد إضافة عملات مع زيادة المستوي ؟!';
@endphp
<div class="modal modal-danger fade" id="check-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <p><strong>{!! $title !!}</strong></p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="float: {{ App::getLocale() == 'ar' ? 'left' : 'right' }}">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{!! $body[App::getLocale()] !!}</p>
            </div>
            <div class="modal-footer" style="justify-content: space-around;">
                <button type="button" class="btn btn-outline pull-left " data-dismiss="modal"><strong>{{__('dashboard.Close')}}</strong></button>
                <button type="button" class="btn btn-outline check updateNo"><strong>{{__('dashboard.recharge_no_level')}}</strong></button>
                <button type="button" class="btn btn-outline check update"><strong>{{__('dashboard.recharge_with_level')}}</strong></button>
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
            url: '{{ url(App::getLocale().'/dashboard/users/'.$id.'/edit/recharge_with_level' )}}',
            dataType: 'html',
            data: $('.edit').serialize(),
            success: function(data) {
                window.location.href = "{{ url(App::getLocale().'/dashboard/users/'.$id.'/edit/recharge_with_level' )}}";


            }
        });
    })

    $('.updateNo').on('click', function (e) {
        console.log("hhhhhh");
        e.preventDefault();
        $.ajax({
            url: '{{ url(App::getLocale().'/dashboard/users/'.$id.'/edit/recharge_no_level' )}}',
            dataType: 'html',
            data: $('.edit').serialize(),
            success: function(data) {
                window.location.href = "{{ url(App::getLocale().'/dashboard/users/'.$id.'/edit/recharge_no_level' )}}";


            }
        });
    })

</script>

