<style>
    .salarytable th, .salarytable td{
        padding: 0px 5px;

    }
    .salarytable td{
        padding: 0px 5px;
        text-align: right;
    }

    .text-right{
        text-align: right;
    }
    .text-left{
        text-align: left;
    }
</style>
<table class="salarytable"  border="1" style="color:black;font-size: 10px">
    <thead>
        <?php
        if ($showimage) {
            ?>
            <tr>
                <th colspan="<?php echo count($allownceslist) ?>" class="text-left" style=";border:none">
                    <img src="<?php echo base_url(); ?>assets/img/logo.jpg" style="height: 50px;">

                </th>
                <th colspan="3" class="text-right"  style=";border:none">
                    <h4>Staff  Allowances Details <?php echo $salary_month_str; ?></h4>
                </th>
            </tr>
            <?php
        }
        ?>
        <tr>
            <th>S. No.</th>

            <th style="width:200px">Name</th>



            <?php
            $allownceslistdict = array();
            foreach ($allownceslist as $key => $value) {
                echo "<th>$key</th>";
                $allownceslistdict[$key] = array("total" => 0, "gtotal" => 0);
            }
            ?>
            <th>Total Allowances</th>

        </tr>
    </thead>
    <tbody>
        <?php
        $allownce_no_mpf_t2 = 0;

        foreach ($salary_report as $lkey => $lvalue) {
            ?>
            <tr style="background:orange;
                color: black;">
                <th colspan="<?php echo count($allownceslist) + 3 ?>" style="background:orange;
                    color: black;">
                    <?php echo $lvalue["location"] ?>
                </th>
            <tr/>   

            <?php
            $count = 1;

            $allownce_no_mpf_t = 0;

            foreach ($allownceslist as $key => $value) {

                $allownceslistdict[$key]["total"] = 0;
            }

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





                    <?php
                    foreach ($svalue["allownceslist"] as $key => $value) {
                        echo "<td>$value</td>";
                        $allownceslistdict[$key]["total"] += $value;
                    }
                    ?>
                    <td>
                        <?php
                        $allownce_no_mpf = $svalue["allownce_no_mpf"];
                        echo $allownce_no_mpf;
                        $allownce_no_mpf_t += $allownce_no_mpf;
                        ?> 
                    </td>
                </tr>


                <?php
                $count++;
            }


            $allownce_no_mpf_t2 += $allownce_no_mpf_t;

            $totalarray = [
                $allownce_no_mpf_t,
            ];
            ?><tr style="background: #ffffff;
                color: black;
                border-top: 3px solid #000;
                border-bottom: 3px solid #ff5722;">
                <th colspan="2" class='text-right'>TOTAL</th>

                
                <?php
                foreach ($allownceslistdict as $key => $value) {
                    echo "<th class='text-right'>" . $allownceslistdict[$key]["total"] . "</th>";
                    $allownceslistdict[$key]["gtotal"] += $allownceslistdict[$key]["total"];
                }
                ?>
                <?php
                foreach ($totalarray as $key => $value) {
                    echo "<th class='text-right'>$value</th>";
                }
                ?>


            </tr>
            <?php
        }

        $totalarray2 = [
            $allownce_no_mpf_t2,
        ];
        ?><tr style="background: #ffffff;
            color: black;font-size: 13px;
            border-top: 3px solid #000;
            border-bottom: 3px solid #ff5722;">

            <th colspan="2" class='text-right'>GRAND TOTAL</th>

           
            <?php
            foreach ($allownceslistdict as $key => $value) {
                echo "<th class='text-right'>" . $allownceslistdict[$key]["gtotal"] . "</th>";
            }
            ?>
             <?php
            foreach ($totalarray2 as $key => $value) {
                echo "<th class='text-right'>$value</th>";
            }
            ?>


        </tr>
    </tbody>
</table>