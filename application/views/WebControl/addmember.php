<?php
$this->load->view('layout/header');
$this->load->view('layout/topmenu');
?>
<link href="<?php echo base_url(); ?>assets/plugins/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap3-editable/js/bootstrap-editable.min.js"></script>

<link href="<?php echo base_url(); ?>assets/plugins/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet"  />

<link href="<?php echo base_url(); ?>assets/plugins/jquery-file-upload/css/jquery.fileupload.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>assets/plugins/jquery-file-upload/css/jquery.fileupload-ui.css" rel="stylesheet" />

<section class="content">
    <div class="row">

        <!-- /.col -->
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"> <i class="fa fa-edit"></i>
                        <?php
                        if ($has_member == "no") {
                            echo "Add New Member";
                        } else {
                            echo "Update Member";
                        }
                        ?>


                    </h3>


                </div>
                <div class="panel-body ">
                    <div class="col-md-12"> 



                        <form method="post" action="#" align="left" enctype="multipart/form-data">  
                            <div class="col-md-4 well well-sm thumbnail">
                                <?php
                                if ($has_member == "no") {
                                    ?>
                                    <img src="<?php echo base_url(); ?>assets/default2.png" style="width:50%"/>
                                    <?php
                                } else {
                                    ?>
                                    <img src="<?php echo $member_data["image"]; ?>" style="width:50%"/>
                                    <?php
                                }
                                ?>
                                <div class="form-group">
                                    <label class="control-label col-form-label text-left col-md-12">Select Image of Member</label>
                                    <div class="input-group">
                                        <div class="btn-group" role="group" aria-label="..." >
                                            <span class="btn btn-success  fileinput-button" style="width:200px;">
                                                <i class="fa fa-plus"></i>
                                                <span>Add files...</span>
                                                <input type="file"  accept="image/*"  name="imagename" id="imagename" file-model="filename" required=""/>
                                            </span>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">

                                <div class="col-md-12"> 
                                    <div class="form-group">
                                        <label class="control-label" style="">Name</label>
                                        <input type="text" class=" form-control" required id="name" name="name"  value="<?php echo $member_data["name"]; ?>"  />

                                    </div>
                                </div> 
                                <div class="col-md-12"> 
                                    <div class="form-group">
                                        <label class="control-label" style="">Position</label>
                                        <input type="text" class=" form-control" required id="position" name="position" value="<?php echo $member_data["position"]; ?>"   />

                                    </div>
                                </div> 

                                <div class="col-md-12"> 
                                    <div class="form-group">
                                        <label class="control-label" style="">Display_index</label>
                                        <input type="text" class=" form-control" required id="display_index" name="display_index"  value="<?php echo $member_data["display_index"]; ?>"  />

                                    </div>
                                </div> 
                                <button name="submit" type="submit" name="submit" class="btn btn-warning" style="float: right" value="submit">Submit</button>

                            </div>



                        </form>
                    </div>
                </div>
            </div>
            <!-- /.col -->
        </div>

        <!-- /.row -->
</section>
<!-- /.content -->

<div style="clear:both"></div>
<?php
$this->load->view('layout/footer');
?>






