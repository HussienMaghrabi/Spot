@php
    $title = __('dashboard.Confirmation');
    $body['en'] = 'Are you sure you want to delete <strong class="count"></strong> records?';
    $body['ar'] = 'هل انت متأكد من حذف  <strong class="count"></strong> سجل؟';
@endphp
<div class="modal modal-danger fade" id="danger_all">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" style="float: {{ App::getLocale() == 'ar' ? 'left' : 'right' }}" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">{{ $title }}</h4>
            </div>
            <div class="modal-body">
                <p>{!! $body[App::getLocale()] !!}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">{{__('dashboard.Close')}}</button>
                <button type="button" class="btn btn-outline pull-right delete-all">{{__('dashboard.OK')}}</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script type="text/javascript">
    $(document).ready(function () {

        function enable(){
            var count = $(".sub_chk:checkbox:checked").length;
            var ids = $(".sub_chk:checkbox:checked").val();
            if (count > 0){
                $('.delete_all').removeClass('disabled');
                $('.ids').val(ids);
                $('.count').text(count);
            } else {
                $('.delete_all').addClass('disabled');
            }
        }

        $('#master').on('click', function(e) {
            if($(this).is(':checked',true))
            {
                $(".sub_chk").prop('checked', true);
            } else {
                $(".sub_chk").prop('checked',false);
            }
            enable();
        });

        $('.sub_chk').on('click', function(e) {
            $("#master").prop('checked', false);
            enable();
        });

        $('.delete-all').on('click', function(){
            $('.delete-form').submit();
        });

        {{--$('.delete-form').on('submit', function (e) {--}}
        {{--e.preventDefault();--}}
        {{--var ids = $(".sub_chk:checkbox:checked").val();--}}

        {{--$.ajax({--}}
        {{--url: "{{route($resource.'.multiDelete', App::getLocale())}}",--}}
        {{--type: 'post',--}}
        {{--data: {_method: 'delete', _token :"{{csrf_token()}}", checked: ids },--}}
        {{--success: function( msg ) {--}}
        {{--$('.modal').modal('hide');--}}
        {{--if ($('.table-hover tr').length === 2){--}}
        {{--if ("{{ isset($_GET['page']) && $_GET['page'] != 1 }}"){--}}
        {{--location.reload();--}}
        {{--window.location.href = "{{url('')}}"+window.location.pathname+"{{'?page='.($data->lastPage()-1)}}";--}}
        {{--} else  {--}}
        {{--location.reload();--}}
        {{--window.location.href = "{{route($resource.'.index', App::getLocale())}}";--}}
        {{--}--}}
        {{--} else {--}}
        {{--$('.tr-{{$id}}').remove()--}}
        {{--}--}}
        {{--}--}}
        {{--});--}}
        {{--});--}}
    });
</script>
