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

        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <b><?php echo $employee["name"]; ?></b>, EMP ID#: <?php echo $employee["employee_id"]; ?>, HK ID#: <?php echo $employee["hk_id"]; ?>
                <div class="btn-group pull-right">
              
                        <a href="<?php echo site_url("Salary/viewEmplyeeSalaryPDF/" . $employee["id"] . "/I"); ?>" class="btn btn-primary"><i class="fa fa-eye"></i> View PDF</a>
                    </div>
                
                </h3>
            </div>
            <div class="panel-body">
                <table class="table" id="tableData">
                    <thead>
                        <tr>
                            <th>S. No.</th>
                            <th>Salary Month</th>
                            <th>Base Salary</th>
                            <th>Net Salary</th>
                            <th>Employee MPF</th>
                            <th>Employer MPF</th>
                            <th style="width:100px"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $count = 1;
                        foreach ($salary as $key => $value) {

                            echo "<tr><td>$count</td>"
                            . "<td>" . date("M-Y", strtotime($value["salary_date"])) . "</td>"
                            . "<td>" . $value["base_salary"] . "</td>"
                            . "<td>" . $value["net_salary"] . "</td>"
                            . "<td>" . $value["mpf_employee"] . "</td>"
                            . "<td>" . $value["mpf_employer"] . "</td>";
                            echo "<td><a href='" . site_url("Salary/paySlip/" . $value["id"]) . "' class='btn btn-default'>Pay Slip</a></td>";

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


