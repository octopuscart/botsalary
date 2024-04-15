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
<style>
    .sort-item-image .thumbnail{
        height:350px;
    }
    .image-thumbnail{
        height:150px;
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
    }
</style>
<!-- begin #content -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <h4>Select Gallery</h4>
    <div class="well well-sm">
    <?php
    foreach ($album_list as $key => $value) {
      ?>
        <a href="<?php echo site_url("WebControl/galleryImageList/".$value["id"]);?>" class="btn  <?php echo $album_id ==$value["id"]?"btn-success":"btn-default" ?> m-t-3"><?php   echo $value["title"];?></a>
          <?php
    }
    ?>
</div>
    <!-- end breadcrumb -->
    <form action="#" method="post">
        <!-- begin page-header -->
        <h1 class="page-header">Gallery Image List
            <button type="button" class="btn btn-primary p-l-40 p-r-40 pull-right" data-toggle="modal" data-target="#add_image_item"><i class="fa fa-plus"></i> Add New Image</button>

            <button class="btn btn-warning pull-right m-r-5" name="submit_post" value="">Confirm Position</button>

        </h1>


        <!-- end page-header -->

        <!-- begin panel -->
        <div class="panel panel-inverse">

            <div class="panel-body">



                <div class="table-responsive col-md-12">

                    <div  id="sortable" class="row" >


                        <?php
                        foreach ($memberslist as $key => $value) {
                            ?>
                            <div class="sort-item-image col-md-3 ">
                                <div class="thumbnail">
                                    <div class="col-md-12 " style="    padding: 5px;
                                         background: #ddd;">
                                        <button class="btn btn-danger pull-left" 
                                                style="" 
                                                type="button" 
                                                onclick="confirmation('<?php echo site_url("Api/deleteRecordTable/content_photo_gallery/" . $value["id"]); ?>')" >
                                            <i class="fa fa-trash"></i>
                                        </button>
                                  

                                    </div>
                                    <p>Current Pos: <?php echo $key + 1; ?></p>
                                    <div class="image-thumbnail" style="background-image:url(<?php echo base_url("assets/photo-gallery/" . $value["file_name"]); ?>)">

                                    </div>
                                    <hr/>

                                    <input type="hidden" name="member_current_id[]" class="member_current_id" value="<?php echo $value["id"]; ?>"  />
                                    <input type="hidden" name="member_current_pos[]" class="member_current_pos"  value="<?php echo $value["display_index"]; ?>" />

                                    <p>
                                        <span  id="name" data-type="text" 
                                               data-pk="<?php echo $value["id"]; ?>" data-name="name" 
                                               data-value="<?php echo $value["file_caption"]; ?>" 
                                               data-params ={'tablename':'content_bot_members'} 
                                               data-url="<?php echo site_url("LocalApi/updateCurd"); ?>" 
                                               data-mode="inline" class="m-l-5 editable editable-click" tabindex="-1" ><?php echo $value["file_caption"]; ?>
                                        </span>

                                    </p>
                                    <p>Updated Pos:  <span class="current-pos" ></span></p>

                                </div>
                            </div>
                            <?php
                        }
                        ?>


                        </ul>
                    </div>

                </div>


            </div>
            <!-- end panel -->
        </div>
        <!-- end #content -->

    </form>
</div>
<!-- Modal -->
<div class="modal fade" id="add_image_item" tabindex="-1" role="dialog" aria-labelledby="add_image_item">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form action="#" method="post" enctype="multipart/form-data" class="">
                <div class="col-md-12 well well-sm thumbnail">
                    <label class="control-label"> File Caption</label>
                    <input type="text" name="fileName" class="form-control" required="" >
                    <br/>
                    <input type="hidden" name="fileCategory" class="form-control" required=""  value="<?php echo $album_id?>">
                    <br/>
                    <img src="<?php echo base_url(); ?>assets/default2.png" style="width:50%"/>


                    <br/>
                    <input type="file" name="fileData" required="" accept="image/jpeg,image/jpg,image/png" id="imagename" file-model="filename">
                    <hr/>
                    <button type="submit" name="submit" class="btn btn-warning" ><i class="fa fa-upload"></i> Upload File</button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                </div>
            </form>
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


</script>

<script>
    function getElementNo() {
        $(".current-pos").each(function (i) {
            $($(".member_current_pos").get(i)).val(i);
            $(this).html(i + 1);
        })
    }
    $(function () {
        $("#sortable").sortable({
            revert: true,
            create: function (event, ui) {
                getElementNo();
            },
            stop: function (event, ui) {
                getElementNo();
            }
        });

        $(".editable").editable();

    });

    function confirmation(executableLink) {
        var result = confirm("Are you sure to delete?");
        if (result) {
            $.get(executableLink).then(function () {
                window.location.reload();
            });
        }
    }
</script>