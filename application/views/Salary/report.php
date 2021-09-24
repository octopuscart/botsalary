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
                                   opacity: 1;" readonly=""  autoclose="true" value="<?php echo $select_month; ?>">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <button class="btn btn-success" type="submit" name="select_month" value="select_month">
                            <i class="fa fa-paragraph"></i>   GET REPORT
                        </button>
                        <button class="btn btn-success" type="button" name="select_month" value="select_month" onclick="printDiv('printArea')">
                            <i class="fa fa-print"></i>   PRINT REPORT
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h3 class="panel-title">Salary Report</h3>
            </div>
            <div class="panel-body " id='printArea'>
                <table class="table table-bordered" style="color:black">
                    <thead>

                    <th>S. No.</th>

                    <th style="width:200px">Name</th>
                    <th>Basic Salary</th>
                    <th>Dedu.</th>
                    <th >Allow.</th>
                    <th>Adjst.</th>
                    <th>Gross Salary</th>
                    <th>MPF Employee</th>

                    <th>Net Salary</th>
                    <th>MPF Employer</th>
                    <th>Total MPF</th>

              
                    </thead>
                    <tbody>
                        <?php
                        $temp_basic_salary_t2 = 0;
                        $mpf_deduction_t2 = 0;
                        $allownce_mpf_t2 = 0;
                        $allownce_no_mpf_t2 = 0;
                        $gross_salary_t2 = 0;
                        $mpf_employee_t2 = 0;
                        $net_salary_t2 = 0;
                        $mpf_employer_t2 = 0;
                        $total_mpf_t2 = 0;
                        foreach ($salary_report as $lkey => $lvalue) {
                            ?>
                            <tr style="background:orange;
                                    color: black;">
                                <th colspan="13" style="background:orange;
                                    color: black;">
                                    <?php echo $lvalue["location"] ?>
                                </th>
                            <tr/>   

                            <?php
                            $count = 1;
                            $temp_basic_salary_t = 0;
                            $mpf_deduction_t = 0;
                            $allownce_mpf_t = 0;
                            $allownce_no_mpf_t = 0;
                            $gross_salary_t = 0;
                            $mpf_employee_t = 0;
                            $net_salary_t = 0;
                            $mpf_employer_t = 0;
                            $total_mpf_t = 0;
                            foreach ($lvalue["salary"] as $skey => $svalue) {
                                ?>
                                <tr>

                                    <td><?php echo $count; ?></td>

                                    <td>
                                        <?php
                                        echo $svalue["employee"]["name"];
                                        ?>
                                        <br>
                                        <small> <?php
                                            echo $svalue["employee"]["employee_id"];
                                            ?></small>
                                    </td>
                                    <td>
                                        <?php
                                        $temp_basic_salary = $svalue["base_salary"];
                                        echo $temp_basic_salary;
                                        $temp_basic_salary_t += $temp_basic_salary;
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $mpf_deduction = $svalue["deduction_mpf"] ? $svalue["deduction_mpf"] : 0;
                                        $no_mpf_deduction = $svalue["deduction_no_mpf"] ? $svalue["deduction_no_mpf"] : 0;
                                        $total_deduction = $mpf_deduction + $no_mpf_deduction;
                                        echo $total_deduction ? "<span class='text-danger'>($total_deduction)</span>" : "";
                                        $mpf_deduction_t += ($mpf_deduction + $no_mpf_deduction);
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $allownce_mpf = $svalue["allownce_mpf"];
                                        echo $allownce_mpf;
                                        $allownce_mpf_t += $allownce_mpf;
                                        ?> 
                                    </td>
                                    <td>
                                        <?php
                                        $allownce_no_mpf = $svalue["allownce_no_mpf"];
                                        echo $allownce_no_mpf;
                                        $allownce_no_mpf_t += $allownce_no_mpf;
                                        ?> 
                                    </td>
                                    <td>
                                        <?php
                                        $gross_salary = $svalue["gross_salary"];
                                        echo $gross_salary;
                                        $gross_salary_t += $gross_salary;
                                        ?> 
                                    </td>
                                    <td>
                                        <?php
                                        $mpf_employee = $svalue["mpf_employee"];
                                        echo "<span class='text-danger'>($mpf_employee)</span>";
                                        $mpf_employee_t += $mpf_employee;
                                        ?> 
                                    </td>
                                    <td>
                                        <?php
                                        $net_salary = $svalue["net_salary"];
                                        echo $net_salary;
                                        $net_salary_t += $net_salary;
                                        ?> 
                                    </td>
                                    <td>
                                        <?php
                                        $mpf_employer = $svalue["mpf_employer"];
                                        echo $mpf_employer;
                                        $mpf_employer_t += $mpf_employer;
                                        ?> 
                                    </td>
                                    <td>
                                        <?php
                                        echo $mpf_employer + $mpf_employee;
                                        $total_mpf_t += $mpf_employer + $mpf_employee;
                                        ?> 
                                    </td>
                                 
                                </tr>


                                <?php
                                $count++;
                            }

                            $temp_basic_salary_t2 += $temp_basic_salary_t;
                            $mpf_deduction_t2 += $mpf_deduction_t;
                            $allownce_mpf_t2 += $allownce_mpf_t;
                            $allownce_no_mpf_t2 += $allownce_no_mpf_t;
                            $gross_salary_t2 += $gross_salary_t;
                            $mpf_employee_t2 += $mpf_employee_t;
                            $net_salary_t2 += $net_salary_t;
                            $mpf_employer_t2 += $mpf_employer_t;
                            $total_mpf_t2 += $total_mpf_t;

                            $totalarray = [$temp_basic_salary_t,
                                $mpf_deduction_t,
                                $allownce_mpf_t,
                                $allownce_no_mpf_t,
                                $gross_salary_t,
                                $mpf_employee_t,
                                $net_salary_t,
                                $mpf_employer_t,
                                $total_mpf_t,];
                            ?><tr style="background: #ffffff;
                                color: black;
                                border-top: 3px solid #000;
                                border-bottom: 3px solid #ff5722;">
                                <th colspan="2">TOTAL</th>
                                <?php
                                foreach ($totalarray as $key => $value) {
                                    echo "<th>$value</th>";
                                }
                                ?>
                          

                            </tr>
                            <?php
                        }

                        $totalarray2 = [$temp_basic_salary_t2,
                            $mpf_deduction_t2,
                            $allownce_mpf_t2,
                            $allownce_no_mpf_t2,
                            $gross_salary_t2,
                            $mpf_employee_t2,
                            $net_salary_t2,
                            $mpf_employer_t2,
                            $total_mpf_t2,];
                        ?><tr style="background: #ffffff;
                            color: black;font-size: 13px;
                            border-top: 3px solid #000;
                            border-bottom: 3px solid #ff5722;">
                            <th colspan="2">GRAND TOTAL</th>
                            <?php
                            foreach ($totalarray2 as $key => $value) {
                                echo "<th>$value</th>";
                            }
                            ?>
                       

                        </tr>
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
<script src="<?php echo base_url(); ?>assets/tinymce/js/tinymce/tinymce.min.js"></script>
<script>
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }
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
<?php
$this->load->view('layout/footer');
?> 


