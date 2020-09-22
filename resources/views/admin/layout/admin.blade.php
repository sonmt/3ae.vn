<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Quản trị admin</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{asset('adminstration/bootstrap/dist/css/bootstrap.min.css')}}">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="{{asset('adminstration/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('adminstration/font-awesome/css/font-awesome.min.css')}}">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{ asset('adminstration/plugins/iCheck/all.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('adminstration/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{asset('adminstration/Ionicons/css/ionicons.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('adminstration/css/AdminLTE.min.css')}}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{asset('adminstration/css/skins/_all-skins.min.css')}}">
    <!-- jvectormap -->
    <link rel="stylesheet" href="{{ asset('adminstration/jvectormap/jquery-jvectormap.css') }}">
    <!-- jquery ui -->
    <link rel="stylesheet" href="{{ asset('adminstration/jquery-ui-1.12.1.custom/jquery-ui.min.css') }}">
    <!-- Date Picker -->
    <link rel="stylesheet" href="{{ asset('adminstration/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('adminstration/bootstrap-daterangepicker/daterangepicker.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('adminstration/bootstrap-datetimepicker/bootstrap-datetimepicker.css') }}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{ asset('adminstration/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('adminstration/select2/dist/css/select2.min.css') }}">


    <!-- AdminLTE Skins. Choose a skin from the css/skins
      folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('adminstration/css/skins/_all-skins.min.css') }}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
       <script src="{{ asset('js/html5shiv.js') }}"></script>
       <script src="{{ asset('js/respond.min.js') }}"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    @include('admin.partials.nav')

    @include('admin.partials.slidebar')
    <div class="content-wrapper">
    @yield('content')
    </div>
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 1.0
        </div>
        <strong>Copyright &copy; 2014-2016 <a href="https://vn3c.com">Vn3c</a>.</strong> All rights
        reserved.
    </footer>
</div>    <!--/.main-->

<!-- jQuery 3 -->
<script src="{{ asset('adminstration/jquery/dist/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('adminstration/jquery-ui-1.12.1.custom/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('adminstration/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('adminstration/select2/dist/js/select2.full.min.js') }}"></script>
<!-- DataTables -->
<script src="{{ asset('adminstration/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('adminstration/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('adminstration/jquery-sparkline/dist/jquery.sparkline.min.js') }}"></script>
<!-- jvectormap -->
<script src="{{ asset('adminstration/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ asset('adminstration/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('adminstration/jquery-knob/dist/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('adminstration/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('adminstration/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<!-- datepicker -->
<script src="{{ asset('adminstration/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{ asset('adminstration/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
<!-- bootstrap color picker -->
<script src="{{ asset('adminstration/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
<!-- bootstrap time picker -->
<script src="{{ asset('adminstration/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>
<!-- Slimscroll -->
<script src="{{ asset('adminstration/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('adminstration/fastclick/lib/fastclick.js') }}"></script>
<!-- iCheck 1.0.1 -->
<script src="{{ asset('adminstration/plugins/iCheck/icheck.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('adminstration/fastclick/lib/fastclick.js') }}"></script>
<!-- InputMask -->
<script src="{{ asset('adminstration/plugins/input-mask/jquery.inputmask.js') }}"></script>
<script src="{{ asset('adminstration/plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
<script src="{{ asset('adminstration/plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>
<!-- CK Editor -->
<script src="{{ asset('adminstration/ckfinder/ckfinder.js') }}"></script>
<!-- CK Editor -->
<script src="{{ asset('adminstration/ckeditor/ckeditor.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('adminstration/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('adminstration/js/demo.js') }}"></script>
<script src="{{ asset('js/jquery-sortable-lists.js') }}"></script>

@stack('scripts')

