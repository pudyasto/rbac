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
  
<div class="row">
    <!-- left column -->
    <div class="col-md-12">
      <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">{msg_main}</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <?php
            $attributes = array(
                'role=' => 'form'
                , 'id' => 'form_add'
                , 'name' => 'form_add');
            echo form_open($submit,$attributes); 
        ?> 
          <div class="box-body">
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <?php 
                            echo form_input($form['first_name']);
                            echo form_error('first_name','<div class="note">','</div>'); 
                        ?>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <?php 
                            echo form_input($form['last_name']);
                            echo form_error('last_name','<div class="note">','</div>'); 
                        ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <?php 
                    echo form_input($form['identity']);
                    echo form_error('identity','<div class="note">','</div>'); 
                ?>
            </div>
            <div class="form-group">
                <?php 
                    echo form_input($form['email']);
                    echo form_error('email','<div class="note">','</div>'); 
                ?>
            </div>
            <div class="form-group">
                <?php 
                    echo form_input($form['phone']);
                    echo form_error('phone','<div class="note">','</div>'); 
                ?>
            </div>
            <div class="form-group">
                <?php 
                    echo form_input($form['company']);
                    echo form_error('company','<div class="note">','</div>'); 
                ?>
            </div>
            <div class="form-group">
                <?php 
                    echo form_input($form['password']);
                    echo form_error('password','<div class="note">','</div>'); 
                ?>
            </div>
            <div class="form-group">
                <?php 
                    echo form_input($form['password_confirm']);
                    echo form_error('password_confirm','<div class="note">','</div>'); 
                ?>
            </div>
            <div class="form-group">
                <?php 
                    echo form_dropdown($form['group_id']['name'],$form['group_id']['data'] ,$form['group_id']['value'] ,$form['group_id']['attr']);
                    echo form_error('group_id','<div class="note">','</div>'); 
                ?>
            </div>
            <div class="form-group">
                <?php 
                    echo form_dropdown($form['active']['name'],$form['active']['data'] ,$form['active']['value'] ,$form['active']['attr']);
                    echo form_error('active','<div class="note">','</div>'); 
                ?>
            </div>  
          </div>
          <!-- /.box-body -->

          <div class="box-footer">
            <button type="submit" class="btn btn-primary">
                Save
            </button>
            <a href="<?php echo $reload;?>" class="btn btn-default">
                Cancel
            </a>    
          </div>
        <?php echo form_close(); ?>
      </div>
      <!-- /.box -->
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {

    });
</script>