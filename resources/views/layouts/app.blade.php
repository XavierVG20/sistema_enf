<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@section('htmlheader')
@include('partials.htmlheader')
@show

<body>
     @include('partials.controlsidebar')
   
    <div id="app" class="wrapper dd-flex flex-column min-vh-100 bg-light">
     @include('partials.mainheader')
    
        
        <div class="container-fluid">
        <main class="py-4 ">
            @yield('content')
        </main>
        </div>
        
    </div>
</body>
@include('partials.scripts')
</html>