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
        <div class="box">
          <div class="box-header">
            <a href="<?php echo $add;?>" <?php echo $this->access->module_access('add');?> class="btn btn-primary">Add</a>
            <a href="javascript:void(0);" class="btn btn-default btn-refersh">Refresh</a>
            <div class="box-tools pull-right">
                <div class="btn-group">
                  <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-wrench"></i></button>
                  <ul class="dropdown-menu" role="menu">
                    <li>
                        <a href="<?php echo $add;?>" <?php echo $this->access->module_access('add');?>>Add New Record</a>
                    </li>
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
                            <th style="width: 250px;text-align: center;">First Name</th>
                            <th style="width: 250px;text-align: center;">Last Name</th>
                            <th style="text-align: center;">Email</th>
                            <th style="width: 100px;text-align: center;">Grup</th>
                            <th style="width: 120px;text-align: center;">Status</th>
                            <th style="width: 10px;text-align: center;">Edit</th>
                            <th style="width: 10px;text-align: center;">Delete</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Grup</th>
                            <th>Status</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </tfoot>
                    <tbody></tbody>
                </table>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->

    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $(".btn-refersh").click(function(){
            table.ajax.reload();
        });
        
        table = $('.dataTable').DataTable({
            "bProcessing": true,
            "bServerSide": true,
            "columnDefs": [
                { "orderable": false, "targets": 3 },
                { "orderable": false, "targets": 4 }
            ],
            "pagingType": "simple",
            "sAjaxSource": "<?=site_url('users/json_dgview');?>",
            "sDom": "<'row'<'col-sm-6'l><'col-sm-6 text-right'>r> t <'row'<'col-sm-6'i><'col-sm-6 text-right'p>> ",
            "oLanguage": {
                "sProcessing": "<i class=\"fa fa-refresh fa-spin\"></i> Please Wait ..."
            }
        });
        
        $('.dataTable').tooltip({
            selector: "[data-toggle=tooltip]",
            container: "body"
        });

        $('.dataTable tfoot th').each( function () {
            var title = $('.dataTable thead th').eq( $(this).index() ).text();
            if(title!=="Edit" && title!=="Delete" ){
                $(this).html( '<input type="text" class="form-control input-sm" style="width:100%;border-radius: 0px;" placeholder="Search '+title+'" />' );
            }else{
                $(this).html( '' );
            }
        } );

        table.columns().every( function () {
            var that = this;
            $( 'input', this.footer() ).on( 'keyup change', function (ev) {
                //if (ev.keyCode == 13) { //only on enter keypress (code 13)
                    that
                        .search( this.value )
                        .draw();
                //}
            } );
        });
    });
    
    function refresh(){
        table.ajax.reload();
    }
    
    function deleted(id){
        swal({
            title: "Confirm Delete !",
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
                            table.ajax.reload();
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