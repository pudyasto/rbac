
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
    <?php
        if(empty($data)){
            redirect('access');
            exit;
        }
        echo $data;
    ?>    
    <?php
        $attaccessform = array(
            'class' => 'm-t'
            , 'id' => 'access_form'
            , 'name' => 'access_form'
            , 'method' => 'post');
        echo form_open(site_url('access'),$attaccessform); 
    ?>         
    <form class="m-t" method="post" role="form" action="<?=site_url('access');?>">
        <div class="form-group">
            <?php
                if(!$data){
                    echo '<button onclick="goBack();" type="button" class="btn btn-primary btn-block"><i class="fa fa-arrow-circle-left"></i> Back prevous page</button>';
                }
            ?>                   
        </div>                     
        <a href="<?=site_url('access');?>" class="btn btn-default block full-width m-b">SIGN IN</a>
    <?php echo form_close(); ?>
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
<script>
function goBack() {
    window.history.back();
}
</script>