<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> <?php echo $template['title'];?> </title>
    <!-- Favicon-->
    <link rel="icon" href="<?=base_url('assets/dist/img/favicon.png');?>" type="image/png">

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="<?=base_url('assets/bootstrap/css/bootstrap.min.css');?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    
    <!-- Select2-->
    <link href="<?=base_url('assets/plugins/select2/select2.css');?>" rel="stylesheet">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?=base_url('assets/plugins/iCheck/flat/blue.css');?>">
    <!-- jvectormap -->
    <link rel="stylesheet" href="<?=base_url('assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css');?>">
    <!-- Date Picker -->
    <link rel="stylesheet" href="<?=base_url('assets/plugins/datepicker/datepicker3.css');?>">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="<?=base_url('assets/plugins/daterangepicker/daterangepicker.css');?>">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="<?=base_url('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css');?>">
    
    <!-- Theme style -->
    <link rel="stylesheet" href="<?=base_url('assets/dist/css/AdminLTE.min.css');?>">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?=base_url('assets/dist/css/skins/_all-skins.min.css');?>">

  

    <!-- jQuery 2.2.3 -->
    <script src="<?=base_url('assets/plugins/jQuery/jquery-2.2.3.min.js');?>"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.6 -->
    <script src="<?=base_url('assets/bootstrap/js/bootstrap.min.js');?>"></script>

    <!-- daterangepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
    <script src="<?=base_url('assets/plugins/daterangepicker/daterangepicker.js');?>"></script>
    <!-- datepicker -->
    <script src="<?=base_url('assets/plugins/datepicker/bootstrap-datepicker.js');?>"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="<?=base_url('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js');?>"></script>
    <!-- Slimscroll -->
    <script src="<?=base_url('assets/plugins/slimScroll/jquery.slimscroll.min.js');?>"></script>
    <!-- FastClick -->
    <script src="<?=base_url('assets/plugins/fastclick/fastclick.js');?>"></script>
    
    <!-- DataTables -->
    <link rel="stylesheet" href="<?=base_url('assets/plugins/datatables/dataTables.bootstrap.css');?>">
    <script src="<?=base_url('assets/plugins/datatables/jquery.dataTables.min.js');?>"></script>
    <script src="<?=base_url('assets/plugins/datatables/dataTables.bootstrap.min.js');?>"></script>
    
    <!-- Sweetalert -->
    <link rel="stylesheet" href="<?=base_url('assets/plugins/sweetalert/sweetalert.css');?>">
    <script src="<?=base_url('assets/plugins/sweetalert/sweetalert.min.js');?>"></script>
    
    <!-- Jansy -->
    <link rel="stylesheet" href="<?=base_url('assets/plugins/jasny-bootstrap/css/jasny-bootstrap.min.css');?>">
    <script src="<?=base_url('assets/plugins/jasny-bootstrap/js/jasny-bootstrap.min.js');?>"></script>
    
    
    <!-- Select2 -->
    <script src="<?=base_url('assets/plugins/select2/select2.full.min.js');?>"></script>
    
    <!-- Ajax Form -->
    <script src="<?=base_url('assets/plugins/jquery-form/jquery.form.min.js');?>"></script>
    
    <!-- AdminLTE App -->
    <script src="<?=base_url('assets/dist/js/app.min.js');?>"></script>
  
    <!-- DataTables -->
    <link rel="stylesheet" href="<?=base_url('assets/custom/my.css');?>">
    <script src="<?=base_url('assets/custom/my.js');?>"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js');?>"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js');?>"></script>
    <![endif]-->
