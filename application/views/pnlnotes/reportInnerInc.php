<style>
    .tablepnl{
        color:black;
        display: inline-block;
    }

    .tablepnl th, .tablepnl td{
        padding: 2px 5px;
        text-align: left;
    }

    .numbercell{
        text-align: right!important;
    }

    .totalcell{
        border-top: 2px solid #000;
        border-bottom: 2px solid #000;
    }

    .fontHeading{
        font-size: 15px;
    }
    .fontHeading2{
        font-size: 18px;
    }
    .heading-span{
        font-weight: 500;
        font-size: 12px;
        width: 100%;
        float: left;
        padding: 2px 10px;
        background: #ffc107;
        margin-bottom: 5px;
    }
    @media print {
        @page {
            font-size: 15px;
            margin-top: 10px;
            margin-bottom: 20px;
        }
        body  {
            padding-top: 1rem;
            padding-bottom: 1rem;
        }
        -webkit-print-color-adjust: exact !important;
        .heading-span{
            font-weight: 500;
            font-size: 15px;
            width: 100%;
            float: left;
            padding: 2px 10px;
            background: #ffc107;
            margin-bottom: 5px;
        }
    }
</style>
<div class="text-center">
    <table border="1" class="tablepnl">
        <tbody>
            <tr>
                <th colspan="6" class=" text-center">
                    <img src="<?php echo base_url(); ?>assets/img/logo.jpg" style="height: 50px;">
                </th>
            </tr>
            <tr  class="fontHeading2">
                <th colspan="6" class=" text-center">
                    Income and Expenditure Statement for the month of <?php echo $c_date; ?>
                </th>
            </tr>
        </tbody>
        <?php
        $headdata = array(
            "Income" => array("color" => "#8bc34a;"),
            "Expenditure" => array("color" => "#ff5722;"),
        );
        foreach ($headdata as $plkey => $plvalue) {
            ?>
            <tbody class="page-break-after ">
                <tr  class="fontHeading">
                </tr>
            </tbody>
            <tbody>
                <tr>

                    <th colspan="2" style="text-align: center;background: <?php echo $plvalue["color"]; ?>;"><?php echo $plkey; ?></th>
                    <th class="text-center"><span class="heading-span">Actual</span><br/><?php echo $c_date; ?></th>
                    <th class="text-center"><span class="heading-span">Actual</span><br/><?php echo $p_date; ?></th>
                    <th class="text-center"><span class="heading-span">Actual</span><br/><?php echo $f_date; ?></th>
                    <th class="text-center"><span class="heading-span">Budget</span><br/><?php echo $b_date; ?></th>

                </tr>
            </tbody>
            <?php foreach ($pnldata[$plkey] as $mckey => $mcvalue) { ?>
                <tbody>
                    <tr style="    background: #eeeeee;">
                        <th class="numbercell" style="width:50px;"><?php echo $mckey + 1; ?></th>
                        <th ><?php echo $mcvalue["title"]; ?></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </tbody>
                <tbody>
                    <?php
                    $loopdata = $mcvalue["heads"] ? $mcvalue["heads"] : $mcvalue["heads_p"];
                    foreach ($loopdata as $mhkey => $mhvalue) {
                        ?>
                        <tr>
                            <td class="numbercell" width:50px;"><?php echo $mckey + 1; ?>.<?php echo $mhkey + 1; ?></td>
                            <td style="width: 300px;"><?php echo $mhvalue["title"]; ?></td>
                            <td class="numbercell"><?php echo number_format($mcvalue["heads"] ? $mcvalue["heads"][$mhkey]["head_value"] : '0', 2, '.', ','); ?></td>
                            <td class="numbercell"><?php echo number_format($mcvalue["heads_p"] ? $mcvalue["heads_p"][$mhkey]["head_value"] : '0', 2, '.', ','); ?></td>

                            <td class="numbercell"><?php echo number_format(($mcvalue["heads_f"][$mhkey]["head_value"]), 2, '.', ','); ?></td>
                            <td class="numbercell"><?php echo number_format($mcvalue["heads_b"] ? $mcvalue["heads_b"][$mhkey]["head_value"] : '0', 2, '.', ','); ?></td>
                        </tr>

                    <?php } ?>
                    <tr style="">
                        <th colspan="2" class="numbercell"></th>
                        <th  class="numbercell totalcell"><?php echo $mcvalue["total"]; ?></th>
                        <th  class="numbercell totalcell"><?php echo $mcvalue["total_p"]; ?></th>
                        <th  class="numbercell totalcell"><?php echo $mcvalue["total_f"]; ?></th>
                        <th  class="numbercell totalcell"><?php echo $mcvalue["total_b"]; ?></th>
                    </tr>

                </tbody>

            <?php } ?>
            <tbody>
                <tr class="fontHeading" style="background: #bbdefb;">
                    <th colspan="2" class="numbercell">Total</th>

                    <th  class="numbercell totalcell"><?php echo $pnldata[$plkey . "Total"]; ?></th>
                    <th  class="numbercell totalcell"><?php echo $pnldata[$plkey . "Total_P"]; ?></th>
                    <th  class="numbercell totalcell"><?php echo $pnldata[$plkey . "Total_F"]; ?></th>
                    <th  class="numbercell totalcell"><?php echo $pnldata[$plkey . "Total_B"]; ?></th>
                </tr>
            </tbody>
            <tbody>
                <tr  class="fontHeading">
                    <th colspan="6" style="text-align: center;background: #9e9e9e;"></th>
                </tr>
            </tbody>
        <?php } ?>
        <tbody>
            <tr class="fontHeading2" style="background: yellow;">
                <th colspan="2" class="numbercell">Surplus(Deficit) for the period</th>

                <th  class="numbercell totalcell"><?php echo $pnldata["pnl_total"]; ?></th>
                <th  class="numbercell totalcell"><?php echo $pnldata["pnl_total_p"]; ?></th>
                <th  class="numbercell totalcell"><?php echo $pnldata["pnl_total_f"]; ?></th>
                <th  class="numbercell totalcell"><?php echo $pnldata["pnl_total_b"]; ?></th>
            </tr>
        </tbody>
    </table>

</div>