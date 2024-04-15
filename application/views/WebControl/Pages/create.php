<?php
$this->load->view('layout/header');
$this->load->view('layout/topmenu');
?>
<!-- ================== BEGIN PAGE CSS STYLE ================== -->
<link href="<?php echo base_url(); ?>assets/plugins/jquery-tag-it/css/jquery.tagit.css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/plugins/jquery-tag-it/js/tag-it.min.js"></script>

<link href="<?php echo base_url(); ?>assets/plugins/jquery-file-upload/css/jquery.fileupload.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>assets/plugins/jquery-file-upload/css/jquery.fileupload-ui.css" rel="stylesheet" />

<link href="<?php echo base_url(); ?>assets/plugins/bootstrap-wysihtml5/src/bootstrap-wysihtml5.css" rel="stylesheet" />

<!-- begin #content -->
<!-- begin #content -->
<div id="content" class="content content-full-width">

    <h1 class="page-header">
        Website Page
        <small></small>

        <?php if ($operation == "edit") { ?>
            <a href="<?php echo SITE_URL . "" . $pageobj["uri"] ?>" class="btn btn-primary" target="_block">View Page</a>
            <a onclick="deletePost('<?php echo site_url("WebControl/deletePage/" . $pageobj["id"]); ?>')" href="javascript:void(0);" class="btn btn-danger" >Delete Page</a>
        <?php } ?>
    </h1>

    <!-- begin vertical-box -->
    <div class="vertical-box">
        <!-- begin vertical-box-column -->

        <!-- end vertical-box-column -->
        <!-- begin vertical-box-column -->
        <div class="vertical-box-column">

            <!-- begin wrapper -->
            <div class="wrapper ">
                <div class="p-30  bg-white">

                    <!-- begin email form -->
                    <form action="" method="post" class="row" >
                        <!-- begin email to -->


                        <!--tags-->
                        <label class="control-label"> Title</label>
                        <div class="m-b-15">
                            <input  class="form-control "   name="title" required="" id="slug-source" onkeydown="createSlang()" value="<?php echo $pageobj["title"]; ?>"/>
                        </div>
                        <br/>

                        <?php if ($operation == "create") { ?>
                            <!--tags-->
                            <label class="control-label"> URI (Page Link Suffix)</label>
                            <div class="m-b-15">
                                <input  class="form-control"  type="hidden"  name="uriname" required="" id="slug-target"   value="<?php echo $pageobj["uri"]; ?>"/>
                                <input  class="form-control" disabled type=""  name="uriname" required="" id="slug-uri-display"   value="<?php echo $pageobj["uri"]; ?>"/>


                            </div>
                            <br/>
                            <p>
                                <span class="slug-output">Generated URL Slug</span>:
                                <span id="slug-target-span"></span>
                            </p>
                            <!-- begin email content -->
                        <?php } ?>

                        <!-- begin email content -->
                        <label class="control-label"> Page Type</label>
                        <div class="m-b-15">
                            <select  class="form-control "   name="page_type" required="" >
                                <?php
                                $options = array("main" => "Main Page", "sidebar" => "Page Component");
                                foreach ($options as $key => $value) {
                                    $selected = $key == $pageobj["page_type"] ? "selected" : "";
                                    echo "<option $selected value='$key'>$value</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <br/>
                        <!--tags-->
                        <label class="control-label"> Select Template</label>
                        <div class="m-b-15">
                            <select  class="form-control "   name="template_type" required="" >
                                <?php
                                $options = array("template_main" => "Main Page Template", "template_sidebar" => "Page With Sidebar", "template_basic" => "Component");
                                foreach ($options as $key => $value) {
                                    $selected = $key == $pageobj["template"] ? "selected" : "";
                                    echo "<option $selected value='$key'>$value</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <br/>

                        <!-- begin email content -->
                        <div class="m-b-15 ">

                            <label class="control-label">Content:</label>
                            <textarea id="ckeditor2" class=" form-control " novalidate name="content" ><?php echo $pageobj["content"]; ?></textarea>

                        </div>
                        <div class="m-b-15 col-md-12">
                            <!-- end email content -->
                            <button type="submit" name="update_data" class="btn btn-primary p-l-40 p-r-40">Save Page</button></div>
                    </form>
                    <!-- end email form -->
                </div>
            </div>
            <!-- end wrapper -->
        </div>
        <!-- end vertical-box-column -->
    </div>
    <div class="vertical-box">
        <?php if ($operation == "edit" & $pageobj["page_type"] == 'main') { ?>
            <!-- begin vertical-box-column -->
            <div class="vertical-box-column">
                <!-- begin wrapper -->
                <div class="wrapper ">
                    <div class="p-30  bg-white row">
                        <form action="#" method="post" >
                            <div class="well well-sm row">
                                <div class="col-md-6">
                                    <label class="control-label"> Add Sidebar Component</label>
                                    <div class="m-b-15">
                                        <select  class="form-control "   name="component_id" required="" >
                                            <?php
                                            $options = array("main" => "Main Page", "sidebar" => "Side Bar Component");
                                            foreach ($pageData as $pkey => $pvalue) {
                                                $page_id = $pvalue["id"];
                                                $pageTitle = $pvalue["title"];
                                                echo "<option value='$page_id'>$pageTitle</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label"> &nbsp;</label>
                                    <div class="m-b-15">
                                        <button type="submit" class="btn btn-success" name="add_component" value="">Add Component</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="well well-sm row">
                            <div class=" table-responsive col-md-12">

                                <table id="user" class="table table-bordered table-striped" >

                                    <tbody>

                                        <?php
                                        foreach ($metaData as $key => $value) {
                                            ?>
                                            <tr>
                                                <td><?php echo $key + 1; ?></td>
                                                <td>
                                                    <?php echo $value["meta_id"]; ?>
                                                </td>
                                                <td>
                                                    <?php echo $value["title"]; ?>
                                                </td>
                                                <td>
                                                    <?php echo $value["uri"]; ?>
                                                </td>
                                                <td>
                                                    <?php echo $value["page_type"]; ?>
                                                </td>
                                                <td>
                                                    <a href="<?php echo site_url("WebControl/editPage/" . $value["id"]) ?>"  class="btn btn-warning">Update Page</a>
                                                </td>
                                                <td>
                                                    <a href="<?php echo site_url("WebControl/removeComponent/" . $value["meta_id"] . "/" . $pageobj["id"]) ?>"  class="btn btn-warning">Remove</a>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end wrapper -->
            </div>
            <!-- end vertical-box-column -->
        <?php } ?>
    </div>
    <!-- end vertical-box -->
</div>
<!-- end #content -->


<?php
$this->load->view('layout/footer');
?>

<script src="<?php echo base_url(); ?>assets/plugins/ckeditor/ckeditor.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-wysihtml5/lib/js/wysihtml5-0.3.0.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-wysihtml5/src/bootstrap-wysihtml5.js"></script>
<script src="<?php echo base_url(); ?>assets/js/form-wysiwyg.demo.min.js"></script>


<script>
                                function deletePost(location) {
                                    var ask = window.confirm("Are you sure you want to delete this page?");
                                    if (ask) {


                                        window.location.href = location;

                                    }
                                }
                                function createSlang() {
                                    const a = document.getElementById("slug-source").value.trim().replace(/\s+/g, " ");
//            console.log(a);
//            const b = a.toLowerCase().replace(/ /g, '-')
//                    .replace(/[^\w-]+/g, '');
//            document.getElementById("slug-target").value = b;
//            document.getElementById("slug-target-span").innerHTML = b;
                                }
                                $(function () {
//                                    FormWysihtml5.init();
                                    CKEDITOR.replace('ckeditor2', );
                                    CKEDITOR.editorConfig = function (config) {
                                        config.toolbarGroups = [
                                            {name: 'document', groups: ['mode', 'document', 'doctools']},
                                            {name: 'clipboard', groups: ['clipboard', 'undo']},
                                            {name: 'editing', groups: ['find', 'selection', 'spellchecker', 'editing']},
                                            {name: 'forms', groups: ['forms']},
                                            {name: 'basicstyles', groups: ['basicstyles', 'cleanup']},
                                            {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi', 'paragraph']},
                                            {name: 'links', groups: ['links']},
                                            {name: 'insert', groups: ['insert']},
                                            {name: 'styles', groups: ['styles']},
                                            {name: 'colors', groups: ['colors']},
                                            {name: 'tools', groups: ['tools']},
                                            {name: 'others', groups: ['others']},
                                            {name: 'about', groups: ['about']}
                                        ];

                                        config.removeButtons = 'Cut,Copy,Paste,Undo,Redo,Anchor,Underline,Strike,Subscript,Superscript';
                                    };
                                    $("slug-source").keypress(function (sval) {
                                        console.log(sval);

                                    });

                                    $("#slug-source").on("keyup", function (sval) {
                                        let svalue = $(this).val();

                                        let filterVal = svalue.toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '');
                                        $("#slug-target").val(filterVal);
                                        $("#slug-uri-display").val("https://islamictrusthk.org/" + filterVal);

                                    });
                                });

</script>

