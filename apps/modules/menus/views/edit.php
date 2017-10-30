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
                    echo form_input($form['id']);
                    echo form_input($form['name']);
                    echo form_error('name','<div class="note">','</div>'); 
                ?>
            </div>
            <div class="checkbox">
              <label>
                <?php
                    echo form_checkbox($form['chkmainmenu']);
                    echo "Main Menu <small>( Check if it's main menu )</small>";
                ?>
              </label>
            </div>
            <div class="form-group form-mainmenu">
                <?php
                    echo form_dropdown($form['mainmenuid']['name']
                            ,$form['mainmenuid']['data'] 
                            ,$form['mainmenuid']['value'] 
                            ,$form['mainmenuid']['attr']);
                    echo form_error('mainmenuid','<div class="note">','</div>'); 
                ?>
            </div>    
            <div class="form-group">
                <?php 
                    echo form_input($form['link']);
                    echo form_error('link','<div class="note">','</div>'); 
                ?>
            </div>
            <div class="form-group">
                <div class="input-group">
                <?php echo form_input($form['icon']);?>
                    <span class="input-group-btn">
                        <a class="btn btn-default" data-toggle="modal" href="#full"> Pilih Icon </a>
                    </span>
                </div>
                <?php 
                    echo form_error('icon','<div class="note">','</div>'); 
                ?>
            </div>
            <div class="form-group">
                <?php 
                    echo form_textarea($form['description']);
                    echo form_error('description','<div class="note">','</div>'); 
                ?>
            </div>
            <div class="form-group">
                <?php
                    echo form_dropdown($form['statmenu']['name']
                            ,$form['statmenu']['data'] 
                            ,$form['statmenu']['value'] 
                            ,$form['statmenu']['attr']
                            );
                    echo form_error('statmenu','<div class="note">','</div>'); 
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

<div class="modal fade" id="full" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-full">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Choose Menu Icons</h4>
            </div>
            <div class="modal-body"> 
                {fa_icons}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script type="text/javascript">
    $(document).ready(function () {
        show_main_menu();
        $("#chkmainmenu").click(function(){
            show_main_menu();
        });
        
        $(".fa-item").click(function(){
           var attr = $(this).html();
           var start = attr.indexOf('"');
           var res = attr.substring(start, attr.length);
           var end = res.indexOf('">');
           var fa = res.substring(1, end);
           $("#icon").val(fa);
           $("#full").modal('hide');
        });
    });
    
    function show_main_menu(){
        var link = "<?php echo $form['link']['value']; ?>";
        var mainmenuid = "<?php echo$form['mainmenuid']['value']; ?>";
        if($("#chkmainmenu").prop("checked")===true){
            $("#mainmenuid").attr('required', false)
                          .attr('disabled', true);
            $(".form-mainmenu").hide(); 
            $("#link").attr('readonly', true)
                      .attr('required', false)
                      .val("#");
        } else {
            $("#mainmenuid").attr('required', true)
                          .attr('disabled', false);
            $("#mainmenuid").val(mainmenuid);
            $(".form-mainmenu").show(); 
            $('#link').attr('readonly', false)
                      .attr('required', true)
                      .val(link);
        }              
    }
</script>