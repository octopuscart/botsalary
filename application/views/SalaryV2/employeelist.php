<?php
$this->load->view('layout/header');
$this->load->view('layout/topmenu');
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/treejs/themes/default/style.min.css">
<!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
<link href="<?php echo base_url(); ?>assets/plugins/DataTables/css/data-table.css" rel="stylesheet" />
<!-- ================== END PAGE LEVEL STYLE ================== -->
<!-- ================== END PAGE LEVEL STYLE ================== -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/treejs/themes/default/style.min.css">

<script src="<?php echo base_url(); ?>assets/treejs/jstree.min.js"></script>
<link href="<?php echo base_url(); ?>assets/plugins/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet"  />



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
</style>
<!-- Main content -->
<section class="content" >
    <div class="">
        <div class="well well-sm">
            <form action="" method="get">
                <div class="form-group form-group-bg  row form-inline">
                    <label class="form-label col-form-label col-lg-2"><b>Salary Month</b><br/><small>Click on Calendar Icon</small></label>
                    <div class="col-lg-4">
                        <div class="input-group date" >
                            <input type="text" class="form-control" name="salary_date" style="background: white;
                                   opacity: 1;" readonly=""  autoclose="true" value="<?php echo $salary_date; ?>">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <button class="btn btn-success pull-right" type="submit" name="select_month" value="select_month">
                            <i class="fa fa-paragraph"></i>   GET REPORT
                        </button>

                    </div>
                </div>
            </form>
        </div>
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h3 class="panel-title">Select Employee</h3>
            </div>
            <div class="panel-body">
                <table class="table" id="tableData">
                    <thead>
                    <th>S. No.</th>
                    <th>Employee ID#</th>
                    <th>Name</th>
                    <th>Location</th>
                    <th>Salary</th>
                    <th style="width:100px"></th>
                    </thead>
                    <tbody>
                        <?php
                        $count = 1;
                        foreach ($employee as $key => $value) {
                            echo "<tr><td>$count</td>"
                            . "<td>" . $value["employee_id"] . "</td>"
                            . "<td>" . $value["name"] . "</td>"
                            . "<td>" . $value["location"] . "</td>"
                            . "<td>" . $value["net_salary"] . "</td>";
                            if ($value["has_salary"]) {
                                if ($createpermission) {
                                    echo "<td><a href='" . site_url("SalaryV2/create/" . $value["id"]) . "' class='btn btn-success'>Create Salary</a></td>";
                                }
                                else{
                                    echo "<td></td>";
                                }
                            } else {
                                echo "<td><a href='" . site_url("SalaryV2/paySlip/" . $value["salary_id"]) . "' class='btn btn-inverse'>Pay Slip</a></td>";
                            }
                            echo "</tr>";
                            $count++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>


        </div>



</section>
<!-- end col-6 -->



<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-daterangepicker/moment.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

<script src="<?php echo base_url(); ?>assets/plugins/DataTables/js/jquery.dataTables.js"></script>
<script src="<?php echo base_url(); ?>assets/js/table-manage-default.demo.min.js"></script>
<script src="<?php echo base_url(); ?>assets/tinymce/js/tinymce/tinymce.min.js"></script>
<script>
    $(function () {

        $('.input-group.date').datepicker({
            format: "M-yyyy",
            viewMode: "months",
            minViewMode: "months",
            todayHighlight: true,
            autoclose: true,
        })
    })
</script>


<script>
    $(function () {
        $('#tableData').DataTable({'pageLength': 50});
    })
</script>


<script src="<?php echo base_url(); ?>assets/plugins/DataTables/js/jquery.dataTables.js"></script>
<script src="<?php echo base_url(); ?>assets/js/table-manage-default.demo.min.js"></script>
<script src="<?php echo base_url(); ?>assets/tinymce/js/tinymce/tinymce.min.js"></script>
<?php
$this->load->view('layout/footer');
?> 


