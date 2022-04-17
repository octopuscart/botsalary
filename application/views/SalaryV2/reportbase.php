<style>
    .salarytable th, .salarytable td{
        padding: 0px 5px;

    }
    .salarytable td{
        padding: 0px 5px;
        text-align: right;
    }
</style>
<table class="salarytable" border="1" style="color:black;font-size: 10px">
    <thead>
        <?php
        if ($showlogo) {
            ?>
            <tr>
                <th colspan="12" class="text-center" style='height: 80px;'>
                    <img src="<?php echo base_url(); ?>assets/img/logo.jpg" style="height: 80px;">
                    <h4>Staff  Salary and  MPF Details</h4>
                </th>
            </tr>
            <?php
        }
        ?>
        <tr>
            <th>S. No.</th>

            <th style="width:200px">Name</th>
            <th>Basic Salary</th>
            <th>Dedu.</th>

            <th>MPF Salary</th>
            <th>Gross Salary</th>
            <th>MPF Employee</th>

            <th>Net Salary</th>
            <th>MPF Employer</th>
            <th>Total MPF</th>

        </tr>
    </thead>
    <tbody>
        <?php
        $temp_basic_salary_t2 = 0;
        $mpf_deduction_t2 = 0;
        $allownce_mpf_t2 = 0;
        $allownce_no_mpf_t2 = 0;
        $mpf_salary_t2 = 0;
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
            $mpf_salary_t = 0;
            $total_mpf_t = 0;
            foreach ($lvalue["salary"] as $skey => $svalue) {
                ?>
                <tr>

                    <td><?php echo $count; ?></td>

                    <td style="text-align: left;">
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
                        $mpf_salary = $svalue["salary_mpf"];
                        echo $mpf_salary;
                        $mpf_salary_t += $mpf_salary;
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
            $mpf_salary_t2 += $mpf_salary_t;
            $gross_salary_t2 += $gross_salary_t;
            $mpf_employee_t2 += $mpf_employee_t;
            $net_salary_t2 += $net_salary_t;
            $mpf_employer_t2 += $mpf_employer_t;
            $total_mpf_t2 += $total_mpf_t;

            $totalarray = [$temp_basic_salary_t,
                $mpf_deduction_t,
                $mpf_salary_t,
                $gross_salary_t,
                $mpf_employee_t,
                $net_salary_t,
                $mpf_employer_t,
                $total_mpf_t,];
            ?><tr style="background: #ffffff;
                color: black;
                border-top: 3px solid #000;
                border-bottom: 3px solid #ff5722;">
                <th colspan="2" class='text-right'>TOTAL</th>

                <?php
                foreach ($totalarray as $key => $value) {
                    echo "<th class='text-right'>$value</th>";
                }
                ?>


            </tr>
            <?php
        }

        $totalarray2 = [$temp_basic_salary_t2,
            $mpf_deduction_t2,
            $mpf_salary_t2,
            $gross_salary_t2,
            $mpf_employee_t2,
            $net_salary_t2,
            $mpf_employer_t2,
            $total_mpf_t2,];
        ?><tr style="background: #ffffff;
            color: black;font-size: 13px;
            border-top: 3px solid #000;
            border-bottom: 3px solid #ff5722;">

            <th colspan="2" class='text-right'>GRAND TOTAL</th>

<?php
foreach ($totalarray2 as $key => $value) {
    echo "<th class='text-right'>$value</th>";
}
?>


        </tr>
    </tbody>
</table>