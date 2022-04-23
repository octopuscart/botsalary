<?php
$userdata = $this->session->userdata('logged_in');
if ($userdata) {
    
} else {
    redirect("Authentication/index", "refresh");
}
$menu_control = array();

if ($this->user_type == 'Admin') {
    $order_menu = array(
        "title" => "Salary Manegement 22",
        "icon" => "fa fa-list",
        "active" => "",
        "sub_menu" => array(
            "View Salary" => site_url("SalaryV2/selectEmployee"),
            "Create Salary" => site_url("SalaryV2/selectEmployee"),
            "Salary Report" => site_url("SalaryV2/salaryReport"),
            "Allowance Report" => site_url("SalaryV2/allowanceReports"),
        ),
    );
    array_push($menu_control, $order_menu);

    $pnl_menu = array(
        "title" => "P&L Manegement",
        "icon" => "fa fa-pie-chart",
        "active" => "",
        "sub_menu" => array(
            "Create Reports" => site_url("PnlNotes/entry"),
            "P&L Modification" => site_url("PnlNotes/edit"),
            "P&L Report" => site_url("PnlNotes/report"),
        ),
    );
    array_push($menu_control, $pnl_menu);

    $activity_menu = array(
        "title" => "Activity Reports",
        "icon" => "fa fa-outdent",
        "active" => "",
        "sub_menu" => array(
            "P&L Summary report" => site_url("Accounting/activity/activity_reports"),
            "Annual Expenses" => site_url("Accounting/activityAnnual/annual_exp_reports"),
            "Monthly Expenses" => site_url("Accounting/activity/monthly_exp_reports"),
        ),
    );
    array_push($menu_control, $activity_menu);

    $bs_menu = array(
        "title" => "BS Management",
        "icon" => "fa fa-area-chart",
        "active" => "",
        "sub_menu" => array(
            "Get Reports" => site_url("Accounting/activity/bs_reports"),
        ),
    );
    array_push($menu_control, $bs_menu);

    $bs_menu = array(
        "title" => "Admission Management",
        "icon" => "fa fa-graduation-cap",
        "active" => "",
        "sub_menu" => array(
            "Reports" => site_url("Admission/index"),
        ),
    );
    array_push($menu_control, $bs_menu);

    $salary_menu = array(
        "title" => "Settings",
        "icon" => "fa  fa-wrench",
        "active" => "",
        "sub_menu" => array(
            "Set Allownces" => site_url("Salary/allowanceCategories"),
            "Set Employee" => site_url("Salary/employee"),
            "Set Location" => site_url("Salary/locations"),
            "salary" => "break",
            "Set P&L Categories" => site_url("PnlNotes/categories"),
            "Set P&L A/C Heads" => site_url("PnlNotes/subcategories"),
            "pnl" => "break",
            "System Log" => site_url("Services/systemLogReport"),
            "Report Configuration" => site_url("Configuration/reportConfiguration"),
        ),
    );
    array_push($menu_control, $salary_menu);
    $order_menu = array(
        "title" => "Salary Manegement 21",
        "icon" => "fa fa-list",
        "active" => "",
        "sub_menu" => array(
            "View Salary" => site_url("Salary/selectEmployee"),
            "Create Salary" => site_url("Salary/selectEmployee"),
            "Salary Report" => site_url("Salary/salaryReport"),
            "Salary Report Details" => site_url("Salary/salaryReportV2"),
        ),
    );
    array_push($menu_control, $order_menu);
}
if ($this->user_type == 'Employee') {
    $order_menu = array(
        "title" => "Salary",
        "icon" => "fa fa-list",
        "active" => "",
        "sub_menu" => array(
            "View Salary" => site_url("Salary/index"),
        ),
    );
    array_push($menu_control, $order_menu);
}


if ($this->user_type == 'SalaryManager') {
    $order_menu = array(
        "title" => "Salary",
        "icon" => "fa fa-list",
        "active" => "",
        "sub_menu" => array(
            "View Salary" => site_url("SalaryV2/selectEmployee"),
        ),
    );
    array_push($menu_control, $order_menu);
}



foreach ($menu_control as $key => $value) {
    $submenu = $value['sub_menu'];
    foreach ($submenu as $ukey => $uvalue) {
        if ($uvalue == current_url()) {
            $menu_control[$key]['active'] = 'active';
            break;
        }
    }
}
?>

<!-- begin #sidebar -->
<div id="sidebar" class="sidebar">
    <!-- begin sidebar scrollbar -->
    <div data-scrollbar="true" data-height="100%">
        <!-- begin sidebar user -->
        <ul class="nav">
            <li class="nav-profile">
                <div class="image">
                    <a href="javascript:;"><img src='<?php echo base_url(); ?>assets/profile_image/<?php echo $userdata['image'] ?>' alt="" class="media-object rounded-corner" style="    width: 35px;background: url(<?php echo base_url(); ?>assets/emoji/user.png);    height: 35px;background-size: cover;" /></a>
                </div>
                <div class="info textoverflow" >

<?php echo $userdata['first_name']; ?>
                    <small class="textoverflow" title="<?php echo $userdata['username']; ?>"><?php echo $userdata['username']; ?></small>
                </div>
            </li>
        </ul>
        <!-- end sidebar user -->
        <!-- begin sidebar nav -->
        <ul class="nav">
            <li class="nav-header">Navigation</li>

<?php foreach ($menu_control as $mkey => $mvalue) { ?>

                <li class="has-sub <?php echo $mvalue['active']; ?>">
                    <a href="javascript:;">
                        <b class="caret pull-right"></b>  
                        <i class="<?php echo $mvalue['icon']; ?>"></i> 
                        <span><?php echo $mvalue['title']; ?></span>
                    </a>
                    <ul class="sub-menu">
    <?php
    $submenu = $mvalue['sub_menu'];
    foreach ($submenu as $key => $value) {
        if ($value == "break") {
            ?>
                                <hr style="margin: 10px 0px;" />
                                <?php
                            } else {
                                ?>

                                <li><a href="<?php echo $value; ?>"><?php echo $key; ?></a></li>
            <?php
        }
    }
    ?>
                    </ul>
                </li>
<?php } ?>
            <li class="nav-header">Admin V <?php echo PANELVERSION; ?></li>
            <li class="nav-header">-</li>
        </ul>
        <!-- end sidebar nav -->
    </div>
    <!-- end sidebar scrollbar -->
</div>
<div class="sidebar-bg"></div>
<!-- end #sidebar -->