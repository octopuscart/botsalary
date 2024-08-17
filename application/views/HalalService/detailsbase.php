<?php
$isTest = true;
?>
<style>
    .halalformdata b {
        font-weight: 700;
        color: black;
    }
    .halalformdata .row {
        margin: 0 -15px;
    }
</style>
<div class="col-md-10 halalformdata">
    <div class="section_hdg hdg_2 hdg_3">
        <a href="#"><img src="images/hdg-img.png" alt=""></a>
        <h4>APPLICATION FOR HALAL CERTIFICATION (FORM HC-1)</h4>
        <span><i class="fa icon-building"></i></span>
    </div>

    <form method="post" id="commentform" class="comment-form" enctype="multipart/form-data">
        <div class="form-group col-md-12 halalformfield">
            <label for="lable_for_{name}" class=" {base-class}">
                Select Applicant Type 選擇申請人類型
            </label>
            <br/>
            <b class="col-md-12 row">{applicant_type}</b>

        </div>
        {hala_form_fields_block1}  
        <div class="form-group {base-class} halalformfield">
            <label for="lable_for_{name}" class="">
                {title}
            </label><br/>
            <b  class="col-md-12 row">{mock}</b>
        </div> 
        {/hala_form_fields_block1} 
        <p>&nbsp;</p>
        {hala_form_fields_block2}  
        <div class="form-group col-md-7 halalformfield" style="">
            <label for="lable_for_{name}">
                {title}
            </label><br/>
            <b>{value}</b>
        </div>
        {/hala_form_fields_block2} 

        <div class="form-group col-md-5 halalformfield" style="">
            <label for="lable_for_{name}">
                Download File
            </label><br/>
            <b><a href="{business_registration_file}">Click Here</a></b>
        </div>
        {hala_form_fields_block3}  
        <div class="form-group {base-class}  halalformfield">
            <label for="lable_for_{name}" class="row {base-class}">
                {title}
            </label><br/>
            <b class="col-md-12 row">{mock}</b>

        </div> 
        {/hala_form_fields_block3}
        {hala_form_fields_block4}  
        <div class="form-group {base-class}  halalformfield">
            <label for="lable_for_{name}" class="row {base-class}">
                {bgtitle}
            </label><br/>
            <b class="col-md-12 row">{mock}</b>

        </div> 
        {/hala_form_fields_block4}
        {hala_form_fields_block5}
        <div class="form-group {base-class}  halalformfield">
            <label for="lable_for_{name}" class="row {base-class}">
                {bgtitle}
            </label><br/>
            <b class="col-md-12 row">{mock}</b>
        </div> 

        {/hala_form_fields_block5}
        <div class="row" style="    margin: 0px 5px;">
            <div class="col-md-6 ">
                <div class="form-group  halalformfield">
                    <label for="lable_for_{name}">
                        Name 姓名

                    </label><br/>
                    <b class="col-md-12 row">{signatory_name}</b>
                </div>

                <div class="form-group  halalformfield">
                    <label for="lable_for_capacity">
                        Designation/Capacity (Duly Authorized) <br/>  職位 (正式授權)

                    </label>
                    <br/>
                    <b class="col-md-12 row">{signatory_capacity}</b>
                </div>

                <div class="form-group  halalformfield">
                    <label for="lable_for_date">
                        Date 日期

                    </label>
                    <br/>
                    <b class="col-md-12 row">{signatory_date}</b>
                </div>
            </div>
            <div class="col-md-6">
                <div class="signaturebox">
                    <img class="image-thumbnails"  src="{signatory_file}" style="height: 100%;
                         max-width: 100%;" id="imagePrerview"/>
                </div>
            </div>

        </div>
        <div class="row" style="    margin: 15px 5px;">
            {hala_form_fields_block6}  
            <div class="form-group {base-class} halalformfield">
                <label for="lable_for_{name}" class="">
                    {title}
                </label>
                <br/>
                <b class="col-md-12 row">{mock}</b>        </div> 
            {/hala_form_fields_block6} 
        </div>

        <div class="col-md-12">
            <div class="form-group {base-class}  halalformfield">
                <label for="lable_for_{name}">
                    Additional Information 附加資訊
                </label>
                <b class="col-md-12 row">
                    {other_info}
                </b>
            </div> 
        </div>

    </form>

</div>