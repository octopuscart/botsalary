<table  style='width:100%;color:black;'>
    <tr>
        <th colspan="3">
            <?php echo PDF_HEADER; ?>
        </th>
    </tr>
    <tr style=" border-bottom:  1px solid #eeeeee; height: 30px;">
        <td colspan="3"><span style="width: 126px; float: left;"><b>Name of Employee</b></span><span style="width: 16px; float: left;">:</span><b><?php echo $employee["name"]; ?></b></td>
    </tr>
    <tr style=" border-bottom:  1px solid #eeeeee; height: 30px;">
        <td colspan="3"><span style="width: 126px; float: left;">Employee I.D. No</span><span style="width: 16px; float: left;">:</span><?php echo $employee["employee_id"]; ?></td>
    </tr>
    <tr style=" border-bottom:  1px solid #eeeeee; height: 30px;">
        <td colspan="3"><span style="width: 126px; float: left;">Contribution Period</span><span style="width: 16px; float: left;">:</span><?php echo date("M Y", strtotime($salaryobj['salary_date'])); ?></td>
    </tr>
    <tr style=" border-bottom:  1px solid #000; height: 40px;">
        <td colspan="3" ><span style="width: 126px; float: left;">Contribution Date</span><span style="width: 16px; float: left;">:</span><?php
            echo date("d M Y", strtotime($salaryobj['mpf_date']));
            ?></td>
    </tr>
    <tr style="height: 50px">
        <th colspan="2">Relevant Income</th><th>Amount(HK$)</th>
    </tr>
    <tr style='border-bottom:  1px solid #eeeeee;    height: 45px;'>
        <td>A)</td>
        <td style='width:50%'><b>Salary</b></td>
        <td><?php echo $salaryobj["base_salary"]; ?></td>
    </tr>

    <tr style='border-bottom: 1px solid #eeeeee;    height: 45px;'>
        <td>B)</td>
        <td><b>Allowance</b>
        </td>
        <td></td>
    </tr>
    <?php
    if ($allownce) {
        foreach ($allownce as $key => $value) {
            ?>
            <tr style='border-bottom: 1px solid #eeeeee;   ' >
                <td></td>
                <td><?php echo $value["title"]; ?>
                </td>
                <td><?php echo number_format($value["amount"], 2, '.', ''); ?></td>
            </tr>
            <?php
        }
    }
    ?>
    <tr style='border-bottom: 1px solid #eeeeee;    height: 45px;'>
        <td>C)</td>
        <td><b>Deduction</b>
        </td>
        <td></td>
    </tr>
    <?php
    if ($deduction) {
        foreach ($deduction as $key => $value) {
            ?>
            <tr style='border-bottom: 1px solid #eeeeee;   ' >
                <td></td>
                <td><?php echo $value["title"]; ?>
                </td>
                <td>(<?php echo number_format($value["amount"], 2, '.', ''); ?>)</td>
            </tr>
            <?php
        }
    }
    ?>


    <tr style='border-bottom: 1px solid #000;   '>
        <td></td>
        <td>EPF Contribution
        </td>
        <td>(<?php echo $salaryobj["mpf_employee"]; ?>)</td>
    </tr>
    <tr style='border-bottom: 1px solid #eeeeee;    height: 45px;'>
        <td></td>
        <td>Amount Booked To Account
        </td>
        <td style='border-bottom-style: double;'><b><?php echo $salaryobj["net_salary"]; ?></b></td>
    </tr>
    <tr style="height: 50px">
        <th colspan="2">MPF Mandatory Contribution:</th><th></th>
    </tr>
    <tr style='border-bottom: 1px solid #eeeeee;    '>
        <td></td>
        <td>Employer
        </td>
        <td><?php echo $salaryobj["mpf_employer"]; ?></td>
    </tr>
    <tr style='border-bottom: 1px solid #eeeeee;    '>
        <td></td>
        <td>Employee
        </td>
        <td><?php echo $salaryobj["mpf_employee"]; ?></td>
    </tr>
    <tr style='border-bottom: 1px solid #eeeeee;    height: 45px;'>
        <td></td>
        <td>Total Contribution
        </td>
        <td style='border-bottom-style: double;'><b><?php echo number_format($salaryobj["mpf_employee"] + $salaryobj["mpf_employer"], 2, '.', '') ?></b></td>
    </tr>
</table>