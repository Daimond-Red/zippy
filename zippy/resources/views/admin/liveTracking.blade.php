@extends('layouts.master')

@section('content')
    <iframe src="http://zippy.co.in/live-tracking.php" frameborder="0" style="overflow:hidden;height:530px;width:100%" height="150%" width="100%"></iframe>
@stop

@section('script')
    <script>
        $(document).ready(function(){
            $('.tracking-menu').addClass('m-menu__item--active');
        });
    </script>
@stop