<?php
$this->load->view('layout/header');
$this->load->view('layout/topmenu');
?>


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

                        <a class="btn btn-success" href="<?php echo site_url("SalaryV2/allowanceReportsXls") . "?salary_date=$select_month"; ?>">
                            <i class="fa fa-print"></i>   EXPORT REPORT
                        </a>
                        <button class="btn btn-success" type="button"  onclick="printDiv2('printArea2')">
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
            <div class="panel-body " id='printArea2'  >

                <?php
                $this->load->view('SalaryV2/allowanceReportsBase', array("salary_report" => $salary_report, "salary_month_str" => $salary_month_str, "remark" => false));
                ?>
            </div>


        </div>

    </div>

</section>
<!-- end col-6 -->







<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-daterangepicker/moment.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

<script>
                            function printDiv2(divName) {
                                var printContents = document.getElementById(divName).innerHTML;
                                var originalContents = document.body.innerHTML;
                                var printwindow = window.open('', '_blank', 'fullscreen=yes');
                                printwindow.document.write(printContents);
                                printwindow.print();

                            }
                            $(function () {

                                $('.input-group.date').datepicker({
                                    format: "M-yyyy",
                                    viewMode: "months",
                                    minViewMode: "months",
                                    todayHighlight: true,
                                    autoclose: true
                                });

                            });



</script>
<?php
$this->load->view('layout/footer');
?> 


