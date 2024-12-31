<?php
$this->load->view('layout/header');
$this->load->view('layout/topmenu');
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/treejs/themes/default/style.min.css">

<script src="<?php echo base_url(); ?>assets/treejs/jstree.min.js"></script>
<link href="<?php echo base_url(); ?>assets/plugins/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet"  />



<link href="<?php echo base_url(); ?>assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>assets/plugins/bootstrap-eonasdan-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />

<style>
    .kode_sab_banner_wrap{
        padding: 20px 0px 0px;
    }
    .kode_contact_des {
        padding: 20px 0 40px;
    }

    .halaform h4 {
        font-weight: 600;
    }
    .halalformfield{
        border-bottom: 1px solid #ddd;
        padding-bottom: 10px;
    }
    .halalformfield label{
        /*text-align: right;*/
    }
    .halalformfield .form-control-plaintext{
        margin-top: 10px;
    }
    .halalformfield .form-check-input{
        height: 20px;
        padding: 0px 15px;
        width: 30px;
        margin-left: 0px;
        /*        margin-top: 14px;*/
    }
    .halalformfield .form-check {
        background: #e1e1e1;
        padding: 3px 3px 6px;
    }
    .halalformfield  .form-check-label {
        padding-left: 2.25rem;
        margin-bottom: 0;
        cursor: pointer;
    }
    .signaturebox {
        height: 210px;
        width: 100%;
        border: 1px solid #ddd;
    }

</style>



<?php
$isTest = false;
?>

