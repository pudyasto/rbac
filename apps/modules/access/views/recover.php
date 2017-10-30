
<div class="login-box">
  <div class="login-logo">
    <a href="<?=site_url();?>">
        <?php echo $this->apps->logintitle;?>
        <br>
        <p style="font-size: 18px;"><?php echo $this->apps->logintag;?></p>
    </a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">
        Enter your username that you used to register. 
        <br>
        We'll send you an email with a link to reset your password.
    </p>
    <?php
        echo $this->session->userdata('msg');
        echo validation_errors(); 

        $attforgetform = array(
            'class' => 'forget-form'
            , 'id' => 'recover_form'
            , 'name' => 'recover_form'
            , 'method' => 'post');
        echo form_open(site_url('access/recover'),$attforgetform); 
    ?>
      <div class="form-group has-feedback">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
            <input type="text" id="username" name="username" class="form-control" placeholder="Username" required="">
      </div>
      <div class="row">
        <!-- /.col -->        
        <div class="col-xs-12">
          <button type="submit" class="btn btn-primary btn-block btn-flat">
              Reset My Password
          </button>
        </div>
        
        <div class="col-xs-12 text-center" style="margin-top: 5px;">           
            <a href="<?=site_url('access');?>">
                Login Page
            </a>
        </div>
        <!-- /.col -->
      </div>
    <?php echo form_close(); ?>
    <p style="margin-top: 20px;text-align: center;"> 
        <?php echo $this->apps->copyright ;?> &copy; 2017
        <br>
        <small>
            <?php echo $this->apps->dept . ' | App Ver : 1.1.0 Engine Ver : ' . phpversion();?>
        </small>
        <br>
        <small>
            For Best Experience Please Use Lastest
            <a style="text-decoration: underline;" href="https://www.google.com/chrome/browser/desktop/" target="blank">Google Chrome</a> 
        </small>
    </p>     
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
