
<!doctype html>
<html lang="en">

    @include('fixed.head')

  <body id="top">

  
    

<div class="site-wrap">

    @include('fixed.mobile-menu')
    

    <!-- NAVBAR -->
    @include('fixed.header')

    <!-- HOME -->
    @yield('content')
    
    @include('fixed.footer')
  
  </div>

    <!-- SCRIPTS -->
    @include('fixed.scripts')
    
    @if(session()->has("success"))
   
      <script>
          window.onload = function () {
            makeNotification(0,'{{session("success")["title"]}}', '{{session("success")["message"]}}' );
          }
      </script>
    @endif

    @if(session()->has("error"))
      <script>
          window.onload = function () {
            makeNotification(1,'{{session("error")["title"]}}','{{session("error")["message"]}}');
          }
      </script>
    @endif

    @if ($errors->any())
    <script>
      window.onload = function () {
        makeNotification(1,"Error:","Invalid form inputs.");
      }
  </script>
    @endif
  </body>
</html>