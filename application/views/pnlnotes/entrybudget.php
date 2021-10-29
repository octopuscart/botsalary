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
    .editable{
        width: 100px;
        float: left;
        text-align: right;
    }
</style>
<!-- Main content -->
<section class="content" ng-controller="pnlBudgetController">
    <div class="">
        <div class="well well-sm">
         
                <div class="form-group form-group-bg  row form-inline">
                    <label class="form-label col-form-label col-lg-2"><b>Salary Month</b><br/><small>Click on Calendar Icon</small></label>
                    <div class="col-lg-4">
                        <div class="input-group date" >
                            <input type="text" class="form-control" name="entry_date" style="background: white;
                                   opacity: 1;" readonly=""  autoclose="true" value="<?php echo $select_year; ?>">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
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
                <h3 class="panel-title">P & L Notes Budget Entry</h3>
            </div>

            <div class="panel-body " id='printArea'>
                <form action="" method="post">

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
                                        <span  id="{{heads.id}}" data-type="text" data-pk="{{heads.id}}" data-name="head_value" data-value="{{heads.head_value}}" data-params ={'tablename':'pnl_entry_budget'} data-url="<?php echo site_url("LocalApi/updateCurd"); ?>" data-mode="inline" class="m-l-5 editable editable-click" tabindex="-1" > {{heads.head_value}}</span>

<!--                                        <input class="form-control" tabindex=""  step="0.01" ng-model="pnlData[headk][heads.title]" ng-change="calculations()"  required="" type="number" name="notes_value[]" style="width:200px" >-->
                                        <input type="hidden" name="notes_id[]" value="{{heads.id}}" />
                                    </td>
                                </tr>

                            </table>
                        </div>


                    </div>
           
            </div>
        </div>
    </div>
</section>
<!-- end col-6 -->





<script>
<?php
$time = strtotime($select_year);
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
    $(function () {

        $('.input-group.date').datepicker({
            format: "yyyy-04-01",
            viewMode: "years",
            minViewMode: "years",
            todayHighlight: true,
            autoclose: true,
        })
    })
</script>
<?php
$this->load->view('layout/footer');
?> 


