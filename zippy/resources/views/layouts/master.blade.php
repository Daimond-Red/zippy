@if( request('isContent') )
    @yield('content')
@else
    @include('layouts.header')
        @yield('content')
    @include('layouts.footer')
@endif