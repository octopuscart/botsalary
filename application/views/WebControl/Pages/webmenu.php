<?php
$this->load->view('layout/header');
$this->load->view('layout/topmenu');
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/treejs/themes/default/style.min.css">
<script src="<?php echo base_url(); ?>assets/treejs/jstree.min.js"></script>
<style>
    .product_image{
        height: 100px!important;
        width: 100px!important;
        float: left;
        margin: 5px;
        padding: 5px;
        border: 3px solid #9E9E9E;
        cursor: pointer;
    }

    .product_image:hover{
        border: 3px solid #000;
    }
    .product_image_back{
        background-size: contain!important;
        background-repeat: no-repeat!important;
        height: 100px!important;
        background-position-x: center!important;
        background-position-y: center!important;
    }
</style>
<!-- Main content -->
<section class="content" ng-controller="category_controller">
    <div class="row">

        <!--list of category-->
        <div class='col-md-6'>
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h3 class="panel-title">Website Menu</h3>
                </div>
                <div class="panel-body">
                    <div class="col-md-4">
                        <div id="using_json_2" class="demo">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end of list category-->


        <!--add category-->
        <div class='col-md-6'>
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h3 class="panel-title">Add/Edit Menu</h3>
                </div>
                <div class="panel-body">


                    <form action="#" method="post">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Parent Manu</label><br/>
                            <span class='categorystring'>{{selectedCategory.category_string}}</span>

                            <button id='editbutton' ng-click="editData()" type='button' class='btn btn-default btn-sm cat_button' style='margin-left:15px;'>
                                <i class='fa fa-edit'></i>
                            </button>
                            <a id='deletebutton'  ng-click="deleteData(selectedCategory.selected.id)" ng-if="selectedCategory.selected.children.length == 0"  type='button' class='btn btn-default btn-sm cat_button'>
                                <i class='fa fa-trash'></i>
                            </a>

                            <input type='hidden' id='parent_id' value='0' name='parent_id' ng-model="selectedCategory.category.parent_id">
                        </div>
                        <div class="form-group">
                            <label for="">Page Title</label>
                            <input  type="text" class="form-control" name="category_name" id="category_name"  placeholder="Page Title" ng-model="selectedCategory.category.category_name">
                        </div>
                        <div class="form-group">
                                <label for="">Link </label>
                                <input type="text" class="form-control" disabled=""  
                                       name="description" id="description" placeholder="Page Link"
                                      VALUE="<?php echo SITE_URL;?>{{selectedCategory.category.description}}">
                            </div>

                        <div ng-if="selectedCategory.category.is_editable == 'yes'">
                            
                            <div class="form-group"  >
                                <select name="page_url" class="form-control" ng-model="selectedCategory.category.description">
                                    <?php
                                    foreach ($pages_list as $key => $value) {
                                        ?>
                                        <option value="<?php echo $value["uri"]; ?>"><?php echo $value["title"]; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <br/>
                        <button id='submit_button' type="submit" name="submit" class="btn btn-primary" value="{{selectedCategory.operation}}">{{selectedCategory.operation}}</button>
                        <button id='submit_button' type="button"  class="btn btn-warning" ng-click="cencel()">Cancel</button>

                    </form>
                </div>
            </div>
        </div>
        <!--end of add category-->

    </div>



    <!--image model-->
    <!-- Button trigger modal -->

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Images</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <?php
                        foreach ($images as $key => $value) {
                            ?>
                            <div class="">
                                <div class="product_image product_image_back" ng-click="selectImage('<?php echo $value->image; ?>')" style="background: url(<?php echo (base_url() . "assets/media/" . $value->image); ?>)">
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!--end of image model-->


</section>
<!-- end col-6 -->
</div>


<?php
$this->load->view('layout/footer');
?> 

<script>
    var jsondata;
    var selectedcategory;

    Admin.controller('category_controller', function ($scope, $http, $filter, $timeout) {
        $scope.selectedCategory = {
            "selected": {}, "parents": [],
            "category_string": "Main Manu",
            "category": {'parent_id': '0', 'category_name': '', 'description': '', 'id': '', "image": "", "is_editable": "yes"},
            "operation": "Add Menu",
            
        };

        $scope.selectImage = function (image) {
            console.log(image)
            $scope.selectedCategory.category.image = image;
            $("#myModal").modal("hide");
        }


        var url = "<?php echo base_url(); ?>index.php/WebControl/category_api";
        $http.get(url).then(function (rdata) {
            $scope.categorydata = rdata.data;
            $('#using_json_2').jstree({'core': {
                    'data': $scope.categorydata.tree
                }});
        })

        $scope.resetData = function () {
            $scope.selectedCategory.operation = "Add Menu";
            $scope.selectedCategory.category.parent_id = '0';
            $scope.selectedCategory.category.category_name = '';
            $scope.selectedCategory.category.description = '';
            $scope.selectedCategory.category.is_editable = 'yes';
        }

        $scope.cencel = function () {
            $scope.resetData();
        }


        $(document).on("click", "[selectcategory]", function (event) {
            var catid = $(this).attr("selectcategory");
            var objdata = $('#using_json_2').jstree('get_node', catid);
            var catlist = objdata.parents;

            $scope.resetData();

            $timeout(function () {
                $scope.selectedCategory.selected = objdata;
                var catsst = [];
                for (i = catlist.length + 1; i >= 0; i--) {
                    var catid = catlist[i];
                    var catstr = $scope.categorydata.list[catid];
                    if (catstr) {
                        catsst.push(catstr.text);
                    }
                }
                catsst.push(objdata.text);
                $("#parent_id").val(objdata.id);
                $scope.selectedCategory.category_string = catsst.join("->")
            }, 100)
        })

        //edit data
        $scope.editData = function () {
            console.log($scope.selectedCategory.selected.id);
            $scope.selectedCategory.operation = "Edit";
            var cobj = $scope.categorydata.list[$scope.selectedCategory.selected.id];
            console.log(cobj);
            $scope.selectedCategory.category.parent_id = cobj.id;
            $scope.selectedCategory.category.category_name = cobj.text;
            $scope.selectedCategory.category.description =  cobj.page_url;
            $scope.selectedCategory.category.is_editable = cobj.is_editable;

        }
        //edit data



        //delete data
        $scope.deleteData = function (cateid) {
            var url = "<?php echo base_url(); ?>index.php/WebControl/categorie_delete/" + cateid;
            $http.get(url).then(function (rdata) {
                window.location.reload();
            })
        }
        //end of delete data


    })


</script>