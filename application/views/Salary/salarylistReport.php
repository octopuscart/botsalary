        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h3 class="panel-title"><b><?php echo $employee["name"]; ?></b>, EMP ID#: <?php echo $employee["employee_id"]; ?>, HK ID#: <?php echo $employee["hk_id"]; ?></h3>
            </div>
            <div class="panel-body">
                <table class="table" id="tableData" border="1" style="text-align: right">
                    <thead>
                        <tr  style="background-color:gray;height: 20px;color:white;padding:5px;">
                            <th >S. No.</th>
                            <th>Salary Month</th>
                            <th>Base Salary</th>
                            <th>Net Salary</th>
                            <th>Employee MPF</th>
                            <th>Employer MPF</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $count = 1;
                        $totalArray = array(
                            "base_salary"=>0,
                            "net_salary"=>0,
                            "mpf_employee"=>0,
                            "mpf_employer"=>0,
                            );
                        foreach ($salary as $key => $value) {
                           $totalArray["base_salary"] += $value["base_salary"];
                           $totalArray["net_salary"] += $value["net_salary"];
                           $totalArray["mpf_employee"] += $value["mpf_employee"];
                           $totalArray["mpf_employer"] += $value["mpf_employer"];
                            echo "<tr><td>$count</td>"
                            . "<td>" . date("M-Y", strtotime($value["salary_date"])) . "</td>"
                            . "<td>" . $value["base_salary"] . "</td>"
                            . "<td>" . $value["net_salary"] . "</td>"
                            . "<td>" . $value["mpf_employee"] . "</td>"
                            . "<td>" . $value["mpf_employer"] . "</td>";

                            echo "</tr>";
                            $count++;
                        }
                        ?>
                        <tr  style="font-weight: bold; height: 20px;color:black;padding:5px;">
                            <th >Total</th>
                            <th></th>
                            <th><?php echo number_format((float)$totalArray["base_salary"], 2, '.', ''); ;?></th>
                            <th><?php echo $totalArray["net_salary"];?></th>
                            <th><?php echo $totalArray["mpf_employee"];?></th>
                            <th><?php echo $totalArray["mpf_employer"];?></th>
                        </tr>
                    </tbody>
                </table>
            </div>


        </div>