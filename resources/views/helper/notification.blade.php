@if($notification === KEY_SUCCESS)
    <div class="alert alert-success _notification" role="alert">{{Session::get(KEY_NOTIFICATION)}}</div>
@elseif($notification === KEY_FAIL)
    <div class="alert alert-danger _notification" role="alert">{{Session::get(KEY_NOTIFICATION)}}</div>
@endif

@push('js')
    <script src="{{asset('js/notification.js')}}"></script>
    <script>
        $(document).ready(function () {
            new Notification().hide();
        });
    </script>
@endpush