<script>
    $(function () {
         $( "#sortable2" ).sortable();
         $( "#sortable2" ).disableSelection();

        var options = {
            // Like a css class name. Class will be removed after drop.
            currElClass: 'currElemClass',
            // or like a jQuery css object. Note that css object settings can't be removed
            currElCss: {'background-color':'green', 'color':'#fff'},
            placeholderClass: 'placeholderClass',
            // or like a jQuery css object
            placeholderCss: {'background-color':'yellow'},
            hintClass: 'hintClass',
            // or like a jQuery css object
            hintCss: {'background-color':'green', 'border':'1px dashed white'},
            listSelector: 'ul',
            hintWrapperClass: 'hintClass',
            // or like a jQuery css object
            hintWrapperCss: {'background-color':'green', 'border':'1px dashed white'},
            ignoreClass: 'clickable',
            complete: function(currEl)
            {
                var lengthParent = $('#myList').parents().length;
                // console.log(lengthParent);
                //console.log($(currEl).parents().length);
                var levelMenu = ($(currEl).parents().length - lengthParent -2)/2 + 1;
                console.log( levelMenu);
            }
        }
        $('#sortableListsBase').sortableLists(options);

        $('#user').DataTable();
        $('#example1').DataTable();

        //Initialize Select2 Elements
        $('.select2').select2()

        $('.my-colorpicker1').colorpicker()
        
        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass   : 'iradio_flat-green'
        })
        $('.editor').each(function(e){
            CKEDITOR.replace( this.id, {
                filebrowserBrowseUrl : '/kcfinder-master/browse.php',
                filebrowserImageBrowseUrl : '/kcfinder-master/browse.php?type=images&dir=images/public',
                filebrowserImageUploadUrl : '/kcfinder-master/browse.php?type=images&dir=images/public'
            });
        });

        $('#datepicker').datetimepicker({});

        $('#reservationtime').daterangepicker({
            timePicker: true,
            timePickerIncrement: 30,
            locale: {
                format: 'MM/DD/YYYY h:mm A'
            }
        });
        
    })
    
    function addMenu(e) {
        var itemMenu = '<li class="ui-state-default">';
        itemMenu += '<i class="fa fa-ban removeMenu" aria-hidden="true" onclick="return removeMenu(this);"></i>';
        itemMenu += $(e).parent().html();
        itemMenu = itemMenu.replace('<i class="fa fa-plus addMenu" onclick="return addMenu(this);" aria-hidden="true"></i>', "");
        itemMenu += '</li>';
        dataTarget = $(e).next().attr('data-target');
        $(e).next().removeAttr('data-target');
        $(e).next().attr('data-target', (dataTarget+'1'));
        dataTarget = dataTarget.replace('#', "");
        $(e).next().next().next().next().removeAttr('id');
        $(e).next().next().next().next().attr('id', (dataTarget+'1'));
        $('#sortable2').append(itemMenu);
    };

    function removeMenu(e) {
         $(e).parent().remove();
    }
    function uploadImage(e) {
        window.KCFinder = {
            callBack: function(url) {
                window.KCFinder = null;
                var img = new Image();
                img.src = url;
                $(e).next().attr("src",url);
                $(e).next().next().val(url);
            }
        };
        window.open('/kcfinder-master/browse.php?type=images&dir=images/public',
            'kcfinder_image', 'status=0, toolbar=0, location=0, menubar=0, ' +
            'directories=0, resizable=1, scrollbars=0, width=800, height=600'
        );
    }
    function openKCFinder(e) {
        window.KCFinder = {
            callBackMultiple: function(files) {
                window.KCFinder = null;
                var urlFiles = "";
                $(e).next().empty();
                for (var i = 0; i < files.length; i++){
                    $(e).next().append('<img src="'+ files[i] +'" width="80" height="70" style="margin-left: 5px; margin-bottom: 5px;"/>')
                    urlFiles += files[i] ;
                    if (i < (files.length - 1)) {
                        urlFiles += ',';
                    }
                }

                $(e).next().next().val(urlFiles);
            }
        };
        window.open('/kcfinder-master/browse.php?type=images&dir=images/public',
            'kcfinder_multiple', 'status=0, toolbar=0, location=0, menubar=0, ' +
            'directories=0, resizable=1, scrollbars=0, width=800, height=600'
        );
    }


</script>

</body>
</html>
