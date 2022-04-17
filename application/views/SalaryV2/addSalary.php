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
    .form-group-bg {

        background: #f9f9f9;
        padding: 8px 0px;
        margin: 5px 0px;
    }
</style>
<!-- Main content -->
<section class="content" ng-controller="salaryController">
    <div class="">

        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h3 class="panel-title">Create Salary For Employee ID/HKID: #<?php echo $employee["employee_id"]; ?></h3>
            </div>
            <div class="panel-body">
                <form action="#" method="post" enctype="multipart/form-data">

                    <div class="col-md-6">

                        <?php echo $this->session->flashdata('success_msg'); ?>
                        <?php echo $this->session->flashdata('error_msg'); ?>
                        <div class="row">
                            <div class="col-md-12">  
                                <div class="form-group form-group-bg">
                                    <h3>
                                        <?php echo $employee["name"]; ?><br/>
                                        <small>Employee ID: #<?php echo $employee["employee_id"]; ?></small>
                                    </h3>

                                </div>
                            </div>
                        </div>
                        <div class="well well-sm">
                            <div class="form-group form-group-bg  row form-inline">
                                <label class="form-label col-form-label col-lg-6"><b>Salary Date</b><br/><small>Click on Calendar Icon</small></label>
                                <div class="col-lg-6">
                                    <div class="input-group date" >
                                        <input type="text" class="form-control" name="salary_date" style="background: white;
                                               opacity: 1;" readonly=""  autoclose="true" value="<?php echo $c_period['salary_date']; ?>">
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-th"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group form-group-bg  row form-inline">
                                <label class="form-label col-form-label col-lg-6"><b>MPF Contribution Date</b><br/><small>Click on Calendar Icon</small></label>
                                <div class="col-lg-6">
                                    <div class="input-group date" >
                                        <input type="text" class="form-control" name="mpf_date" style="background: white;
                                               opacity: 1;" readonly=""  autoclose="true" value="<?php echo $c_period['mpf_date']; ?>">
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-th"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group form-group-bg  row form-inline" >
                                <label style="width:250px " class="col-md-6"><b>Basic Salary</b><br/><small>Add Basic Salary Here</small></label>
                                <input type="number"  step="any"  class="form-control col-md-6" name="salary" ng-model="salaryData.basic_salary" min="0"  ng-change="calculateSalary()" aria-describedby="emailHelp" placeholder="" required="" />
                            </div>
                            <div class="form-group form-group-bg  row form-inline" >
                                <label style="width:250px"  class="col-md-6"><b>Deduction</b><br/><small>Total Deduction</small></label>
                                <input type="number"  step="any"  class="form-control col-md-6" name="deduction"  ng-model="salaryData.duduction" min="0" max="{{salaryData.basic_salary}}"  ng-change="calculateSalary()"  aria-describedby="emailHelp" placeholder="" required="" />
                            </div>
                            <div class="form-group form-group-bg  row" >
                                <label style="width:250px"  class="col-md-6"><b>Deduction Note</b></label>
                                <input type="text" class="form-control col-md-6" name="deduction_note"  ng-model="salaryData.duduction_note" min="0" max="{{salaryData.basic_salary}}"  ng-change="calculateSalary()"  aria-describedby="emailHelp" placeholder=""  />
                            </div>
                        </div>
                        <div class="well well-sm">
                            <div class="form-group form-group-bg row form-inline" ng-repeat="allownces in salaryData.allowances" ng-if="allownces.apply_mpf == 'No'">
                                <label style="width:250px"  class="col-md-6"><input ng-change="checkAllowance(allownces, $index)" type="checkbox" ng-model="allownces.status" style="    margin-right: 8px;"><b>{{allownces.title}}</b> <br/>
                                    <small  >Not Calculate In MPF</small>
                                </label>
                                <input type="hidden" class="form-control col-md-6" name="allowance_title_no_mpf[]"   placeholder="" ng-model="allownces.title" value="{{allownces.title}}" ng-disabled="!allownces.status" ng-change="calculateSalary()"  />
                                <input type="number"  step="any"  class="form-control col-md-6" name="allowance_amount_no_mpf[]" min='0'  placeholder="" ng-model="allownces.value" required="" ng-disabled="!allownces.status" ng-change="calculateSalary()" ng-model-options="{
                                                        getterSetter: true}" />
                            </div>
                            <hr/>
                            <div class="form-group form-group-bg row form-inline" ng-repeat="allownces in salaryData.allowances" ng-if="allownces.apply_mpf == 'Yes'">
                                <label style="width:250px"  class="col-md-6"><input ng-change="checkAllowance(allownces, $index)" type="checkbox" ng-model="allownces.status" style="    margin-right: 8px;"><b>{{allownces.title}}</b> <br/>
                                    <small  >Calculate In MPF</small>
                                </label>
                                <input type="hidden" class="form-control col-md-6" name="allowance_title_mpf[]"   placeholder="" value="{{allownces.title}}" ng-disabled="!allownces.status"   />
                                <input type="number"  step="any"  class="form-control col-md-6" name="allowance_amount_mpf[]" min='0'  placeholder="" ng-model="allownces.value" required="" ng-disabled="!allownces.status" ng-change="calculateSalary()" ng-model-options="{
                                                        getterSetter: true}" />
                            </div>

                        </div>
                        <div class="well well-sm">

                            <div class="form-group form-group-bg  row form-inline" >
                                <label style="width:250px"  class="col-md-6"><b>Loan/Other Deduction</b><br/><small>Total Deduction</small></label>
                                <input type="number"  step="any"  class="form-control col-md-6" name="deduction_loan"  ng-model="salaryData.other_duduction" min="0"   ng-change="calculateSalary()"  aria-describedby="emailHelp" placeholder="" required="" />
                            </div>
                            <div class="form-group form-group-bg  row" >
                                <label style="width:250px"  class="col-md-6"><b>Deduction Note</b></label>
                                <input type="text" class="form-control col-md-6" name="deduction_loan_note"  ng-model="salaryData.other_duduction_note" min="0" max="{{salaryData.basic_salary}}"  ng-change="calculateSalary()"  aria-describedby="emailHelp" placeholder=""  />
                            </div>
                        </div>
                        <input type="hidden" name="base_salary" value="{{salaryData.basic_salary.toFixed(2)}}">
                        <input type="hidden" name="net_salary" value="{{salaryData.net_salary}}">
                        <input type="hidden" name="gross_salary" value="{{salaryData.gross_salary}}">
                        <input type="hidden" name="mpf_employee" value="{{salaryData.mpf_employee}}">
                        <input type="hidden" name="mpf_employer" value="{{salaryData.mpf_employer}}">
                        <br/>
                        <button type="submit" name="submit" value="submit"  class="btn btn-primary">Submit Salary</button>

                    </div>
                    <div class="col-md-6" id='printArea'>

                        <?php
                        $this->load->view('SalaryV2/printSalary', array("employee" => $employee, "c_period" => $c_period));
                        ?>
                        <hr/>
                        <table  style='width:100%;color:black;'>
                            <tr style='border-bottom: 1px solid #eeeeee;    height: 45px;'>
                                <td></td>
                                <td><b>Allowance</b>
                                </td>
                                <td></td>
                            </tr>
                            <tr ng-repeat="allownces in salaryData.allowances" ng-if='allownces.status' style='border-bottom:  1px solid #eeeeee;    ;'>
                                <td></td>
                                <td> {{allownces.title}}</br>
                                    <small></small>
                                </td>
                                <td>{{allownces.value.toFixed(2)}}</td>
                            </tr>
                            <tr style='border-bottom: 1px solid #eeeeee;    height: 45px;'>
                                <td></td>
                                <td></td>
                                <td>{{salaryData.totalallownces.toFixed(2)}}</td>
                            </tr
                        </table>







                    </div>
                </form>
            </div>


        </div>



</section>
<!-- end col-6 -->

<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-daterangepicker/moment.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>


<script>
            var mpf_percent = <?php echo $mpf_percent; ?>;
            var employee_age = <?php echo $employee["age"]; ?>;
            var basic_salary = <?php echo $employee["base_salary"]; ?>;
            function printDiv(divName) {
                var printContents = document.getElementById(divName).innerHTML;
                var originalContents = document.body.innerHTML;

                document.body.innerHTML = printContents;

                window.print();

                document.body.innerHTML = originalContents;
            }
            $(function () {

                $('.input-group.date').datepicker({
                    todayHighlight: true,
                    autoclose: true,
                    format: 'yyyy-mm-dd',
                })
            })
</script>



<script src="<?php echo base_url(); ?>assets/tinymce/js/tinymce/tinymce.min.js"></script>
<script src="<?php echo base_url(); ?>assets/angular/salaryControllerV2.js"></script>

<?php
$this->load->view('layout/footer');
?> 


