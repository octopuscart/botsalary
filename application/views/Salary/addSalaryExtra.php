<?php
$this->load->view('layout/header');
$this->load->view('layout/topmenu');
?>
<link href="<?php echo base_url(); ?>assets/plugins/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet" />
<style>
    .form-group-bg {

        background: #f9f9f9;
        padding: 8px 0px;
        margin: 5px 0px;
    }
</style>
<section class="content" ng-controller="salaryController">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= $title ?></h3>
                </div>
                <div class="panel-body">
                    <form method="post" action="<?= $form_action ?>">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label"><b>Select Month</b></label>
                            <div class="col-sm-6">
                                <div class="input-group date" id="salary_month_picker">
                                    <input type="text" class="form-control" name="salary_month" id="salary_month"
                                        value="<?= htmlspecialchars($selected_month ?: date('Y-m')) ?>" readonly
                                        required>
                                    <div class="input-group-addon input-group-append">
                                        <span class="input-group-text"><i class="glyphicon glyphicon-th"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <button type="submit" class="btn btn-primary">Select</button>
                            </div>
                        </div>
                    </form>

                    <?php if ($show_form): ?>
                        <form method="post" action="<?= $form_action ?>">
                            <div class="form-group form-group-bg row">
                                <label for="employee_id" class="col-sm-3 col-form-label"><b>Employee</b></label>
                                <div class="col-sm-6">
                                    <select name="employee_id" id="employee_id" class="form-control" required>
                                        <option value="">Select Employee</option>
                                        <?php foreach ($employee_options as $id => $name): ?>
                                            <option value="<?= $id ?>"><?= htmlspecialchars($name) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group form-group-bg row">
                                <label class="col-sm-3 col-form-label"><b>Salary Date</b></label>
                                <div class="col-sm-6">
                                    <div class="input-group date" id="salary_date_picker2">
                                        <?php
                                        // Calculate last day of selected month
                                        $selected_month = $selected_month ?: date('Y-m');
                                        $last_day = date('Y-m-t', strtotime($selected_month . '-01'));
                                        ?>
                                        <input type="text" class="form-control" name="salary_date" id="salary_date"
                                            value="<?= $last_day ?>" required autocomplete="off">
                                        <div class="input-group-addon input-group-append">
                                            <span class="input-group-text"><i class="glyphicon glyphicon-th"></i></span>
                                        </div>
                                    </div>
                                    <small class="form-text text-muted">Click the calendar icon to select month and
                                        year.</small>
                                </div>
                            </div>
                            <div class="form-group form-group-bg row">
                                <label for="net_salary" class="col-sm-3 col-form-label"><b>Net Salary</b></label>
                                <div class="col-sm-6">
                                    <input type="number" step="0.01" min="0" class="form-control" name="net_salary"
                                        id="net_salary" required placeholder="Enter net salary">
                                </div>
                            </div>
                            <div class="form-group form-group-bg row">
                                <div class="col-sm-9 offset-sm-3">
                                    <button type="submit" name="submit_salary" class="btn btn-success" value="submit">
                                        <i class="fa fa-plus"></i> Add Salary
                                    </button>
                                </div>
                            </div>
                        </form>
                    <?php endif; ?>


                </div>
            </div>
        </div>
        <div class="col-md-6">
            <?php if (!empty($created_salaries)): ?>
                <div class="panel panel-default">
                    <div class="panel-heading"><b>Created Salaries for
                            <?= date('F Y', strtotime($selected_month . '-01')) ?></b></div>
                    <div class="panel-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Employee Name</th>
                                    <th>HK ID</th>
                                    <th>Net Salary</th>
                                    <th>Salary Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($created_salaries as $row): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['name']) ?></td>
                                        <td><?= htmlspecialchars($row['hk_id']) ?></td>
                                        <td><?= htmlspecialchars($row['net_salary']) ?></td>
                                        <td><?= htmlspecialchars($row['salary_date']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="2" style="text-align:right;">Total</th>
                                    <th><?= number_format($total_net_salary, 2) ?></th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            <?php endif; ?>
        </div>

    </div>
</section>

<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script>
    $(function () {
        $('#salary_month_picker').datepicker({
            format: "yyyy-mm",
            startView: "months",
            minViewMode: "months",
            autoclose: true
        }).on('changeDate', function (e) {
            // Get selected month
            var selectedMonth = $('#salary_month').val();
            if (selectedMonth) {
                // Calculate last day of month
                var parts = selectedMonth.split('-');
                var year = parseInt(parts[0], 10);
                var month = parseInt(parts[1], 10);
                // JS months are 0-based, so month, 0 gives last day of previous month, month+1, 0 gives last day of selected month
                var lastDay = new Date(year, month, 0).getDate();
                var lastDate = year + '-' + (month < 10 ? '0' : '') + month + '-' + lastDay;
                $('#salary_date').val(lastDate);
            }
        });
        $('#salary_date_picker2').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true
        });

    });
</script>
<?php
$this->load->view('layout/footer');
?>