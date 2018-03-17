<!DOCTYPE html>
<html lang="en">

<head>
  @include('partial_views.head')
</head>

<body>

  <div class='container-fluid'>
    @include('partial_views.header')
  </div>

  <div class='container'>

    @yield('content')
  </div>
  </div>

  <footer id="footer">
    @include('partial_views.footer')
  </footer>

  @include('partial_views.scripts')
</body>

</html>