
<?php
$this->load->view('layout/header');
$this->load->view('layout/topmenu');
?>

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/treejs/themes/default/style.min.css">
<!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
<link href="<?php echo base_url(); ?>assets/plugins/DataTables/css/data-table.css" rel="stylesheet" />
<!-- ================== END PAGE LEVEL STYLE ================== -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/treejs/themes/default/style.min.css">

<script src="<?php echo base_url(); ?>assets/treejs/jstree.min.js"></script>
<link href="<?php echo base_url(); ?>assets/plugins/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet"  />

<link href="<?php echo base_url(); ?>assets/plugins/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap3-editable/js/bootstrap-editable.min.js"></script>


<link href="<?php echo base_url(); ?>assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>assets/plugins/bootstrap-eonasdan-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />

<style>
    .product_image{
        height: 200px!important;
    }
    .product_image_back{
        background-size: contain!important;
        background-repeat: no-repeat!important;
        height: 200px!important;
        background-position-x: center!important;
        background-position-y: center!important;
    }
    .primarytext{
        font-size: 15px;
    }
    .pnlnotetable{
        margin: 0px;

    }
    .pnlnotetable .headtdleft{
        padding-left: 70px;
        width:300px;
    }
</style>
<style>
    .tooltip {
        position: relative;
        display: inline-block;
    }

    .tooltip .tooltiptext {
        visibility: hidden;
        width: 140px;
        background-color: #555;
        color: #fff;
        text-align: center;
        border-radius: 6px;
        padding: 5px;
        position: absolute;
        z-index: 1;
        bottom: 150%;
        left: 50%;
        margin-left: -75px;
        opacity: 0;
        transition: opacity 0.3s;
    }

    .tooltip .tooltiptext::after {
        content: "";
        position: absolute;
        top: 100%;
        left: 50%;
        margin-left: -5px;
        border-width: 5px;
        border-style: solid;
        border-color: #555 transparent transparent transparent;
    }

    .tooltip:hover .tooltiptext {
        visibility: visible;
        opacity: 1;
    }
</style>
<!-- Main content -->
<section class="content" ng-controller="pnlControllerEdit">
    <div class="">

        <div class="panel panel-inverse">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-sm btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                </div>
                <h3 class="panel-title">Upload Files</h3>
            </div>

            <div class="panel-body " id='printArea'>

                <form action="#" method="post" enctype="multipart/form-data" class="col-md-4 well well-sm">
                    <label class="control-label"> File Caption</label>
                    <input type="text" name="fileName" class="form-control" required="" >
                    <br/>
                    <select name="fileCategory" class="form-control" required="" >
                        <?php
                        foreach ($filescategorydata as $key => $value) {
                            ?>
                            <option><?php echo $value["meta_value"]; ?></option>
                            <?php
                        }
                        ?>

                    </select>

                    <br/>
                    <input type="file" name="fileData" required="" accept="image/jpeg,image/jpg,image/png,application/pdf">
                    <hr/>
                    <button type="submit" name="submit" class="btn btn-warning" ><i class="fa fa-upload"></i> Upload File</button>

                </form>
            </div>
        </div>

        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h3 class="panel-title">Files</h3>
            </div>
            <div class="panel-body">
                  <table class="table" id="tableData">
                    <thead>
                    <th>S. No.</th>
                    <th>Image</th>
                    <th>Caption</th>
                    <th>Category</th>
                    <th>DateTime</th>
                    <th style="width:250px"></th>
                    </thead>
                    <tbody>
                        <?php
                        $count = 1;
                        foreach ($filesdata as $key => $value) {
                            echo "<tr><td>$count</td>"
                            . "<td><img src='".  base_url() ."assets/content_files/" . $value["file_name"] . "' height='50px' width='50px;'></td>"
                            . "<td>" . $value["file_caption"] . "</td>"
                            . "<td>" . $value["file_category"] . "</td>"
                            . "<td>" . $value["datetime"] . "</td>";
                            ?>
                        <td >
                        <button class='btn btn-warning' onclick="myFunction('<?php echo base_url(); ?>assets/content_files/<?php echo $value["file_name"]; ?>')" onmouseout="outFunc()">
                            Copy File URL
                        </button>
                        </td>
                        <?php
                        echo "</tr>";
                        $count++;
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<!-- end col-6 -->






<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-daterangepicker/moment.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

<script src="<?php echo base_url(); ?>assets/plugins/DataTables/js/jquery.dataTables.js"></script>
<script src="<?php echo base_url(); ?>assets/js/table-manage-default.demo.min.js"></script>
<script>

                        $(function () {

                        })
</script>
<script>
    function myFunction(inputtxt) {
     
        navigator.clipboard.writeText(inputtxt);

  
          alert("Copied the text: " + inputtxt);
    }

    function outFunc() {
    }
</script>
<?php
$this->load->view('layout/footer');
?> 


