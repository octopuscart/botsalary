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

    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Bot Members List 
        <a class="btn btn-primary pull-right" href="<?php echo site_url("WebControl/addMember/0");?>"><i class="fa fa-plus"></i> Add Member</a>
    </h1>
   
      
    <!-- end page-header -->

    <!-- begin panel -->
    <div class="panel panel-inverse">

        <div class="panel-body">
          
            <form action="#" method="post">

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
                                                onclick="confirmation('<?php echo site_url("Api/deleteRecordTable/content_bot_members/". $value["id"]); ?>')" >
                                            <i class="fa fa-trash"></i>
                                        </button>
                                        <a class="btn btn-warning  pull-right" 
                                                style="" 
                                                type="" href="<?php echo site_url("WebControl/addMember/". $value["id"]); ?>">
                  
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        
                                    </div>
                                    <p>Current Pos: <?php echo $key + 1; ?></p>
                                    <div class="image-thumbnail" style="background-image:url(<?php echo $value["image"]; ?>)">

                                    </div>
                                    <hr/>
                                    <b>
                                        <span  id="name" data-type="textarea" 
                                               data-pk="<?php echo $value["id"]; ?>" data-name="name" 
                                               data-value="<?php echo $value["name"]; ?>" 
                                               data-params ={'tablename':'content_bot_members'} 
                                               data-url="<?php echo site_url("LocalApi/updateCurd"); ?>" 
                                               data-mode="inline" class="m-l-5 editable editable-click" tabindex="-1" ><?php echo $value["name"]; ?>
                                        </span>
                                    </b>
                                    <input type="hidden" name="member_current_id[]" class="member_current_id" value="<?php echo $value["id"]; ?>"  />
                                    <input type="hidden" name="member_current_pos[]" class="member_current_pos"  value="<?php echo $value["display_index"]; ?>" />

                                    <p>
                                        <span  id="name" data-type="text" 
                                               data-pk="<?php echo $value["id"]; ?>" data-name="name" 
                                               data-value="<?php echo $value["position"]; ?>" 
                                               data-params ={'tablename':'content_bot_members'} 
                                               data-url="<?php echo site_url("LocalApi/updateCurd"); ?>" 
                                               data-mode="inline" class="m-l-5 editable editable-click" tabindex="-1" ><?php echo $value["position"]; ?>
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
                <div class="col-md-12">
                    <button class="btn btn-primary" name="submit_post" value="">Confirm Position</button>
                </div>
            </form>
        </div>
        <!-- end panel -->
    </div>
    <!-- end #content -->



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