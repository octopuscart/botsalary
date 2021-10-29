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
    .pnlnotetable{
        margin: 0px;

    }
    .pnlnotetable .headtdleft{
        padding-left: 70px;
        width:300px;
    }
</style>
<!-- Main content -->
<section class="content" ng-controller="pnlController">
    <div class="">

        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h3 class="panel-title">P & L Notes</h3>
            </div>
            <div class="panel-body " id='printArea'>
                <form action="" method="post">
                    <div class='well well-sm'>
                        <div class="form-group form-group-bg  row form-inline">
                            <label class="form-label col-form-label col-lg-2"><b>P&L Notes Month</b><br/><small>Click on Calendar Icon</small></label>
                            <div class="col-lg-4">
                                <div class="input-group date" >
                                    <input type="text" class="form-control" name="entry_date" style="background: white;
                                           opacity: 1;" readonly=""  autoclose="true" value="<?php echo $select_month; ?>">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class="list-group" ng-repeat="(headk, headcategory) in pnlData.data">
                        <div href="#" class="list-group-item active">
                            <h4 style='color:white'>{{headk}}
                                <span class='pull-right'>{{pnlData.total[headk]|currency}}</span>
                            </h4>

                        </div>
                        <div ng-repeat="(ck, categorylist) in headcategory">
                            <div  class="list-group-item">  <b>{{categorylist.title}}</b></div>
                            <table class="table table-bordered pnlnotetable">
                                <tr ng-repeat="(ck, heads) in categorylist.heads">
                                    <td class="headtdleft">{{heads.title}}</td>
                                    <td style='padding: 2px 10px;'>
                                        <input class="form-control" tabindex=""  step="0.01" ng-model="pnlData[headk][heads.title]" ng-change="calculations()"  required="" type="number" name="notes_value[]" style="width:200px" >
                                        <input type="hidden" name="notes_id[]" value="{{heads.id}}" />
                                    </td>
                                </tr>

                            </table>
                        </div>


                    </div>
                    <button class='btn btn-success' name='submitdata' >Submit Data</button>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- end col-6 -->







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


