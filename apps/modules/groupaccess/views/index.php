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
<!-- Basic Examples -->
<div class="row">
    <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <a href="<?=site_url('groups/index/');?>" class="btn btn-info"><i class="fa fa-arrow-left"></i> Back to Group</a>
            <button class="btn btn-default btn-refersh" type="button" >Refresh</button> 
            <div class="box-tools pull-right">
                <div class="btn-group">
                  <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-wrench"></i></button>
                  <ul class="dropdown-menu" role="menu">
                    <li>
                        <a href="<?=site_url('groups/index/');?>" ><i class="fa fa-arrow-left"></i> Back to Group</a>
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
                <input type="hidden" id="group_id" name="group_id" value="<?php echo $group_id;?>">
                <table class="table table-hover dataTable">
                    <thead>
                        <tr>
                            <th width="50">Access</th>
                            <th width="200">Main Menu</th>
                            <th >Sub Menu</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Access</th>
                            <th>Main Menu</th>
                            <th >Sub Menu</th>
                        </tr>
                    </tfoot>
                    <tbody></tbody>
                </table>
                <a href="<?=site_url('groups/index/');?>" class="btn btn-info"><i class="fa fa-arrow-left"></i> Back to Group</a>
                <button class="btn btn-default btn-refersh" type="button" >Refresh</button> 
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->

    </div>
</div>
<!-- #END# Basic Examples -->

                    

<script>
    $(document).ready(function() {
        var url = "<?=site_url('groupaccess/data_json_akses?uid='.$group_id) ?>";
        $(".btn-refersh").click(function(){
            table.ajax.reload();
        });
        
        table = $('.dataTable').DataTable({
            "bProcessing": true,
            "bServerSide": true,
            "columnDefs": [
                { "orderable": false, "targets": 0 }
            ],
            "order": [[ 1, "asc" ]],
            "pagingType": "simple",
            "sAjaxSource": url,
            "sDom": "<'row'<'col-sm-6'l><'col-sm-6 text-right'>r> t <'row'<'col-sm-6'i><'col-sm-6 text-right'p>> ",
            "oLanguage": {
                "sProcessing": "<i class=\"fa fa-refresh fa-spin\"></i> Silahkan tunggu..."
            }
        });
        
        $('.dataTable').tooltip({
            selector: "[data-toggle=tooltip]",
            container: "body"
        });

        $('.dataTable tfoot th').each( function () {
            var title = $('.dataTable thead th').eq( $(this).index() ).text();
            if(title!=="Access" && title!=="Edit" && title!=="Delete" ){
                $(this).html( '<input type="text" class="form-control input-sm" style="width:100%;border-radius: 0px;" placeholder="Cari '+title+'" />' );
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
    
    function set_submenu(menu_id) {  
        var group_id = $("#group_id").val();
        var submit = "<?=site_url('groupaccess/submit');?>";
        $.ajax({
            type: "POST",
            url: submit,
            data: {"group_id":group_id,"menu_id":menu_id,"privilege":"1,1,1","stat":"submenu"},
            success: function(resp){
                $("#ids").html(resp);
                table.ajax.reload();
              }
        });

    }

    function set_access(menu_id) {
        var group_id = $("#group_id").val();
        var submit = "<?=site_url('groupaccess/submit');?>";
        var T = "";
        var E = "";
        var H = "";
        var privilege = "0,0,0";
        if($("#T"+menu_id).prop("checked")) {
          T = "1";
        } else {
          T = "0";
        }
        if($("#E"+menu_id).is(":checked")) {
          E = "1";
        } else {
          E = "0";
        }
        if($("#H"+menu_id).is(":checked")) {
          H = "1";
        } else {
          H = "0";
        }
        privilege = T+","+E+","+H;
        $.ajax({
        type: "POST",
        url: submit,
        data:{"group_id":group_id,"menu_id":menu_id,"privilege":privilege,"stat":"access"},
        success: function(resp){
            table.ajax.reload();
          }
        });
    }    
</script>