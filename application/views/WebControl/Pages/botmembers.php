<?php
$this->load->view('layout/header');
$this->load->view('layout/topmenu');
?>
<!-- ================== BEGIN PAGE CSS STYLE ================== -->
<link href="<?php echo base_url(); ?>assets/plugins/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap3-editable/js/bootstrap-editable.min.js"></script>

<link href="<?php echo base_url(); ?>assets/plugins/jquery-tag-it/css/jquery.tagit.css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/plugins/jquery-tag-it/js/tag-it.min.js"></script>

<link href="<?php echo base_url(); ?>assets/plugins/jquery-file-upload/css/jquery.fileupload.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>assets/plugins/jquery-file-upload/css/jquery.fileupload-ui.css" rel="stylesheet" />

<!-- begin #content -->
<div id="content" class="content">
    <!-- begin breadcrumb -->

    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Bot Members List 

    </h1>
    <!-- end page-header -->

    <!-- begin panel -->
    <div class="panel panel-inverse">

        <div class="panel-body">


            <div class="table-responsive col-md-12">

                <table id="user" class="table table-bordered table-striped" >

                    <tbody>

                        <?php
                        foreach ($memberslist as $key => $value) {
                            ?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                 <td>
                                    <img src="<?php echo $value["image"]; ?>" width="100px" />
                                </td>
                                 <td>
                                    <?php echo $value["name"]; ?>
                                </td>
                               
                                <td>
                                    <?php echo $value["position"]; ?>
                                </td>
                                <td>
                                    <span  id="<?php echo $key; ?>bot" data-type="select" data-pk="<?php echo $value['id']; ?>" data-name="image" data-value="<?php echo $value["image"]; ?>" data-params ={'tablename':'content_bot_members'} data-url="<?php echo site_url("LocalApi/updateCurd"); ?>" data-mode="inline" class="m-l-5 editable editable-click botmemberimageselect" tabindex="-1" > <?php echo $value["image"]; ?></span>
                                </td>
                                
                            </tr>
                            <?php
                        }
                        ?>

                    </tbody>
                </table>
            </div>

        </div>
    </div>
    <!-- end panel -->
</div>
<!-- end #content -->

<!-- Modal -->
<div class="modal fade" id="add_item" tabindex="-1" role="dialog" aria-labelledby="changePassword">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">View Template</h4>
            </div>
            <div class="modal-body" style="overflow-y: auto;">
                <div id="templateviewer"></div>

            </div>

        </div>
    </div>
</div>


<?php
$this->load->view('layout/footer');
?>
<script>
    function openModelViewer(templateid) {
        $("#templateviewer").html($("#" + templateid).html());
    }

    $(function () {


 $('.botmemberimageselect').editable({
    source: {
<?php
$ns_type =$filesdata;
foreach ($ns_type as $key => $value) {
    ?>
        "<?php echo base_url(); ?>assets/content_files/<?php echo $value["file_name"]; ?>": "<?php echo $value["file_caption"]; ?>",
    <?php
}
?>
    }

    });

    
           
    });
</script>