</head>
<body class="hold-transition skin-green-light sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="<?=site_url();?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>CI</b>3</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg">
          <?php echo $this->apps->title;?>
      </span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success">4</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 4 messages</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li><!-- start message -->
                    <a href="#">
                      <div class="pull-left">
                        <img src="<?=base_url('assets/dist/img/user2-160x160.jpg');?>" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Support Team
                        <small><i class="fa fa-clock-o"></i> 5 mins</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <!-- end message -->
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="<?=base_url('assets/dist/img/user3-128x128.jpg');?>" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        AdminLTE Design Team
                        <small><i class="fa fa-clock-o"></i> 2 hours</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="<?=base_url('assets/dist/img/user4-128x128.jpg');?>" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Developers
                        <small><i class="fa fa-clock-o"></i> Today</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="<?=base_url('assets/dist/img/user3-128x128.jpg');?>" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Sales Department
                        <small><i class="fa fa-clock-o"></i> Yesterday</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="<?=base_url('assets/dist/img/user4-128x128.jpg');?>" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Reviewers
                        <small><i class="fa fa-clock-o"></i> 2 days</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">See All Messages</a></li>
            </ul>
          </li>
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">10</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 10 notifications</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-aqua"></i> 5 new members joined today
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
                      page and may cause design problems
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-red"></i> 5 new members joined
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-user text-red"></i> You changed your username
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">View all</a></li>
            </ul>
          </li>
          <!-- Tasks: style can be found in dropdown.less -->
          <li class="dropdown tasks-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-flag-o"></i>
              <span class="label label-danger">9</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 9 tasks</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li><!-- Task item -->
                    <a href="#">
                      <h3>
                        Design some buttons
                        <small class="pull-right">20%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">20% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                  <li><!-- Task item -->
                    <a href="#">
                      <h3>
                        Create a nice theme
                        <small class="pull-right">40%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">40% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                  <li><!-- Task item -->
                    <a href="#">
                      <h3>
                        Some task I need to do
                        <small class="pull-right">60%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-red" style="width: 60%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">60% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                  <li><!-- Task item -->
                    <a href="#">
                      <h3>
                        Make beautiful transitions
                        <small class="pull-right">80%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-yellow" style="width: 80%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">80% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                </ul>
              </li>
              <li class="footer">
                <a href="#">View all tasks</a>
              </li>
            </ul>
          </li>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?=base_url('profile/show_image');?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $this->session->userdata('surename');?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?=base_url('profile/show_image');?>" class="img-circle" alt="User Image">

                <p>
                  <?php echo $this->session->userdata('surename');?>
                  <small><?php echo $this->session->userdata('email');?></small>
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#">Followers</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Sales</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Friends</a>
                  </div>
                </div>
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?=site_url('profile');?>" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                    <?php
                        $attributes = array(
                            'id' => 'logout_form'
                            , 'name' => 'logout_form'
                            , 'method' => 'post');
                        echo form_open(site_url('access/logout'),$attributes);
                        
                        $btn_logout = array(
                            'name'          => 'button',
                            'id'            => 'button',
                            'value'         => 'true',
                            'type'          => 'submit',
                            'content'       => 'Sign Out',
                            'class'         => 'btn btn-default btn-flat'
                        );
                        echo form_button($btn_logout);
                        echo form_close();
                    ?>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?=base_url('profile/show_image');?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>
              <?php echo $this->session->userdata('surename');?>
          </p>
          <a href="#">
                <i class="fa fa-circle text-success"></i> 
                <?php echo $this->session->userdata('platform');?>
          </a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form" style="border: none;">
        <div class="input-group">
            <select class="form-control" name="q-menu" id="q-menu">
            </select>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
        <?php
            $dashboard_active = "";
            $profile_active = "";
            $class_name = $this->uri->segment(1);
            if($class_name=="dashboard" || $class_name == ""){
                $dashboard_active= "active";
            }elseif($class_name=="profile"){
                $profile_active= "active";
            }
        ?>   
        <li class="<?php echo $dashboard_active;?>">
            <a href="<?=site_url('dashboard');?>">
                <i class="fa fa-dashboard"></i> 
                <span>Dashboard</span>
            </a>
        </li>
        <?php
            $menu_app = $this->rbac->menu_app($class_name);
            if(is_array($menu_app)){
                foreach ($menu_app['menus'] as $mn)
                {  
                    if( !empty($mn['name']) ){
                        if($mn['sub']['submenu']){
                    ?>
                            <li class="<?php echo $mn['active'];?> treeview">
                              <a href="javascript:void(0);" title="<?php echo $mn['description'];?>">
                                <i class="<?php echo $mn['icon'];?>"></i>
                                <span ><?php echo $mn['name'];?></span> 
                                <span class="pull-right-container">
                                  <i class="fa fa-angle-left pull-right"></i>
                                </span>
                              </a>
                              <ul class="treeview-menu">
                    <?php      
                                foreach ($mn['sub']['submenu'] as $submn)
                                {
                                    if($submn){
                                        echo "<li class=\"".$submn['sub_active']."\">"
                                                . "<a title=\"".$submn['description']."\" href=\"".site_url($submn['link'])."\"> "
                                                . "<i class=\"".$submn['icon']."\"></i>"
                                                . $submn['name']
                                                . "</a>"
                                            . "</li>";
                                    }
                                }                        
                    ?>
                              </ul>
                            </li>
                    <?php
                            }
                        }
                }     
            } 
        ?>
        <li class="<?php echo $profile_active;?>">
            <a href="<?=site_url('profile');?>">
                <i class="fa fa-user"></i> 
                <span>Profile</span>
            </a>
        </li>    
        <li>
            <a href="javascript:void(0);" onclick="logout();" title="Logout application">
                <i class="fa fa-sign-out"></i> 
                <span>Logout</span>
            </a>
        </li>                        
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {msg_main}
        <small>{msg_detail}</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <?php echo $template['body'];?>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">      
    <div class="pull-right hidden-xs">
        <?php echo  (ENVIRONMENT === 'development') ? 'Memory usage :' . $this->benchmark->memory_usage() . ', ' . $this->benchmark->elapsed_time() . ' seconds CodeIgniter Version <strong>' . CI_VERSION . '</strong> | ' : '' ?>
        <strong> <?php echo ($this->session->userdata('log_tanggal') !== "") ? 'Last Login <i class="fa fa-calendar"></i> ' . date("d-m-Y H:i:s",$this->session->userdata('log_tanggal')) : '';?> </strong>
    </div>
    <div>
        <?php echo $this->apps->copyright;?> &copy; 2016 - <?php echo (date('Y'));?>
    </div>
  </footer>

