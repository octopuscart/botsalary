
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
<!-- Main content -->
<section class="content" ng-controller="pnlControllerEdit">
    <div class="">
        <div class="well well-sm">
            <form action="" method="get">
                <div class="form-group form-group-bg  row form-inline">
                    <label class="form-label col-form-label col-lg-2"><b>Financial Report</b><br/><small>Click on Calendar Icon</small></label>
                    <div class="col-lg-4">
                        <div class="input-group date" >
                            <select class="form-control" name="entry_date">
                                <option value="2021-04-01">2021-2022</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <button class="btn btn-success" type="submit" name="select_month" value="select_month">
                            <i class="fa fa-paragraph"></i>   GET REPORT
                        </button>


                    </div>
                </div>
            </form>
        </div>
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-sm btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                </div>
                <h3 class="panel-title"><?php echo $report_title; ?></h3>

            </div>

            <div class="panel-body " id='printArea'>
                <?php
                if ($report_data) {
                    ?>
                    <object data="<?php echo base_url(); ?>assets/reports/<?php echo $report_data["report_file"]; ?>" type="application/pdf" width="100%" height="750px">
                        <embed src="<?php echo base_url(); ?>assets/reports/<?php echo $report_data["report_file"]; ?>" type="application/pdf">
                        <p>This browser does not support PDFs. Please download the PDF to view it: <a href="<?php echo base_url(); ?>assets/reports/<?php echo $report_data["report_file"]; ?>">Download PDF</a>.</p>
                        </embed>
                    </object>
                    <?php
                } else {
                    echo "<h3>No report found.</h3>";
                }
                ?>
                <form action="#" method="post" enctype="multipart/form-data" class="col-md-4 well well-sm">

                    <input type="file" name="picture" required="" accept="application/pdf">
                    <hr/>
                    <button type="submit" name="submit" class="btn btn-warning" ><i class="fa fa-upload"></i> Upload File</button>

                </form>
            </div>
        </div>
    </div>
</section>
<!-- end col-6 -->





<script>
<?php
$time = strtotime($select_month);
$entry_month = date('m', $time);
$entry_year = date('Y', $time);
?>
    var entry_month = "<?php echo $entry_month; ?>";
    var entry_year = "<?php echo $entry_year; ?>";
</script>

<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-daterangepicker/moment.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

<script src="<?php echo base_url(); ?>assets/plugins/DataTables/js/jquery.dataTables.js"></script>
<script src="<?php echo base_url(); ?>assets/js/table-manage-default.demo.min.js"></script>
<script src="<?php echo base_url(); ?>assets/angular/accountController.js"></script>
<script>
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }

</script>
<?php
$this->load->view('layout/footer');
?> 