<!--KODE 404 WRAP START-->
<section class="content" >

    <div class="panel panel-inverse">
        <div class="">
            <div class="row">
                <div class="kode_contact_field">
                    <div class="col-md-2"></div>


                    <div class="col-md-12">
                        <div class="section_hdg hdg_2 hdg_3 col-md-12">
                            <a href="#"><img src="images/hdg-img.png" alt=""></a>
                            <h4>APPLICATION FOR HALAL CERTIFICATION (FORM HC-1)</h4>
                            <span><i class="fa icon-building"></i></span>
                        </div>
                        <div class="col-md-12">
                            <p>
                                I/We hereby apply for a Halal Certificate and to join the fraternity of Halal Certificate
                                holders and provide you with the following information and documents to assist you
                                in assessing our request:
                                <br/>
                                我/我們在此申請清真證書，並向貴會提供以下資料及文件用以評估申請，希望
                                得到貴 會的認證。

                            </p><!-- comment -->
                        </div>
                        <form method="post" action="#" id="commentform" class="comment-form" enctype="multipart/form-data">
                            <div class="form-group col-md-12 halalformfield">
                                <label for="lable_for_{name}">
                                    Select Applicant Type 選擇申請人類型
                                </label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="applicant_type" id="restaurant" checked="true" value="Restaurant">
                                    <label class="form-check-label" for="restaurant">Restaurant &nbsp; </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="applicant_type" id="factory" value="Factory">
                                    <label class="form-check-label" for="factory">Factory &nbsp; </label>
                                </div>
                            </div>
                            {hala_form_fields_block1}  
                            <div class="form-group {base-class} halalformfield">
                                <label for="lable_for_{name}">
                                    {title}
                                </label>
                                <input type="text"  name="{name}" class="form-control" id="id_for_{name}" value="<?php echo $isTest ? "{mock}" : "" ?>"  placeholder="">
                            </div> 
                            {/hala_form_fields_block1} 
                            {hala_form_fields_block2}  
                            <div class="form-group col-md-7 halalformfield" style="padding-bottom: 34px;">
                                <label for="lable_for_{name}">
                                    {title}
                                </label>
                                <input type="text"   name="{name}" class="form-control" id="lable_for_{name}"  placeholder="" value="<?php echo $isTest ? "{mock}" : "" ?>">
                            </div>
                            <div class="form-group col-md-5 halalformfield" >
                                <label for="lable_for_{name}">
                                    {filetitle}
                                </label>
                                <input type="file"  name="{name}_file" class="form-control" id="lable_for_{name}"  placeholder="" accept=".pdf">
                                <small>Max size 2MB 最大大小 2MB</small>
                            </div> 
                            {/hala_form_fields_block2} 
                            {hala_form_fields_block3}  
                            <div class="form-group {base-class}  halalformfield">
                                <label for="lable_for_{name}">
                                    {title}
                                </label>
                                <textarea  name="{name}"  maxlength="520" class="form-control" id="lable_for_{name}"  placeholder=""><?php echo $isTest ? "{mock}" : "" ?></textarea>
                                <small>Max char limit 520. 最大字元數限制 520。</small>
                            </div> 
                            {/hala_form_fields_block3}
                            
                            {hala_form_fields_block4}  
                            <div class="form-group {base-class}  halalformfield">
                                <label for="lable_for_{name}">
                                    {bgtitle}
                                </label>
                                <br/>
                                {elementlist}
                                <div class="{element-class}">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="{value}"   name="{input}" id="{name}">
                                        <label class="form-check-label" for="{name}">
                                            {title}
                                        </label>
                                    </div>

                                </div>
                                {/elementlist}
                            </div> 
                            {/hala_form_fields_block4}
                            {hala_form_fields_block5}
                            <div class="form-group {base-class}  halalformfield">
                                <label for="lable_for_{name}">
                                    {bgtitle}
                                </label>
                                <br/>
                                {elementlist}

                                <div class="{element-class}">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="{input}" id="{name}"  <?php echo $isTest ? "{mock}" : "" ?>  value="{title}">
                                        <label class="form-check-label" for="{name}">{title} &nbsp; </label>
                                    </div>

                                </div>
                                {/elementlist}
                            </div> 
                            {/hala_form_fields_block5}
                            <div class="col-md-12">
                                <p>
                                    We undertake to comply with all terms and conditions in form HC-2 or any other
                                    documents issued especially for our trade by the Incorporated Trustees of the Islamic
                                    Community Fund of Hong Kong.
                                    <br/>
                                    我們承諾遵守及執行表格 HC-2 的所有條款和細則，或其他經 由香港回教信
                                    託基
                                    金總會簽發便於我們通商或貿易之文件。

                                </p>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group  halalformfield">
                                    <label for="lable_for_{name}">
                                        Name 姓名

                                    </label>
                                    <input type="text" name="signatory_name" class="form-control" id="id_for_signatory_name"  value="<?php echo $isTest ? "Test Name" : "" ?>"  placeholder="">
                                </div>
                                <div class="form-group  halalformfield">
                                    <label for="lable_for_capacity">
                                        Designation/Capacity (Duly Authorized) <br/>  職位 (正式授權)

                                    </label>
                                    <input type="text" name="signatory_capacity" class="form-control" id="id_for_signatory_name"  value="<?php echo $isTest ? "Test Designation" : "" ?>"  placeholder="">
                                </div>
                                <div class="form-group  halalformfield">
                                    <label for="lable_for_date">
                                        Date 日期

                                    </label>
                                    <input type="text" name="signatory_date" class="form-control" id="id_for_signatory_name"   placeholder="" value="<?php echo date("Y-m-d") ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="signaturebox">
                                    <img class="image-thumbnails" style="height: 100%;
                                         max-width: 100%;" id="imagePrerview"/>
                                </div>
                                <div class="form-group  halalformfield">
                                    <label for="lable_for_signature">
                                        (Signature & Chop) 簽署 蓋章
                                    </label>
                                    <input type="file" name="signature" class="form-control" id="lable_for_signature"  placeholder="" accept="image/*" onchange="loadFile(event)">
                                    <small>Max size 2MB 最大大小 2MB</small>
                                </div> 


                            </div>
                            <div class="col-md-12 p-2">
                                <p>
                                    Please provide the name and mobile number of a responsible person or a
                                    responsible alternate for the purpose of assisting with a random audit of Halal
                                    Certificate conditions.<br/>
                                    本會將會在發出證書後安排抽查，以確保申請人能遵守所有條款及規章以保證清
                                    真證書之有效性；請提供負責人/ 相關聯絡人的姓名及手提電話以便本會進行抽
                                    查/跟進情況。
                                </p>
                            </div>
                            {hala_form_fields_block6}  
                            <div class="form-group {base-class} halalformfield">
                                <label for="lable_for_{name}">
                                    {title}
                                </label>
                                <input type="text"  name="{name}" class="form-control" id="id_for_{name}" value="<?php echo $isTest ? "{mock}" : "" ?>"  placeholder="">
                            </div> 
                            {/hala_form_fields_block6} 


                            <div class="col-md-12">
                                <div class="form-group {base-class}  halalformfield">
                                    <label for="lable_for_{name}">
                                        Additional Information (Optional) 附加資訊（可選）
                                    </label>
                                    <textarea  name="other_info" class="form-control" id="lable_for_{name}" maxlength="520" placeholder="Max limit 520 char."><?php echo $isTest ? "Test Additional Information (Optional) 附加資訊（可選）" : "" ?></textarea>
                                    <small>Max char limit 520. 最大字元數限制 520。</small>
                                </div> 
                                <p class="form-submit"><input name="submit" type="submit" class="medium_btn background-bg-dark btn_hover hvr-wobble-bottom btn btn-primary" value="Submit Now"></p>
                            </div>

                        </form>

                    </div>
                    <div class="col-md-2"></div>
                </div>

            </div>	
            <!--CONTAINER END-->
        </div>
        <!--KODE CONTACT DES END-->
    </div>
</div>
<!--KODE 404 WRAP END-->
<script>
    var loadFile = function (event) {
        var output = document.getElementById('imagePrerview');
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function () {
            URL.revokeObjectURL(output.src); // free memory
        };
    };
</script>

<?php
$this->load->view('layout/footer');
?> 