</div>
<!-- ./wrapper -->
<script>
    $(document).ready(function() {
        $('#q-menu').select2({
            placeholder: 'Search Menu ...',
            dropdownAutoWidth : false,
            width: '210px',
            ajax: {
                  url: "<?=site_url('menus/get_menu');?>",
                  type: 'post',
                  dataType: 'json',
                  delay: 250,
                  data: function (params) {
                    return {
                      q: params.term, // search term
                      page: params.page
                    };
                  },
                  processResults: function (data, params) {
                    // parse the results into the format expected by Select2
                    // since we are using custom formatting functions we do not need to
                    // alter the remote JSON data, except to indicate that infinite
                    // scrolling can be used
                    params.page = params.page || 1;

                    return {
                      results: data.items,
                      pagination: {
                        more: (params.page * 30) < data.total_count
                      }
                    };
                  },
                  cache: true
                },
                escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
                minimumInputLength: 1,
                templateResult: formatMenus, // omitted for brevity, see the source of this page
                templateSelection: formatMenusSelection // omitted for brevity, see the source of this page
        });        
        
        $('#q-menu').change(function(){
            var data = $(this).val();
            window.location.replace("<?=site_url();?>"+data);
        });
        
        function formatMenus (repo) {
            if (repo.loading) return "Searching data ... ";


            var markup = "<div class='select2-result-repository clearfix'>" +
              "<div class='select2-result-repository__meta'>" +
                "<div class='select2-result-repository__title'><b style='font-size: 14px;'>" + repo.text + "</b></div>";

            markup += "<div class='select2-result-repository__statistics'>" +
              "<div class='select2-result-repository__stargazers' style='font-size: 12px;'> " + repo.description + " </div>" +
            "</div>" +
            "</div></div>";
            return markup;
          }

        function formatMenusSelection (repo) {
            return repo.full_name || repo.text;
        }  
    });
    
    function logout(){
        swal({
            title: "Confirm Logout!",
            text: "Are you sure ?",
            type: "info",
            showCancelButton: true,
            confirmButtonColor: "#c9302c",
            confirmButtonText: "Yes, I'm sure!",
            cancelButtonText: "No, I'm not sure!",
            closeOnConfirm: false
        }, function () {
            location.replace("<?=site_url('access/logout');?>");
        });
    }
</script>
</body>
</html>
