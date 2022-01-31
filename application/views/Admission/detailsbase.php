<?php
$admissionarray = array(
    "DETAILS OF APPLICANT" => [
        array("title" => "Class", "value" => "madarsa_class"),
        array("title" => "HKID#/Passport#", "value" => "hkid_passport"),
        array("title" => "Surname", "value" => "surname"),
        array("title" => "Given Name", "value" => "given_nmae"),
        array("title" => "Birth Date", "value" => "dob"),
        array("title" => "Nationality", "value" => "nationality"),
        array("title" => "Address", "value" => "address"),
        array("title" => "Contact No.", "value" => "contact_no"),
        array("title" => "Email Id.", "value" => "email_id"),
        array("title" => "School Name", "value" => "applicant_school"),
        array("title" => "Form", "value" => "form"),],
    "DETAILS OF PARENTS" => [
        array("title" => "Father's Name", "value" => "father_name"),
        array("title" => "Father's HKID#", "value" => "father_hkid"),
        array("title" => "Mother's Name", "value" => "mother_name"),
        array("title" => "Email Id.", "value" => "p_email_id"),
        array("title" => "Contact No.", "value" => "f_contact_no"),
        array("title" => "Occupation", "value" => "occupation"),
    ],
    "OTHER DETAILS" => [array("title" => "Details", "value" => "other_detail"),],
);
?>

<table  style='width:100%;color:black;' cellspacing="5" cellpadding="1" >
    <?php
    foreach ($admissionarray as $tkey => $tvalue) {
        ?>
        <tr><td colspan="2" style="font-size: 15px;
    padding: 5px;
    background: #c7c4c4;"><?php echo $tkey; ?></td></tr>
        <?php
        foreach ($tvalue as $key => $value) {
            ?>
            <tr style=" border-bottom:  1px solid rgb(255, 0, 0); height: 30px;">
                <td>
                    <b><?php echo $value["title"]; ?></b>
                </td>
                <td>
                    <?php echo $admissiondata[$value["value"]]; ?>
                </td>
            </tr>
            <?php
        }
        ?>

        <?php
    }
    ?>

</table>