<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  @if($pageTitle ?? ''!="")
  <title>KIU Representative Portal | {{ $pageTitle ?? '' ?? '' }}</title>
@else
  <title>KIU Representative Portal | Dashboard</title>
@endif
  <!-- Font Awesome Icons -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
  <link rel="stylesheet" href="{{ asset('/css/myStyle.css') }}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('/plugins/toastr/toastr.min.css') }}">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
  <style>
    .user-panel img {
      width: 3.2rem !important;
    }
    .p-3 {
      padding: 0rem!important;
    }
    .mb-2, .my-2 {
      margin-bottom: 0rem!important;
    }
  </style>
<script src="{{ asset('js/app.js') }}"></script>
<!-- REQUIRED SCRIPTS -->
<script src="{{ asset('/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('/plugins/toastr/toastr.min.js') }}"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.js"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script>
// DataTable Setup
function masterAlert(type,content,msg){
  if(type == 1){
    if(msg !=undefined && msg !=''){
      var content = msg;
    }else{
      var content = 'everything went well';
    }
    var title = 'Successfully!';

    var type = 'green';
    var btnClass = 'btn-green';
    var icon = 'glyphicon glyphicon-ok';
  }else if(type == 2){
    if(msg !=undefined && msg !=''){
      var content = msg;
    }else{
      var content = 'Something went wrong';
    }
    var title = 'Encountered an error!';

    var type = 'red';
    var btnClass = 'btn-red';
    var icon = 'glyphicon glyphicon-remove';
  }

  $.alert({
      closeIcon: false,
      title: title,
      content: content,
      type: type, 
      typeAnimated: true,
      autoClose: 'ok|5000',
      icon: icon,
      backgroundDismiss: true,
      buttons: {
        ok : {
        //isHidden: true,
        text: 'Ok..',
        btnClass: btnClass,
        close: function () {

        }
        }
      }
  });
}
var loadSpin = $.dialog({
    lazyOpen: true,
    closeIcon: false,
    title: '<span class="fa fa-spinner fa-spin fa-w-16 fa-2x"></span>',
    titleClass: 'btn',
    content: 'Processing',
    theme: 'light',
    backgroundDismissAnimation: 'glow',
    columnClass: 'center',
    boxWidth: '',
});
$(document).ready(function () {

    checkOnline();

    /*jQuery.ajaxSetup({
        beforeSend: function () {
            loadSpin.toggle();
        },
        complete: function () {
            loadSpin.toggle();
        },
        error: function (xhr, status, error) {
            loadSpin.toggle();
            toastr.error(status + ' / ' + error);
        }
    });*/
});

function checkOnline() {
  var x = 0;
    setInterval(function () {
        if(navigator.onLine) {
          if(x == 1){
            x = 0;
            toastr.success('Hurray! You are online!!!');
          }
        }else{
          if(x == 0){
            x = 1;
            toastr.error('Oops! You are offline. Please check your network connection...');
          }
        }
    }, 1000);
}

</script>
</head>
<body class="sidebar-mini text-sm">
  <div class="wrapper">
  <!-- Navbar -->

  @include('layouts.topnavi')
  <!-- /.navbar -->

<!-- Main Sidebar Container -->
@include('layouts.leftmenu')
<!-- /.Main Sidebar Container -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
   @yield('content')
  </div>
  <!-- /.Content-wrapper -->

  <!-- Main Footer -->
  @include('layouts.footer')
  <!-- /.Main Footer -->

</div>
<!-- ./wrapper -->

</body>
</html>
