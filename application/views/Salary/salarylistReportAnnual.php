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

        <tr>
            <th>S. No.</th>

            <th style="width:200px">Name</th>
            <?php
            $dateTotalData = array();
            $hg_total = 0;
            $vg_total = 0;
            foreach ($salary_date_list as $key => $wslvalue) {
                $dateTotalData[$wslvalue] = 0;
                echo " <th>" . $wslvalue . "</th>";
            }
            ?>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($salary_report as $lkey => $lvalue) {
            ?>
            <tr style="background:orange;
                color: black;">
                <th colspan="15" style="background:orange;
                    color: black;">
                    <?php echo $lvalue["location"] ?>
                </th>
            <tr/>   

            <?php
            $count = 1;

            foreach ($lvalue["salary"] as $skey => $svalue) {
                ?>
                <tr>
                    <td><?php echo $count; ?></td>

                    <td style="text-align: left;">
                        <?php
                        echo $svalue["name"];
                        ?>
                        <br>
                        <small> <?php
                            echo $svalue["employee_id"];
                            ?>
                        </small>
                    </td>
                    <?php
                    $htotal = 0;
                    foreach ($salary_date_list as $key => $wslvalue) {
                        $grsSalary = isset($svalue["salaryData"][$wslvalue]) ? $svalue["salaryData"][$wslvalue] : 0;
                        echo " <td>" . $grsSalary . "</td>";
                        $htotal += $grsSalary;
                        $dateTotalData[$wslvalue] += $grsSalary;
                    }
                    $hg_total += $htotal;
                    echo " <th>" . $htotal . "</th>";
                    ?>

                </tr>
                <?php
                $count++;
            }
        }
        ?>
        <tr>
            <th></th>

            <th style="width:200px">Total</th>
                <?php
                foreach ($salary_date_list as $key => $wslvalue) {
                    $vg_total += $dateTotalData[$wslvalue];
                    echo " <th>" . $dateTotalData[$wslvalue] . "</th>";
                }
                ?>
            <th>
                <?php
                echo $vg_total == $hg_total ? $hg_total : "Error";
                ?>
            </th>

        </tr>
    </tbody>
</table>