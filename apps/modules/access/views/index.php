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
        <?php echo $this->apps->logindesc;?>
    </p>
    
    <?php
        echo $this->session->userdata('msg');
        echo validation_errors(); 
        if(isset($_GET['url'])){
            $url = $_GET['url'];
        }else{
            $url = null;
        }
        $array_login = array('msg', 'stat');
        $this->session->unset_userdata($array_login);

        $attributes = array(
            'class' => 'login-form'
            , 'id' => 'access_form'
            , 'name' => 'access_form'
            , 'method' => 'post');
        echo form_open(site_url('access/login/?url=' . $url),$attributes); 
    ?>   
      <div class="form-group has-feedback">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
            <input type="text" id="username" name="username" class="form-control" placeholder="Username" autofocus="" required="">
      </div>
      <div class="form-group has-feedback">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            <input type="password" name="password" id="password" class="form-control" placeholder="Password" required="">
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox" name="rememberme" id="rememberme"> Remember Me
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">
              Sign In
          </button>
        </div>
        <!-- /.col -->
      </div>
    <?php echo form_close(); ?>

    <a href="<?=site_url('access/recover');?>">I forgot my password</a>
    <p style="margin-top: 20px;text-align: center;"> 
        <?php echo $this->apps->copyright ;?> &copy; 2017
        <br>
        <small>
            <?php echo $this->apps->dept . ' | App Ver : 1.1.0 Engine Ver : ' . phpversion();?>
        </small>
        <br>
        <small>
            For Best Experience Pleas Use Lastest
            <a style="text-decoration: underline;" href="https://www.google.com/chrome/browser/desktop/" target="blank">Google Chrome</a> 
        </small>
    </p>     
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->