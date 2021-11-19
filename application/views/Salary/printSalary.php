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
        <td colspan="3"><span style="width: 126px; float: left;">Contribution Period</span><span style="width: 16px; float: left;">:</span><?php echo  date("M Y", strtotime($c_period['salary_date'])); ?></td>
    </tr>
    <tr style=" border-bottom:  1px solid #000; height: 40px;">
        <td colspan="3" ><span style="width: 126px; float: left;">Contribution Date</span><span style="width: 16px; float: left;">:</span><?php echo date("d M Y", strtotime($c_period['mpf_date']));; ?></td>
    </tr>
    <tr style="height: 50px">
        <th colspan="2">Relevant Income</th><th>Amount(HK$)</th>
    </tr>
    <tr style='border-bottom:  1px solid #eeeeee;    height: 45px;'>
        <td>A)</td>
        <td style='width:50%'><b>Salary</b></td>
        <td>{{salaryData.basic_salary.toFixed(2)}}</td>
    </tr>

    <tr style='border-bottom: 1px solid #eeeeee;    height: 45px;'>
        <td>B)</td>
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
        <td>C)</td>
        <td><b>Deduction</b>
        </td>
        <td></td>
    </tr>
    <tr style='border-bottom: 1px solid #eeeeee;   ' ng-if='salaryData.duduction'>
        <td></td>
        <td>{{salaryData.duduction_note}}
        </td>
        <td>({{salaryData.duduction.toFixed(2)}})</td>
    </tr>
    <tr style='border-bottom: 1px solid #eeeeee;   ' ng-if='salaryData.other_duduction'>
        <td></td>
        <td>{{salaryData.other_duduction_note}}
        </td>
        <td>({{salaryData.other_duduction.toFixed(2)}})</td>
    </tr>
    <tr style='border-bottom: 1px solid #000;   '>
        <td></td>
        <td>MPF Contribution
        </td>
        <td>({{salaryData.mpf_employee}})</td>
    </tr>
    <tr style='border-bottom: 1px solid #eeeeee;    height: 45px;'>
        <td></td>
        <td>Amount Booked To Account
        </td>
        <td style='border-bottom-style: double;'><b>{{salaryData.net_salary}}</b></td>
    </tr>
    <tr style="height: 50px">
        <th colspan="2">MPF Mandatory Contridution:</th><th></th>
    </tr>
    <tr style='border-bottom: 1px solid #eeeeee;    '>
        <td></td>
        <td>Employer
        </td>
        <td>{{salaryData.mpf_employer}}</td>
    </tr>
    <tr style='border-bottom: 1px solid #eeeeee;    '>
        <td></td>
        <td>Employee
        </td>
        <td>{{salaryData.mpf_employee}}</td>
    </tr>
    <tr style='border-bottom: 1px solid #eeeeee;    height: 45px;'>
        <td></td>
        <td>Total Contribution
        </td>
        <td style='border-bottom-style: double;'><b>{{salaryData.total_mpf}}</b></td>
    </tr>
</table>