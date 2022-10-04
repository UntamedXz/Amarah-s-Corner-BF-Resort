<?php
session_start();
require_once '../includes/database_conn.php';
if (!isset($_SESSION['adminloggedin']) || $_SESSION['adminloggedin'] != true) {
    header("Location: ./login");
} else {
    $admin_id = $_SESSION['admin_id'];
}

$get_admin_info = mysqli_query($conn, "SELECT * FROM admin WHERE admin_id = $admin_id");

$info = mysqli_fetch_array($get_admin_info);

$userProfileIcon = $info['profile_image'];
$admin_type = $info['admin_type'];

if(isset($_GET['id'])) {
    $product_id = $_GET['id'];

    $get_product_info = mysqli_query($conn, "SELECT * FROM product WHERE product_id = $product_id");
    $get_variable_info = mysqli_query($conn, "SELECT * FROM product_variation WHERE product_id = $product_id");

    $product_info = mysqli_fetch_array($get_product_info);
    $variable_info = mysqli_fetch_array($get_variable_info);

    $product_name = $product_info['product_title'];
    $product_desc = $product_info['product_desc'];
    $product_url = $product_info['product_slug'];
    $product_type = $product_info['product_type'];
    $product_category = $product_info['category_id'];
    $product_subcategory = $product_info['subcategory_id'];
    $product_img = $product_info['product_img1'];
    $product_keyword = $product_info['product_keyword'];
    $product_price = $product_info['product_price'];
    $product_sale = $product_info['product_sale'];
    $product_status = $product_info['product_status'];
    $product_stock = $product_info['product_stock'];
} else {
    $product_id = null;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">


    <!-- datatable lib -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.0/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Cabin:wght@400;500;600;700;800&family=Poppins:wght@200;300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="../assets/css/admin.css">
    <title>Admin Panel</title>
</head>

<body>
    <!-- TOAST -->
    <div class="toast" id="toast">
        <div class="toast-content" id="toast-content">
            <i id="toast-icon" class="fa-solid fa-triangle-exclamation warning"></i>

            <div class="message">
                <span class="text text-1" id="text-1"></span>
                <span class="text text-2" id="text-2"></span>
            </div>
        </div>
        <i class="fa-solid fa-xmark close"></i>
        <div class="progress"></div>
    </div>

    <?php include 'top.php'; ?>

    <!-- MAIN -->
    <main>
        <h1 class="title">Update Product</h1>
        <ul class="breadcrumbs">
            <li><a href="index">Home</a></li>
            <li class="divider">/</li>
            <li><a href="product">View Product</a></li>
            <li class="divider">/</li>
            <li><a href="insert-simple-product" class="active">Insert Product</a></li>
        </ul>

        <section class="insert-products">
            <form id="insert_product" action="" enctype="multipart/form-data">
                <div class="left_group">
                    <input type="hidden" name="product_id" id="product_id" value="<?php if(isset($product_id)) { echo $product_id; } ?>">
                    <div class="form_group">
                        <span class="label">
                            Product Name
                        </span>
                        <input type="text" name="product_name" id="product_name" value="<?php if(isset($product_name)) { echo $product_name; } ?>">
                        <span class="error error_product_name"></span>
                    </div>
                    <div class="form_group">
                        <span class="label">Product Description</span>
                        <textarea name="product_desc" id="product_desc" cols="30" rows="4"><?php if(isset($product_desc)) { echo $product_desc; } ?></textarea>
                        <span class="error error_product_desc"></span>
                    </div>
                    <div class="form_group">
                        <span class="label">
                            Product URL
                        </span>
                        <input type="text" name="product_slug" id="product_slug" value="<?php if(isset($product_url)) { echo $product_url; } ?>">
                        <span class="error error_product_slug"></span>
                    </div>
                    <div class="form_group display_price" style="display: none;">
                        <span class="label">
                            Display Price
                        </span>
                        <input type="text" name="display_price" id="display_price" value="<?php if(isset($product_price)) { echo $product_price; } ?>">
                        <span class="error error_display_price"></span>
                    </div>
                    <!-- SIMPLE -->
                    <div class="simple_product_tab">
                        <div class="tab">
                            <button class="general_simple_btn">General</button>
                            <button class="inventory_simple_btn">Inventory</button>
                        </div>
                        <div class="tab-content">
                            <div class="tab general_simple_tab">
                                <div class="hgroup">
                                    <div class="label">
                                        <span>Regular Price</span>
                                    </div>
                                    <div class="input">
                                        <input type="text" name="reg_price" id="reg_price" value="<?php if(isset($product_price)) { echo $product_price; } ?>">
                                    </div>
                                </div>
                                <div class="hgroup">
                                    <div class="label">
                                        <span>Sale Price</span>
                                    </div>
                                    <div class="input">
                                        <input type="text" name="sale_price" id="sale_price" value="<?php if(isset($product_sale)) { echo $product_sale; } ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="tab inventory_simple_tab">
                                <div class="hgroup">
                                    <div class="label">
                                        <span>Manage stock?</span>
                                    </div>
                                    <div class="input">
                                        <input type="checkbox" name="manage_stock" id="manage_stock" <?php if(isset($product_stock)) {echo 'checked'; } ?>>
                                        <span style="padding-left: 5px;">Manage stock level (quantity)</span>
                                    </div>
                                </div>
                                <div class="hgroup stock_qty_field" style="display: none;">
                                    <div class="label">
                                        <span>Stock quantity</span>
                                    </div>
                                    <div class="input">
                                        <input type="text" name="stock_qty" id="stock_qty" value="<?php if(isset($product_stock)) { echo $product_stock; } ?>">
                                    </div>
                                </div>
                                <div class="hgroup">
                                    <div class="label">
                                        <span>Stock status</span>
                                    </div>
                                    <div class="input">
                                        <select name="stock_status" id="stock_status">
                                            <?php
                                            $get_stock_status = mysqli_query($conn, "SELECT * FROM stock_status");

                                            foreach($get_stock_status as $stock_status) {

                                            $is_selected = '';
                                            if(isset($product_stock)) {
                                                if($product_stock == $stock_status['stock_id']) {
                                                    $is_selected = "selected";
                                                }
                                            }
                                            ?>
                                            <option value="<?php echo $stock_status['stock_id']; ?>" <?php echo $is_selected; ?>><?php echo $stock_status['stock']; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- VARIABLE -->
                    <div class="variable_product_tab" style="display: none;">
                        <div class="tab">
                            <button class="attributes_btn">Attributes</button>
                            <button class="variations_btn">Variations</button>
                        </div>
                        <div class="tab-content">
                            <div class="tab attributes_tab">
                                <div class="hgroup">
                                    <div class="label">
                                        <select name="attribute" id="attribute">
                                            <option value="add_attribute">Custom product attribute</option>
                                        </select>
                                        <button id="add_attribute_field">Add</button>
                                    </div>
                                </div>
                                <div class="attribute_field" id="attribute_field">
                                    <?php
                                        if(isset($product_id)) {
                                            $get_attributes = mysqli_query($conn, "SELECT * FROM product_attribute WHERE product_id = $product_id");

                                            $count = 1000;
                                            foreach($get_attributes as $attributes) {
                                                $attribute_id = $attributes['attribute_id'];
                                                $count++;
                                                ?>
                                                <input type="hidden" name="attribute_id[]" id="attribute_id" value="<?php echo $attributes['attribute_id'] ?>">
                                                    <div class="hgroup" id="attribute_loop_<?php echo $count; ?>">
                                                        <div class="vname vgroup">
                                                            <span>Name:</span>
                                                            <input type="text" name="attribute_name[]" id="attribute_name" value="<?php echo $attributes['attribute_name']; ?>">
                                                        </div>
                                                        <div class="vvalue vgroup">
                                                            <span>Value(s):</span>
                                                            <input type="text" name="attribute_values[]" id="attribute_values" placeholder="Enter some text, or some attributes by &rdquo;|&rdquo; separating values." value="<?php $get_variation = mysqli_query($conn, "SELECT variation_value FROM product_variation WHERE attribute_id = $attribute_id"); $items = array(); foreach($get_variation as $variation) { $items[] = $variation['variation_value']; } print implode("|", $items); ?>">
                                                        </div>
                                                    </div>
                                                    <!-- <div class="hgroup">
                                                        <div class="vname vgroup">
                                                            <span>Regular Price:</span>
                                                            <input type="text" name="reg_price_variable" id="reg_price_variable">
                                                        </div>
                                                    </div> -->
                                                <button class="remove_attribute_field field_count<?php echo $count; ?>" data-id="<?php echo $count; ?>" id="field_count<?php echo $count; ?>">Remove</button>
                                                <?php
                                            }
                                        }
                                    ?>
                                </div>
                                <input type="hidden" name="attribute_field_count" id="attribute_field_count" value="0">
                                <button class="save_attr" form="insert_product">Save Attributes</button>
                            </div>
                            <div class="tab variation_tab" style="display: none;">
                            <?php
                            if(isset($product_id)) {
                                $get_variation = mysqli_query($conn, "SELECT * FROM product_variation WHERE product_id = $product_id");

                                foreach($get_variation as $variation_info) {
                                    ?>
                                    <div class="variation_field" id="variation_field">
                                        <input type="hidden" name="variation_id[]" id="variation_id" value="<?php echo $variation_info['variation_id'] ?>">
                                        <div class="hgroup">
                                            <div class="vgroup">
                                                <span>Variation</span>
                                                <input style="background-color: #EBEBE4;" type="text" name="variation_name[]" id="variation_name" readonly value="<?php echo $variation_info['variation_value']; ?>">
                                            </div>
                                        </div>
                                        <div class="hgroup">
                                            <div class="vgroup">
                                                <span>Regular price</span>
                                                <input type="text" name="variable_reg_price[]" id="variable_reg_price" value="<?php echo $variation_info['product_price']; ?>">
                                            </div>
                                            <div class="vgroup">
                                                <span>Sale price</span>
                                                <input type="text" name="variable_sale_price[]" id="variable_sale_price" value="<?php echo $variation_info['product_sale']; ?>">
                                            </div>
                                        </div>
                                        <div class="hgroup">
                                            <div class="vgroup">
                                                <span>Stock quantity</span>
                                                <input type="text" name="variable_stock[]" id="variable_stock" value="<?php echo $variation_info['stock']; ?>">
                                            </div>
                                            <div class="vgroup">
                                                <span>Stock status</span>
                                                <select style="height: 30px; line-height: 30px; border: none; outline: none; border-radius: 5px;" name="variable_stock_status[]" id="variable_stock_status">
                                                    <?php   
                                                    $get_status = mysqli_query($conn, "SELECT * FROM stock_status");

                                                    foreach($get_status as $variable_status) {

                                                        $isSelected = '';
                                                        if ($variation_info['stock_status'] == $variable_status['stock_id']) {
                                                                $isSelected = "selected";
                                                        }
                                                    ?>
                                                    <option value="<?php echo $variable_status['stock_id']; ?>" <?php echo $isSelected; ?>><?php echo $variable_status['stock']; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="right_group">
                    <div class="form_group">
                        <span class="label">Product Type</span>
                        <select name="product_type" id="product_type">
                            <?php
                            $get_product_type = mysqli_query($conn, "SELECT * FROM product_type");
                            
                            foreach($get_product_type as $type) {
                                $isSelected = '';
                                if ($product_type == $type['product_type_id']) {
                                    $isSelected = "selected";
                                }
                            ?>
                            <option value="<?php echo $type['product_type_id']; ?>" <?php echo $isSelected; ?>><?php echo $type['product_type']; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <span class="error error_product_type"></span>
                    </div>
                    <div class="form_group">
                        <span class="label">Product Category</span>
                        <select name="product_category" id="product_category">
                            <option selected="selected" value="">SELECT CATEGORY</option>
                            <?php 
                            $get_category = mysqli_query($conn, "SELECT * FROM category");

                            foreach($get_category as $cat) {
                                $isSelected = '';
                                if ($product_category == $cat['category_id']) {
                                    $isSelected = "selected";
                                }
                            ?>
                            <option value="<?php echo $cat['category_id']; ?>" <?php echo $isSelected; ?>><?php echo $cat['category_title']; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <span class="error error_product_cat"></span>
                    </div>
                    <?php
                    if(isset($product_subcategory)) {
                    $get_subcategory = mysqli_query($conn, "SELECT * FROM subcategory WHERE category_id = $product_category");

                    if(mysqli_num_rows($get_subcategory) > 0) {
                        
                    ?>
                    <div class="form_group subcategory_group">
                        <span class="label">
                            Product Subcategory
                        </span>
                        <select name="product_subcategory" id="product_subcategory">
                            <option selected="selected" value="">SELECT SUBCATEGORY</option>
                            <?php
                            foreach($get_subcategory as $subcategory) {

                            $isSelected = '';
                            if ($product_subcategory == $subcategory['subcategory_id']) {
                                $isSelected = "selected";
                            }
                            ?>
                            <option value="<?php echo $subcategory['subcategory_id']; ?>" <?php echo $isSelected; ?>><?php echo $subcategory['subcategory_title']; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <span class="error error_product_subcat"></span>
                    </div>
                    <?php
                    }
                    } else {
                    ?>
                    <div class="form_group subcategory_group" style="display: none;">
                        <span class="label">
                            Product Subcategory
                        </span>
                        <select name="product_subcategory" id="product_subcategory">
                            <option selected="selected" value="">SELECT SUBCATEGORY</option>
                        </select>
                        <span class="error error_product_subcat"></span>
                    </div>
                    <?php
                    }
                    ?>
                    <div class="form_group">
                        <span class="label">Insert Image</span>
                        <input class="image" type="file" name="product_image" id="product_image" accept=".jpg, .jpeg, .png">
                        <span class="error error_product_image"></span>
                    </div>
                    <div class="form_group">
                        <span class="label">Image Preview</span>
                        <img style="width: 100px;" src="../assets/images/<?php if(isset($product_img)) { echo $product_img; } ?>" id="file">
                    </div>
                    <div class="form_group">
                        <span class="label">Product Keyword</span>
                        <input class="product_keyword" type="text" name="product_keyword" id="product_keyword" value="<?php if(isset($product_keyword)) { echo $product_keyword; } ?>">
                        <span class="error error_product_keyword"></span>
                    </div>
                </div>
            </form>
            <button type="submit" class="insert_product" form="insert_product">UPDATE PRODUCT</button>
        </section>

        <script>
            $(document).ready(function() {
                $("#product_category").change(function() {
                    var category_id = $(this).val();
                    $.ajax({
                        url: "./functions/crud/product",
                        type: "POST",
                        data: {
                            category_id: category_id,
                            get_subcategory: true,
                        },
                        success: function(data) {
                            if(data === 'empty') {
                                $('.subcategory_group').hide();
                            } else {
                                $('.subcategory_group').show();
                                $('#product_subcategory').html(data);
                            }
                        }
                    })
                })

                $('#product_image').on('change', function() {
                    var file = this.files[0];

                    if(file) {
                        var reader = new FileReader();

                        reader.addEventListener('load', function() {
                            $('#file').attr("src", this.result);
                        })

                        reader.readAsDataURL(file);
                    }
                })

                $('.inventory_simple_btn').click(function(e) {
                    e.preventDefault();
                    $('.general_simple_btn').css('background-color', '#ffaf08');
                    $('.general_simple_btn').css('color', '#070506');
                    $('.inventory_simple_btn').css('background-color', 'transparent');
                    $('.inventory_simple_btn').css('color', '#ffaf08');
                    $('.general_simple_tab').css('display', 'none');
                    $('.inventory_simple_tab').css('display', 'flex');
                })

                $('.general_simple_btn').click(function(e) {
                    e.preventDefault();
                    $('.inventory_simple_btn').css('background-color', '#ffaf08');
                    $('.inventory_simple_btn').css('color', '#070506');
                    $('.general_simple_btn').css('background-color', 'transparent');
                    $('.general_simple_btn').css('color', '#ffaf08');
                    $('.inventory_simple_tab').css('display', 'none');
                    $('.general_simple_tab').css('display', 'flex');
                })

                $('.variations_btn').click(function(e) {
                    e.preventDefault();
                    $('.attributes_btn').css('background-color', '#ffaf08');
                    $('.attributes_btn').css('color', '#070506');
                    $('.variations_btn').css('background-color', 'transparent');
                    $('.variations_btn').css('color', '#ffaf08');
                    $('.attributes_tab').css('display', 'none');
                    $('.variation_tab').css('display', 'flex');
                })

                $('.attributes_btn').click(function(e) {
                    e.preventDefault();
                    $('.variations_btn').css('background-color', '#ffaf08');
                    $('.variations_btn').css('color', '#070506');
                    $('.attributes_btn').css('background-color', 'transparent');
                    $('.attributes_btn').css('color', '#ffaf08');
                    $('.variation_tab').css('display', 'none');
                    $('.attributes_tab').css('display', 'flex');
                })

                $('#manage_stock').click(function() {
                    if($(this).prop("checked") == true) {
                        $('.stock_qty_field').css('display', 'flex');
                    } else if($(this).prop("checked") == false) {
                        $('.stock_qty_field').css('display', 'none');
                    }
                })

                if($('#manage_stock').is(':checked')) {
                    $('.stock_qty_field').css('display', 'flex');
                }

                $('#manage_stock_variable').click(function() {
                    if($(this).prop("checked") == true) {
                        $('.stock_qty_field_variable').css('display', 'flex');
                    } else if($(this).prop("checked") == false) {
                        $('.stock_qty_field_variable').css('display', 'none');
                    }
                })

                $('#product_type').change(function(e) {
                    e.preventDefault();
                    var selected_value = $(this).val();
                    if(selected_value === '1') {
                        $('.simple_product_tab').css('display', 'flex');
                        $('.variable_product_tab').css('display', 'none');
                    } else if(selected_value === '2') {
                        $('.variable_product_tab').css('display', 'flex');
                        $('.simple_product_tab').css('display', 'none');
                        $('.display_price').css('display', 'flex');
                    }
                });

                if($('#product_type option:selected').val() == '1') {
                    $('.simple_product_tab').css('display', 'flex');
                    $('.variable_product_tab').css('display', 'none');
                } else {
                    $('.variable_product_tab').css('display', 'flex');
                    $('.simple_product_tab').css('display', 'none');
                    $('.display_price').css('display', 'flex');
                }

                $('#add_attribute_field').click(function(e) {
                    e.preventDefault();
                    
                    var attribute_field_count = $('#attribute_field_count').val();
                    attribute_field_count++;
                    $('#attribute_field_count').val(attribute_field_count);

                    $('.attribute_field').append('<input type="text" name="attribute_id[]" id="attribute_id"><div class="hgroup" id="attribute_loop_'+attribute_field_count+'"><div class="vname vgroup"><span>Name:</span><input type="text" name="attribute_name[]" id="attribute_name" required></div><div class="vvalue vgroup"><span>Value(s):</span><input type="text" name="attribute_values[]" id="attribute_values" placeholder="Enter some text, or some attributes by &rdquo;|&rdquo; separating values." required></div></div><button class="remove_attribute_field field_count"'+attribute_field_count+'"" data-id="'+attribute_field_count+'" id="field_count'+attribute_field_count+'">Remove</button>');
                });

                $(document).on('click', '.remove_attribute_field', function(e) {
                    e.preventDefault();
                    var remove_id = $(this).data("id");
                    // alert(remove_id);
                    $('#attribute_loop_'+remove_id).remove();
                    $('#field_count'+remove_id).remove();

                    var attribute_field_count = $('#attribute_field_count').val();
                    attribute_field_count--;
                    $('#attribute_field_count').val(attribute_field_count);
                })

                $('#product_name').keyup(function() {
                    let str = $(this).val();
                    let trims = $.trim(str);
                    let slug = trims.replace(/[^a-z0-9]/gi, '-').replace(/-+/g, '-').replace(/^|-$/g, '')
                    $('#product_slug').val(slug.toLowerCase());
                    $('#product_keyword').val(str);
                })


                // SUBMIT SIMPLE PRODUCT
                $('#insert_product').on('submit', function(e) {
                    e.preventDefault();

                    if($('#product_type').val() == '1') {
                        if($('#product_category').val() == '') {
                            $('.error_product_cat').text('Category required!');
                        } else {
                            $('.error_product_cat').text('');
                        }

                        if($('.subcategory_group').css('display') == 'none') {
                            $('#product_subcategory').val('');
                            $('.error_product_subcat').text('');
                        } else {
                            if($('#product_subcategory').val() == '') {
                                $('.error_product_subcat').text('Subcategory required!');
                            } else {
                                $('.error_product_subcat').text('');
                            }
                        }

                        if($.trim($('#product_name').val()).length == 0) {
                            $('.error_product_name').text('Product name required!');
                        } else {
                            $('.error_product_name').text('');
                        }

                        if($.trim($('#product_slug').val()).length == 0) {
                            $('.error_product_slug').text('Product URL required!');
                        } else {
                            $('.error_product_slug').text('');
                        }

                        if($.trim($('#product_image').val()).length == 0) {
                            $('.error_product_image').text('');
                        } else {
                            var img_ext = $('#product_image').val().split('.').pop().toLowerCase();

                            if($.inArray(img_ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
                                $('.error_product_image').text('File not supported');
                            } else {
                                var img_size = $('#product_image')[0].files[0].size;

                                if(img_size > 10485760) {
                                    $('.error_product_image').text('File too large!');
                                } else {
                                    $('.error_product_image').text('');
                                }
                            }
                        }

                        if($.trim($('#product_keyword').val()).length == 0) {
                            $('.error_product_keyword').text('Product keyword required!');
                        } else {
                            $('.error_product_keyword').text('');
                        }

                        if($('.error_product_cat').text() != '' || $('.error_product_subcat').text() != '' || $('.error_product_name').text() != '' || $('.error_product_slug').text() != '' || $('.error_product_image').text() != '' || $('.error_product_keyword').text() != '') {
                            $('#toast').addClass('active');
                            $('.progress').addClass('active');
                            $('.text-1').text('Error!');
                            $('.text-2').text('Fill all required fields!');
                            setTimeout(() => {
                                $('#toast').removeClass("active");
                                $('.progress').removeClass("active");
                            }, 5000);
                        } else {
                            var form = new FormData(this);
                            form.append('insert_simple', true);
                            $.ajax({
                                url: "./functions/crud/product",
                                type: "POST",
                                data: form,
                                contentType: false,
                                cache: false,
                                processData: false,
                                success: function(data) {
                                    var str = data;
                                    if(str.includes("insert-product?id")) {
                                        location.href = data;
                                    } else if(data === 'Product already exist!') {
                                        $('#toast').addClass('active');
                                        $('.progress').addClass('active');
                                        $('.text-1').text('Error!');
                                        $('.text-2').text('Product already exist!');
                                        setTimeout(() => {
                                            $('#toast').removeClass("active");
                                            $('.progress').removeClass("active");
                                        }, 5000);
                                    } else if(data == 'attributes saved') {
                                        location.reload();
                                    } else {
                                        $('#toast').addClass('active');
                                        $('.progress').addClass('active');
                                        $('.text-1').text('Error!');
                                        $('.text-2').text('Something went wrong!');
                                        setTimeout(() => {
                                            $('#toast').removeClass("active");
                                            $('.progress').removeClass("active");
                                        }, 5000);
                                    }
                                    console.log(data);
                                }
                            })
                        }
                    } else {
                        if($('#product_category').val() == '') {
                            $('.error_product_cat').text('Category required!');
                            } else {
                                $('.error_product_cat').text('');
                            }

                            if($('.subcategory_group').css('display') == 'none') {
                                $('#product_subcategory').val('');
                                $('.error_product_subcat').text('');
                            } else {
                                if($('#product_subcategory').val() == '') {
                                    $('.error_product_subcat').text('Subcategory required!');
                                } else {
                                    $('.error_product_subcat').text('');
                                }
                            }

                            if($.trim($('#product_name').val()).length == 0) {
                                $('.error_product_name').text('Product name required!');
                            } else {
                                $('.error_product_name').text('');
                            }

                            if($.trim($('#product_slug').val()).length == 0) {
                                $('.error_product_slug').text('Product URL required!');
                            } else {
                                $('.error_product_slug').text('');
                            }

                            if($.trim($('#display_price').val()).length == 0) {
                                $('.error_display_price').text('Display price required!');
                            } else {
                                $('.error_display_price').text('');
                            }

                            if($.trim($('#product_image').val()).length == 0) {
                                $('.error_product_image').text('');
                            } else {
                                var img_ext = $('#product_image').val().split('.').pop().toLowerCase();

                                if($.inArray(img_ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
                                    $('.error_product_image').text('File not supported');
                                } else {
                                    var img_size = $('#product_image')[0].files[0].size;

                                    if(img_size > 10485760) {
                                        $('.error_product_image').text('File too large!');
                                    } else {
                                        $('.error_product_image').text('');
                                    }
                                }
                            }

                            if($.trim($('#product_keyword').val()).length == 0) {
                                $('.error_product_keyword').text('Product keyword required!');
                            } else {
                                $('.error_product_keyword').text('');
                            }

                            if($('.error_product_cat').text() != '' || $('.error_product_subcat').text() != '' || $('.error_product_name').text() != '' || $('.error_product_slug').text() != '' || $('.error_product_image').text() != '' || $('.error_product_keyword').text() != '') {
                                $('#toast').addClass('active');
                                $('.progress').addClass('active');
                                $('.text-1').text('Error!');
                                $('.text-2').text('Fill all required fields!');
                                setTimeout(() => {
                                    $('#toast').removeClass("active");
                                    $('.progress').removeClass("active");
                                }, 5000);
                            } else {
                                var form = new FormData(this);
                                form.append('update_variable', true);
                                $.ajax({
                                    url: "./functions/crud/product",
                                    type: "POST",
                                    data: form,
                                    contentType: false,
                                    cache: false,
                                    processData: false,
                                    success: function(data) {
                                        var str = data;
                                        if(str.includes("update-product?id")) {
                                            location.href = data;
                                        } else if(str.includes("Undefined array key 2")) {
                                            location.reload();
                                        } else if(data == '') {
                                            location.reload();
                                        } else if(str.includes("Uncaught TypeError: count():")) {
                                            location.reload();
                                        } else if(data === 'Product already exist!') {
                                            $('#toast').addClass('active');
                                            $('.progress').addClass('active');
                                            $('.text-1').text('Error!');
                                            $('.text-2').text('Product already exist!');
                                            setTimeout(() => {
                                                $('#toast').removeClass("active");
                                                $('.progress').removeClass("active");
                                            }, 5000);
                                        } else if(data == 'attributes saved') {
                                            location.reload();
                                        } else {
                                            $('#toast').addClass('active');
                                            $('.progress').addClass('active');
                                            $('.text-1').text('Error!');
                                            $('.text-2').text('Something went wrong!');
                                            setTimeout(() => {
                                                $('#toast').removeClass("active");
                                                $('.progress').removeClass("active");
                                            }, 5000);
                                        }
                                        console.log(data);
                                    }
                                })
                            }
                    }
                })
            })

        </script>

        <?php include 'bottom.php' ?>

</body>

</html>