<?php
$this->load->view('layout/header');
$this->load->view('layout/topmenu');
?>
<!-- ================== BEGIN PAGE CSS STYLE ================== -->
<link href="<?php echo base_url(); ?>assets/plugins/jquery-tag-it/css/jquery.tagit.css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/plugins/jquery-tag-it/js/tag-it.min.js"></script>

<link href="<?php echo base_url(); ?>assets/plugins/jquery-file-upload/css/jquery.fileupload.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>assets/plugins/jquery-file-upload/css/jquery.fileupload-ui.css" rel="stylesheet" />

<link href="<?php echo base_url(); ?>assets/plugins/bootstrap-wysihtml5/src/bootstrap-wysihtml5.css" rel="stylesheet" />

<!-- begin #content -->
<!-- begin #content -->
<div id="content" class="content content-full-width">

    <h1 class="page-header">
        Website Page
        <small></small>

        <?php if ($operation == "edit") { ?>
            <a href="<?php echo SITE_URL . "" . $pageobj["uri"] ?>" class="btn btn-primary" target="_block">View Page</a>
        <?php } ?>
    </h1>

    <!-- begin vertical-box -->
    <div class="vertical-box">
        <!-- begin vertical-box-column -->

        <!-- end vertical-box-column -->
        <!-- begin vertical-box-column -->
        <div class="vertical-box-column">

            <!-- begin wrapper -->
            <div class="wrapper ">
                <div class="p-30  bg-white">

                    <!-- begin email form -->
                    <form action="" method="post" class="row" id="update-form" >
                        <!-- begin email to -->


                        <!--tags-->
                        <label class="control-label"> Title</label>
                        <div class="m-b-15">
                            <input  class="form-control " id="pagetitle"  name="title" required="" value="<?php echo $pageobj["title"]; ?>"/>
                        </div>
                        <br/>

                        <?php if ($operation == "create") { ?>
                            <!--tags-->
                            <label class="control-label"> URI (Page Link Suffix)</label>
                            <div class="m-b-15">
                                <input  class="form-control "   name="uriname" required="" value="<?php echo $pageobj["uri"]; ?>"/>
                            </div>
                            <br/>
                            <!-- begin email content -->

                            <!--tags-->
                            <label class="control-label"> Page Type</label>
                            <div class="m-b-15">
                                <select  class="form-control "   name="page_type" required="" >
                                    <?php
                                    $options = array("main" => "Main Page", "sidebar" => "Side Bar Component");
                                    foreach ($options as $key => $value) {
                                        $selected = $value == $pageobj["uri"] ? "selected" : "";
                                        echo "<option $selected value='$key'>$value</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <br/>
                            <!-- begin email content -->
                        <?php } ?>
                        <div class="m-b-15 ">

                            <label class="control-label">Content:</label>
                            <textarea class=" form-control ckeditor"  name="content" id="pageContent"><?php echo $pageobj["content"]; ?></textarea>
                            <input type="hidden" name="pageId" id="pageId" value="<?php echo $pageId;?>">
                        </div>
                        <div class="m-b-15 col-md-12">
                            <!-- end email content -->
                            <button type="submit" name="update_data" id="udpate_data" class="btn btn-primary p-l-40 p-r-40">Save Page</button></div>
                    </form>
                    <!-- end email form -->
                </div>
            </div>
            <!-- end wrapper -->
        </div>
        <!-- end vertical-box-column -->
    </div>
    <div class="vertical-box">
        <?php if ($operation == "edit") { ?>
        <!-- begin vertical-box-column -->
        <div class="vertical-box-column">
            <!-- begin wrapper -->
            <div class="wrapper ">
                <div class="p-30  bg-white row">
                    <form action="#" method="post" >
                        <div class="well well-sm row">
                            <div class="col-md-6">
                                <label class="control-label"> Page Type</label>
                                <div class="m-b-15">
                                    <select  class="form-control "   name="component_id" required="" >
                                        <?php
                                        $options = array("main" => "Main Page", "sidebar" => "Side Bar Component");
                                        foreach ($pageData as $pkey => $pvalue) {
                                            $page_id = $pvalue["id"];
                                            $pageTitle = $pvalue["title"];
                                            echo "<option value='$page_id'>$pageTitle</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label"> &nbsp;</label>
                                <div class="m-b-15">
                                    <button type="submit" class="btn btn-success" name="add_component" value="">Add Component</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive col-md-12">

                        <table id="user" class="table table-bordered table-striped" >

                            <tbody>

                                <?php
                                foreach ($metaData as $key => $value) {
                                    ?>
                                    <tr>
                                        <td><?php echo $key + 1; ?></td>
                                        <td>
                                            <?php echo $value["title"]; ?>
                                        </td>
                                        <td>
                                            <?php echo $value["uri"]; ?>
                                        </td>
                                        <td>
                                            <?php echo $value["page_type"]; ?>
                                        </td>
                                        <td>
                                            <?php echo $value["template"]; ?>
                                        </td>
                                        <td>
                                            <a href="<?php echo site_url("WebControl/editPage/" . $value["id"]) ?>"  class="btn btn-warning">Update Page</a>
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
            <!-- end wrapper -->
        </div>
        <!-- end vertical-box-column -->
          <?php } ?>
    </div>
    <!-- end vertical-box -->
</div>
<!-- end #content -->


<?php
$this->load->view('layout/footer');
?>

<script src="<?php echo base_url(); ?>assets/plugins/ckeditor/ckeditor.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-wysihtml5/lib/js/wysihtml5-0.3.0.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-wysihtml5/src/bootstrap-wysihtml5.js"></script>
<script src="<?php echo base_url(); ?>assets/js/form-wysiwyg.demo.min.js"></script>


<script>
$(document).ready(function(){
			$("#update-form").submit(function(event) {
event.preventDefault();
				var data = $("#update-form").serialize();
				var url = "<?php echo site_url('LocalApi/pageUpdate'); ?>";

				// Syntax
				// $(selector).post(URL,data,function(data,status,xhr),dataType);
     
        CKEDITOR.instances["pageContent"].updateElement();
        
        
        $.ajax({
	            url: "<?php echo site_url('LocalApi/pageUpdate'); ?>",
	            data: $("#update-form").serialize(),
	            type: "post",
	            async: false,
	            dataType: 'json',
	            success: function(response){
	              
	              
	                alert('Successfully submitted');
                       window.location.reload();
	              
	              },
	           error: function()
	           {
	            alert("error");
	           }
          });
					
                                        });
		}); 


</script>

