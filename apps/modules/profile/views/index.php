<?php

/* 
 * ***************************************************************
 * Script : 
 * Version : 
 * Date :
 * Author : Pudyasto Adi W.
 * Email : mr.pudyasto@gmail.com
 * Description : 
 * ***************************************************************
 */
?>
<!-- BEGIN PAGE LEVEL STYLES -->
<link href="<?=base_url('assets/pages/css/profile-2.min.css');?>" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL STYLES -->
<div class="profile">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs" id="myTab">
            <li class="active">
                <a href="#tab_1_1" data-toggle="tab"> Overview </a>
            </li>
            <li>
                <a href="#tab_1_3" data-toggle="tab"> Account </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1_1">
                <div class="row">
                    <div class="col-md-3">
                        <ul class="list-unstyled profile-nav">
                            <li>
                                <img src="<?=base_url('profile/show_image');?>" class="img-responsive pic-bordered" alt="" />
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-12 profile-info">
                                <h1 class="font-green sbold uppercase"><?php echo $user[0]['first_name'].' '.$user[0]['last_name'];?></h1>
                                <p>
                                    <a href="javascript:;"><?php echo $user[0]['email'];?></a>
                                </p>
                                <ul class="list-inline">
                                    <li>
                                        <i class="fa fa-calendar"></i> 18 Jan 1982 </li>
                                    <li>
                                        <i class="fa fa-phone"></i> <?php echo $user[0]['phone'];?> </li>
                                </ul>
                            </div>
                            <!--end col-md-8-->
                        </div>
                        <!--end row-->
                    </div>
                </div>
            </div>
            <!--tab_1_2-->
            <div class="tab-pane" id="tab_1_3">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Custom Tabs (Pulled to the right) -->
                        <div class="nav-tabs-custom">
                          <ul class="nav nav-tabs pull-right">
                            <li class="">
                                <a href="#tab_1-1" data-toggle="tab" aria-expanded="false">
                                    <i class="fa fa-lock"></i> Update Password </a>
                                </a>
                            </li>
                            <li>
                                <a href="#tab_2-2" data-toggle="tab">
                                    <i class="fa fa-picture-o"></i> Update Photo </a>
                                </a>
                            </li>
                            <li class="active">
                                <a href="#tab_3-2" data-toggle="tab" aria-expanded="true">
                                    <i class="fa fa-cog"></i> User Information </a>                                    
                                </a>
                            </li>
                          </ul>
                          <div class="tab-content">
                            <div class="tab-pane" id="tab_1-1">
                                <form action="#">
                                    <div class="form-group">
                                        <label class="control-label">New Password</label>
                                        <input type="password" name="password1" id="password1" class="form-control" /> </div>
                                    <div class="form-group">
                                        <label class="control-label">Repeat New Password</label>
                                        <input type="password" name="password2" id="password2"class="form-control" /> </div>
                                    <div class="margin-top-10">
                                        <button type="button" class="btn btn-primary btn-save-password"> Save Changes </button>
                                        <a href="<?=site_url('profile');?>" class="btn btn-default"> Cancel </a>
                                    </div>
                                </form>
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="tab_2-2">
                                <p> 
                                    Click <i>Select Image</i> for change your photo
                                </p>
                                <form action="javascript:upload_photo();" name="frm_upload_photo" id="frm_upload_photo" 
                                      method="post" data-validate="parsley" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" /> </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                            <div>
                                                <span class="btn btn-default btn-sm btn-file">
                                                    <span class="fileinput-new"> <i class="fa fa-camera"></i> Select image </span>
                                                    <span class="fileinput-exists"> Change </span>
                                                    <input type="file" name="pictureFile" id="pictureFile"> </span>
                                                <a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                            </div>
                                        </div>
                                        <div class="clearfix margin-top-10">
                                            <span class="label label-danger"> NOTE! </span>
                                            <span> Attached image thumbnail is supported in Latest Firefox, Chrome, Opera, Safari and Internet Explorer 10 only </span>
                                        </div>
                                    </div>
                                    <div class="margin-top-10">
                                        <button type="submit" class="btn btn-primary btn-upload-foto"> Submit </button>
                                        <a href="<?=site_url('profile');?>" class="btn btn-default"> Cancel </a>
                                    </div>
                                </form>
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane active" id="tab_3-2">
                                <form role="form" action="<?=site_url('profile/submit_profile');?>">
                                    <input type="hidden" name="id" id="id" value="<?php echo $user[0]['id'];?>" class="form-control" />
                                    <div class="form-group">
                                        <label class="control-label">First Name</label>
                                        <input type="text" name="first_name" id="first_name" value="<?php echo $user[0]['first_name'];?>" class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Last Name</label>
                                        <input type="text" name="last_name" id="last_name" value="<?php echo $user[0]['last_name'];?>" class="form-control" /> 
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Phone</label>
                                        <input type="text" name="phone" id="phone" value="<?php echo $user[0]['phone'];?>" class="form-control" /> 
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Email</label>
                                        <input type="email" name="email" id="email" value="<?php echo $user[0]['email'];?>" class="form-control" /> 
                                    </div>
                                    <div class="margiv-top-10">
                                        <button type="button" class="btn btn-primary btn-save-profile"> Save Changes </button>
                                        <a href="<?=site_url('profile');?>" class="btn btn-default"> Cancel </a>
                                    </div>
                                </form>
                            </div>
                            <!-- /.tab-pane -->
                          </div>
                          <!-- /.tab-content -->
                        </div>
                        <!-- nav-tabs-custom -->
                      </div>
                </div>
            </div>
            <!--end tab-pane-->
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $(".btn-save-profile").click(function(){
            submit_profile();
        });
        
        $(".btn-save-password").click(function(){
            submit_password();
        });
        
        $(".btn-upload-foto").click(function(){
            upload_photo();
        });        
    });
    
    function submit_profile(){
        var id = $("#id").val();
        var first_name = $("#first_name").val();
        var last_name = $("#last_name").val();
        var phone = $("#phone").val();
        var email = $("#email").val();
        $.ajax({
            type: "POST",
            url: "<?=site_url('profile/submit_profile');?>",
            data: {"<?=$csrf['name'];?>":"<?=$csrf['hash'];?>"
                    ,"id":id,"first_name":first_name,"last_name":last_name
                    ,"phone":phone,"email":email},
            beforeSend: function(result){
                $('.form-control').attr('disabled', true);
            },
            success: function(result){
                $('.form-control').attr('disabled', false);
                var obj = jQuery.parseJSON(result);
                if(obj.state==="1"){
                    swal({
                        title: "Success",
                        text: obj.msg,
                        type: "success"
                    }, function(){
                        location.reload();
                    });
                }else{
                    swal({
                        title: "Error!",
                        text: obj.msg,
                        type: "error"
                    }, function(){
                        location.reload();
                    });
                }
            },
            error:function(event, textStatus, errorThrown) {
                swal("Error !", 'Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown, "error");
                $('.form-control').attr('disabled', false);
            }
        });
    };
    
    function submit_password(){
        var id = $("#id").val();
        var password1 = $("#password1").val();
        var password2 = $("#password2").val();
        $.ajax({
            type: "POST",
            url: "<?=site_url('profile/submit_password');?>",
            data: {"<?=$csrf['name'];?>":"<?=$csrf['hash'];?>"
                    ,"id":id,"password1":password1,"password2":password2},
            beforeSend: function(result){
                $('.form-control').attr('disabled', true);
            },
            success: function(result){
                $('.form-control').attr('disabled', false);
                var obj = jQuery.parseJSON(result);
                if(obj.state==="1"){
                    swal({
                        title: "Success",
                        text: obj.msg,
                        type: "success"
                    }, function(){
                        location.reload();
                    });
                }else{
                    swal({
                        title: "Error!",
                        text: obj.msg,
                        type: "error"
                    }, function(){
                        location.reload();
                    });
                }
            },
            error:function(event, textStatus, errorThrown) {
                swal("Error !", 'Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown, "error");
                $('.form-control').attr('disabled', false);
            }
        });
    };
    
    function upload_photo(){
        var pictureFile=$('#pictureFile').val();
        $('#frm_upload_photo').ajaxForm({
            url:'<?=site_url('profile/upload_photo');?>',
            type: 'post',
            data:{"pictureFile":pictureFile},
            beforeSubmit: function() {
                $('.btn-upload-foto').html('<i class="fa fa-refresh fa-spin"></i> Silahkan Tunggu ... ');
            },
            success: function(resp) {
                $('.btn-upload-foto').html('Submit');
                var obj = jQuery.parseJSON(resp);
                if(obj.state==="1"){
                    swal({
                        title: "Success",
                        text: obj.msg,
                        type: "success"
                    }, function(){
                        location.reload();
                    });
                }else{
                    swal({
                        title: "Error!",
                        text: obj.msg,
                        type: "error"
                    }, function(){

                    });
                }
            },
            error: function(resp){
                swal("Error!",resp , "error");
                return false;
            }
        });     
    };
</script>