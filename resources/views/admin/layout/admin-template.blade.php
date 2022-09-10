<!DOCTYPE html>
<html lang="en">

@include("admin.fixed.head")
<!--
`body` tag options:

  Apply one or more of the following classes to to the body tag
  to get the desired effect

  * sidebar-collapse
  * sidebar-mini
-->
<body class="hold-transition sidebar-mini layout-navbar-fixed">
<div class="wrapper">
  <!-- Navbar -->
    @include("admin.fixed.nav")
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
    @include("admin.fixed.sidebar")

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      @yield("content")
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  @include("admin.fixed.footer")
</div>
<!-- ./wrapper -->

@include("admin.fixed.scripts")


</body>
</html>
