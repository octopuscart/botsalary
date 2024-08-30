<?php
if ($css) {
    ?>
    <style>
        td{
            font-size: 7px;
        }
        td{
            font-size: 10px;
            border:1px #f0f0f0 solid;
            color:#363535;
            font-weight: 100;
        }
        b{
            color:black;
        }
    </style>
    <?php
}

function singleLineBlock($inputarray, $unicount, $width, $colspan, $istr = false) {
    foreach ($inputarray as $key => $value) {
        echo $istr ? "<tr>" : "";
        $width = isset($value["width"]) ? $value["width"] : $width;
        ?>
        <td width="30px" style="text-align: right;">(<?php echo $unicount; ?>)</td>
        <td colspan="<?php echo $colspan; ?>" style="width:<?php echo $width; ?> ;"><?php echo $value["title"]; ?><br/><b><?php echo $value["value"]; ?></b> 
        </td>
        <?php
        echo $istr ? "</tr>" : "";
        $unicount++;
    }
    return $unicount;
}
?>
<table class="table"  style='width:100%;color:black;' cellspacing="0" cellpadding="3" border="0" >
    <tr>
        <th  style="text-align: center;" colspan="4">
            <img src="<?php echo base_url("assets/img/halaform_header.jpg"); ?>" height="120px" >
            <h4 style="font-weight: 200">
                APPLICATION FOR HALAL CERTIFICATION (FORM HC-1)<br/>
                清真食品認證申請表 (表格 HC-1)

            </h4>

        </th>
    </tr>
    <?php
    $unicount = 1;
    $block1 = [
        array("title" => "Select Applicant Type 選擇申請人類型", "value" => $applicant_type),
        array("title" => "Applicant / Company Name 申請人 / 公司 名稱", "value" => $applicant_name),
        array("title" => "Name of Contact Person 聯絡人姓名", "value" => $contact_name),
        array("title" => "Address 地址", "value" => $email),
    ];
    $unicount = singleLineBlock($block1, $unicount, "490px", "3", true);
    $block2 = [
        [
            array("title" => "E-Mail 電郵", "count" => "5", "value" => $email, "colspna" => "2"),
            array("title" => "Mobile No. 手提電話", "count" => "6", "value" => $mobile_no),
        ],
        [
            array("title" => "Mobile No. 手提電話", "count" => "7", "value" => $mobile_no),
            array("title" => "Fax No. 傳真號碼", "count" => "8", "value" => $fax_no),
        ],
    ];
    foreach ($block2 as $b2key => $b2value) {
        echo "<tr>";
        $unicount = singleLineBlock($b2value, $unicount, "230px", "0", false);
        echo "</tr>";
    }
    ?>
    <tr>
        <td width="30px" style="text-align: right;">(<?php echo $unicount; ?>)</td>
        <td colspan="2" style="width:340px">Business Registration Certificate No. 商業登記證號碼<br/><b><?php echo $business_registration_no; ?></b> 
        </td>
        <td colspan="2" style="width:150px" >Download File<br/> <b><a href="<?php echo $business_registration_file; ?>" target="_blank">Click Here</a></b>
        </td>
    </tr>
    <?php
    $unicount++;
    $block3 = [
        array("title" => "Details of products to be certified Meat, Kind of Meat or others food products.<br/>申請清真食品認證之肉類, 肉類品種或其他食品之詳細資料",
            "value" => $details_of_product),
        array(
            "title" => "Ingredients in the food products to be certified.<br/>申請清真食品認證的詳細食品成份或配料",
            "value" => $details_of_ingredients),
    ];
    $unicount = singleLineBlock($block3, $unicount, "490px", "3", true);
    $block4 = [
        array("title" => "Nature of Business (Please select one or more)<br/>公司性質 (請選擇以下一項或多項)",
            "value" => $nature_of_business),
        array(
            "title" => "Purpose for Applying “Halal” Certificate<br/>申請清真證書的原因",
            "value" => $purpose_of_business),
    ];
    $unicount = singleLineBlock($block4, $unicount, "490px", "3", true);
    $block2 = [
        [
            array("title" => "Number of Employees<br/> 職工/員工人數", "count" => "5", "value" => $no_of_employees, "colspna" => "2", "width" => "160px"),
            array("title" => "Any Muslim Employee to handle Halal Department<br/>司內是否有穆斯林專責清真事務/清真部門", "count" => "6", "value" => $handle_by_muslim, "width" => "300px"),
        ],
    ];
    foreach ($block2 as $b2key => $b2value) {
        echo "<tr>";
        $unicount = singleLineBlock($b2value, $unicount, $b2value[0]["width"], "0", false);
        echo "</tr>";
    }
    ?>
    <tr>
        <td width="30px"  rowspan="3"  style="text-align: right;">(<?php echo $unicount; ?>)</td>
        <td colspan="2" rowspan="3" >
            (Signature)簽署<br/>

            <img   src="<?php echo $signatory_file; ?>" style="
                   width: 150px;" id="imagePrerview"/>
        </td>
        <td colspan="1" >Name 姓名<br/><b><?php echo $signatory_name; ?></b> </td>
    </tr>
    <tr>
        <td colspan="1" >Designation/Capacity (Duly Authorized) 職位 (正式授權)<br/><b><?php echo $signatory_capacity; ?></b> </td>
    </tr>
    <tr>
        <td colspan="1" >Date 日期<br/><b><?php echo $signatory_date; ?></b> </td>
    </tr>
    <tr>
        <td width="30px" style="text-align: right;">(<?php
            $unicount++;
            echo $unicount;
            ?>)</td>
        <td colspan="2" >Name of Contact Person 聯絡人姓名<br/><b><?php echo $responsible_name; ?></b> 
        </td>
        <td colspan="1"  >Contact No. 電話<br/> <b><?php echo $responsible_contact; ?></b>
        </td>
    </tr>
    <tr>
        <td width="30px" style="text-align: right;">(<?php
            $unicount++;
            echo $unicount;
            ?>)</td>
        <td colspan="3" >Additional Information 附加資訊<br/><b><?php echo $other_info; ?></b> </td>
    </tr>


</table>






