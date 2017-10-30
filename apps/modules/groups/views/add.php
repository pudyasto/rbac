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
            <div class="form-group">
                <?php 
                    echo form_input($form['name']);
                    echo form_error('name','<div class="note">','</div>'); 
                ?>
            </div>
            <div class="form-group">
                <?php 
                    echo form_textarea($form['description']);
                    echo form_error('description','<div class="note">','</div>'); 
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