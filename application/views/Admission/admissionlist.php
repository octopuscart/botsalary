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
                <h3 class="panel-title">Admission Form Report</h3>
            </div>
            <div class="panel-body">
                <table class="table" id="tableData">
                    <thead>
                    <th>S. No.</th>
                    <th>Form ID#</th>
                    <th>Class</th>
                    <th>HKID#/Passport#</th>
                    <th>Applicant Name</th>
                    <th>Contact No.</th>
                    <th style="width:100px"></th>
                    </thead>
                    <tbody>
                        <?php
                        $count = 1;
                        foreach ($admissiondata as $key => $value) {

                            echo "<tr><td>$count</td>"
                            . "<td>" . $value["form_id"] . "</td>"
                            . "<td>" . $value["madarsa_class"] . "</td>"
                            . "<td>" . $value["hkid_passport"] . "</td>"
                            . "<td>" . $value["surname"] ." ". $value["given_nmae"]."</td>"
                            . "<td>" . $value["contact_no"] . "</td>";
                            echo "<td><a href='" . site_url("Admission/details/" . $value["id"]) . "' class='btn btn-primary'>View Details</a></td>";

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


