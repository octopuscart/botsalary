<?php
$userdata = $this->session->userdata('logged_in');
if ($userdata) {
    
} else {
    redirect("Authentication/index", "refresh");
}
$menu_control = array();





$order_menu = array(
    "title" => "Salary Manegement",
    "icon" => "fa fa-list",
    "active" => "",
    "sub_menu" => array(
         "View Salary" => site_url("Salary/selectEmployee"),
        "Create Salary" => site_url("Salary/selectEmployee"),
        "Salary Report" => site_url("Salary/salaryReport"),
    ),
);
array_push($menu_control, $order_menu);

$salary_menu = array(
    "title" => "Settings",
    "icon" => "fa fa-users",
    "active" => "",
    "sub_menu" => array(
        "Set Allownces" => site_url("Salary/allowanceCategories"),
        "Set Employee" => site_url("Salary/employee"),
        "Set Location" => site_url("Salary/locations"),
        "System Log" => site_url("Services/systemLogReport"),
        "Report Configuration" => site_url("Configuration/reportConfiguration"),
    ),
);
array_push($menu_control, $salary_menu);










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
                            ?>
                            <li><a href="<?php echo $value; ?>"><?php echo $key; ?></a></li>
                        <?php } ?>
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