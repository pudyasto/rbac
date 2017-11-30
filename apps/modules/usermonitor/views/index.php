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
    <div class="col-xs-12">
        <div class="alert alert-info">
            <strong>This Not Perfect Yet !</strong>
            <p>
                I try to make this data is server side, but I'm not sure about searching feature.
                Cause I just extract data from ci_sessions table using <b>serialize</b> and <b>unserialize</b> method.
            </p>
            <p>
                Maybe you can optimize and give me solution about this :D.
            </p>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <div class="col-sm-12">
                <div class="checkbox">
                  <label>
                      <input type="checkbox" value="true" id="chkAutorefresh" name="chkAutorefresh" checked=""> <span id="lblAutorefresh">Auto Refersh In 30 Seconds</span>
                  </label>
                </div>
            </div>              
            <div class="box-tools pull-right">
                <div class="btn-group">
                  <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-wrench"></i></button>
                  <ul class="dropdown-menu" role="menu">
                    <li>
                        <a href="javascript:void(0);" class="btn-refersh">Refresh</a>
                    </li>
                  </ul>
                </div>
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
                <table class="table table-hover dataTable" width="100%">
                    <thead>
                        <tr>
                            <th style="width: 130px;text-align: center;">Last Login</th>
                            <th style="text-align: center;">Username</th>
                            <th style="width: 100px;text-align: center;">IP Address</th>
                            <th style="text-align: center;">Browser</th>
                            <th style="width: 100px;text-align: center;">Platform</th>
                            <th style="width: 10px;text-align: center;">Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <tr>
                            <th style="width: 130px;text-align: center;">Last Login</th>
                            <th style="text-align: center;">Username</th>
                            <th style="width: 100px;text-align: center;">IP Address</th>
                            <th style="text-align: center;">Browser</th>
                            <th style="width: 100px;text-align: center;">Platform</th>
                            <th style="width: 10px;text-align: center;">Action</th>
                        </tr>
                    </tfoot>
                </table>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->

    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#lblAutorefresh").html('Auto Refersh In 30 Seconds');
        var seconds = 30;
        setInterval(function(){  
            if ($('#chkAutorefresh').is(':checked')) {
                if(seconds<=0){
                    seconds = 30;
                    table.ajax.reload();
                }
                $("#lblAutorefresh").html('Auto Refersh In '+seconds+' Seconds');
                seconds--;
            }
        }, 1000);
        
        $(".btn-refersh").click(function(){
            table.ajax.reload();
        });
        
        table = $('.dataTable').DataTable({
            "bProcessing": true,
            "bServerSide": true,
            "columnDefs": [
                { "orderable": false, "targets": 5 }
            ],
            "pagingType": "simple",
            "sAjaxSource": "<?=site_url('usermonitor/json_dgview');?>",
            "sDom": "<'row'<'col-sm-6'l><'col-sm-6 text-right' f>r> t <'row'<'col-sm-6'><'col-sm-6 text-right'p>> ",
            "oLanguage": {
                "sProcessing": "<i class=\"fa fa-refresh fa-spin\"></i> Please Wait ..."
            }
        });
        
        $('.dataTable').tooltip({
            selector: "[data-toggle=tooltip]",
            container: "body"
        });
    });
    
    function refresh(){
        table.ajax.reload();
    }
    
    function logout_user(id){
        swal({
            title: "Confirm Logout User !",
            text: "Deleted data can't undone!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#c9302c",
            confirmButtonText: "Yes, I'm sure!",
            cancelButtonText: "No, I'm not sure!",
            closeOnConfirm: false
        }, function () {
            var submit = "<?php echo $submit;?>"; 
                $.ajax({
                    type: "POST",
                    url: submit,
                    data: {"<?=$csrf['name'];?>":"<?=$csrf['hash'];?>"
                        ,"id":id,"stat":"delete"},
                    success: function(resp){   
                        var obj = jQuery.parseJSON(resp);
                        if(obj.state==="1"){
                            swal({
                                title: "Deleted",
                                text: obj.msg,
                                type: "success"
                            }, function(){
                                location.reload();
                            });
                        }else{
                            swal("Deleted!", obj.msg, "error");
                        }
                    },
                    error:function(event, textStatus, errorThrown) {
                        swal("Error !", 'Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown, "error");
                    }
                });
        });
    }
</script>