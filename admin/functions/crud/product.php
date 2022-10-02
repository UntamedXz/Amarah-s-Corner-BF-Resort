<?php
session_start();
require_once '../../../includes/database_conn.php';

// if (isset($_POST['product_id'])) {
//     $productId = $_POST['product_id'];

//     $checkProduct = mysqli_query($conn, "SELECT * FROM product WHERE product_id = $productId");

//     $encryptedId = urlencode(base64_encode($productId));

//     if(mysqli_num_rows($checkProduct) < 0) {
//         echo "insert-variable-product?id=" . $productId;
//     } else {
//         echo "update-simple-product?id=" . $encryptedId;
//     }
// }

if(isset($_POST['delete_product'])) {
    if (!empty($_POST['delete_product_id'])) {
        $deleteProductId = $_POST['delete_product_id'];
    
        $getProduct = mysqli_query($conn, "SELECT * FROM product WHERE product_id = $deleteProductId");
    
        $productImg = '';
    
        while ($row = mysqli_fetch_array($getProduct)) {
            $productImg = $row['product_img1'];
        }
    
        if (!empty($productImg)) {
            $deleteProduct = mysqli_query($conn, "DELETE FROM product WHERE product_id = $deleteProductId");
    
            if ($deleteProduct) {
                echo 'deleted';
                unlink('../../../assets/images/' . $productImg);
            }
        } else {
            $deleteProduct = mysqli_query($conn, "DELETE FROM product WHERE product_id = $deleteProductId");
    
            if ($deleteProduct) {
                echo 'deleted';
            }
        }
    }    
}

if(isset($_POST['get_subcategory'])) {
    if (isset($_POST['category_id'])) {
        $categoryId = $_POST['category_id'];
    
        $getSubcategory = mysqli_query($conn, "SELECT * FROM subcategory WHERE category_id = '$categoryId'");
    
        if (mysqli_num_rows($getSubcategory) != 0) {
    ?>
            <span>Product Subcategory</span>
            <select name="product_subcategory" id="product_subcategory">
                <option value="" selected="selected">SELECT SUBCATEGORY</option>
                <?php
                foreach ($getSubcategory as $subcategoryRow) {
                ?>
                    <option value="<?php echo $subcategoryRow['subcategory_id']; ?>"><?php echo $subcategoryRow['subcategory_title']; ?></option>
                <?php
                }
                ?>
            </select>
    <?php
        } else {
            echo 'empty';
        }
    }
}

if(isset($_POST['insert_simple_product_process'])) {
    $productCategory = $_POST['category-list'];
    $productSubcategory = $_POST['subcategory-list'];
    $productTitle = mysqli_real_escape_string($conn, ucwords($_POST['product_title']));
    $productUrl = $_POST['product_url'];
    $productPrice = $_POST['product_price'];
    $productSalePrice = $_POST['product_salePrice'];
    $productImage1Name = $_FILES['product_image1']['name'];
    $productImage1TmpName = $_FILES['product_image1']['tmp_name'];
    $productKeyword = $_POST['product_keyword'];
    $productDescription = $_POST['product_desc'];
    $productStatus = $_POST['product_status'];

    if ($productSubcategory == 'SELECT SUBCATEGORY') {
        if ($_FILES['product_image1']['error'] === 4) {
            $checkProduct = mysqli_query($conn, "SELECT * FROM product WHERE product_title = '$productTitle'");

            if (mysqli_num_rows($checkProduct) > 0) {
                echo 'product already exist';
            } else {
                $insertProduct = mysqli_query($conn, "INSERT INTO product (category_id, subcategory_id, product_title, product_slug, product_keyword, product_price, product_sale, product_desc, product_status) VALUES ('$productCategory', NULL, '$productTitle', '$productUrl', '$productKeyword', '$productPrice', '$productSalePrice', '$productDescription', '$productStatus')");

                if ($insertProduct) {
                    $getProductId = mysqli_query($conn, "SELECT * FROM product WHERE product_slug = '$productUrl'");
                    $row = mysqli_fetch_array($getProductId);
                    $productId = $row['product_id'];
                    $_SESSION['product_id'] = $productId;
                    $_SESSION['alert'] = 'success';
                    echo 'success';
                } else {
                    echo 'failed';
                }
            }
        } else {
            $checkProduct = mysqli_query($conn, "SELECT * FROM product WHERE product_title = '$productTitle'");

            if (mysqli_num_rows($checkProduct) > 0) {
                echo 'product already exist';
            } else {
                $imgExt = explode('.', $productImage1Name);
                $imgExt = strtolower(end($imgExt));

                $newImageName = uniqid() . '.' . $imgExt;

                move_uploaded_file($productImage1TmpName, '../../../assets/images/' . $newImageName);

                $insertProduct = mysqli_query($conn, "INSERT INTO product (category_id, subcategory_id, product_title, product_slug, product_img1, product_keyword, product_price, product_sale, product_desc, product_status) VALUES ('$productCategory', NULL, '$productTitle', '$productUrl', '$newImageName', '$productKeyword', '$productPrice', '$productSalePrice', '$productDescription', '$productStatus')");

                if ($insertProduct) {
                    $getProductId = mysqli_query($conn, "SELECT * FROM product WHERE product_slug = '$productUrl'");
                    $row = mysqli_fetch_array($getProductId);
                    $productId = $row['product_id'];
                    $_SESSION['product_id'] = $productId;
                    $_SESSION['alert'] = 'success';;
                    echo 'success';
                } else {
                    echo 'failed';
                }
            }
        }
    } else {
        if ($_FILES['product_image1']['error'] === 4) {
            $checkProduct = mysqli_query($conn, "SELECT * FROM product WHERE product_title = '$productTitle'");

            if (mysqli_num_rows($checkProduct) > 0) {
                echo 'product already exist';
            } else {
                $insertProduct = mysqli_query($conn, "INSERT INTO product (category_id, subcategory_id, product_title, product_slug, product_keyword, product_price, product_sale, product_desc, product_status) VALUES ('$productCategory', '$productSubcategory', '$productTitle', '$productUrl', '$productKeyword', '$productPrice', '$productSalePrice', '$productDescription', '$productStatus')");

                if ($insertProduct) {
                    $getProductId = mysqli_query($conn, "SELECT * FROM product WHERE product_slug = '$productUrl'");
                    $row = mysqli_fetch_array($getProductId);
                    $productId = $row['product_id'];
                    $_SESSION['product_id'] = $productId;
                    $_SESSION['alert'] = 'success';
                    echo 'success';
                } else {
                    echo 'failed';
                }
            }
        } else {
            $checkProduct = mysqli_query($conn, "SELECT * FROM product WHERE product_title = '$productTitle'");

            if (mysqli_num_rows($checkProduct) > 0) {
                echo 'product already exist';
            } else {
                $imgExt = explode('.', $productImage1Name);
                $imgExt = strtolower(end($imgExt));

                $newImageName = uniqid() . '.' . $imgExt;

                move_uploaded_file($productImage1TmpName, '../../../assets/images/' . $newImageName);

                $insertProduct = mysqli_query($conn, "INSERT INTO product (category_id, subcategory_id, product_title, product_slug, product_img1, product_keyword, product_price, product_sale, product_desc, product_status) VALUES ('$productCategory', '$productSubcategory', '$productTitle', '$productUrl', '$newImageName', '$productKeyword', '$productPrice', '$productSalePrice', '$productDescription', '$productStatus')");

                if ($insertProduct) {
                    $getProductId = mysqli_query($conn, "SELECT * FROM product WHERE product_slug = '$productUrl'");
                    $row = mysqli_fetch_array($getProductId);
                    $productId = $row['product_id'];
                    $_SESSION['product_id'] = $productId;
                    $_SESSION['alert'] = 'success';
                    echo 'success';
                } else {
                    echo 'failed';
                }
            }
        }
    }
}

if(isset($_POST['update_simple_product_process'])) {
    $productId = $_POST['product_id'];
    $productCategory = $_POST['category-list'];
    $productSubcategory = $_POST['subcategory-list'];
    $productTitle = mysqli_real_escape_string($conn, ucwords($_POST['product_title']));
    $productUrl = $_POST['product_url'];
    $productPrice = $_POST['product_price'];
    $productSalePrice = $_POST['product_salePrice'];
    $productImage1Name = $_FILES['product_image1']['name'];
    $productImage1TmpName = $_FILES['product_image1']['tmp_name'];
    $productKeyword = $_POST['product_keyword'];
    $productOldImage = $_POST['product_oldImage'];
    $product_status = $_POST['product_status'];

    if($productSubcategory == 'SELECT SUBCATEGORY' || $productSubcategory == 'none' || $productSubcategory == '' || !isset($productSubcategory)) {
        if ($_FILES['product_image1']['error'] === 4) {
            $checkProduct = mysqli_query($conn, "SELECT * FROM product WHERE product_title = '$productTitle'");
        
            if (mysqli_num_rows($checkProduct) > 0) {
                $checkIfProductExist2 = mysqli_query($conn, "SELECT * FROM product WHERE product_title = '$productTitle' AND product_id = $productId");
        
                if (mysqli_num_rows($checkIfProductExist2) == 0) {
                    echo 'product already exist';
                } else {
                    $updateProduct = mysqli_query($conn, "UPDATE product SET category_id = '$productCategory', subcategory_id = NULL, product_title = '$productTitle', product_slug = '$productUrl', product_keyword = '$productKeyword', product_price = '$productPrice', product_sale = '$productSalePrice', product_status = $product_status WHERE product_id = $productId");
        
                    if ($updateProduct) {
                        echo 'success';
                    }
                }
            } else {
                $updateProduct = mysqli_query($conn, "UPDATE product SET category_id = '$productCategory', subcategory_id = NULL, product_title = '$productTitle', product_slug = '$productUrl', product_keyword = '$productKeyword', product_price = '$productPrice', product_sale = '$productSalePrice', product_status = $product_status WHERE product_id = $productId");
        
                if ($updateProduct) {
                    echo 'success';
                }
            }
        }
        
        if ($_FILES['product_image1']['error'] === 0) {
            $checkIfProductExist = mysqli_query($conn, "SELECT * FROM product WHERE product_title = '$productTitle'");
        
            if (mysqli_num_rows($checkIfProductExist) > 0) {
                $checkIfProductExist2 = mysqli_query($conn, "SELECT * FROM product WHERE product_title = '$productTitle' AND product_id = $productId");
        
                if (mysqli_num_rows($checkIfProductExist2) == 0) {
                    echo 'product already exist';
                } else {
                    $imgExt = explode('.', $productImage1Name);
                    $imgExt = strtolower(end($imgExt));
        
                    $newImageName = uniqid() . '.' . $imgExt;
        
                    move_uploaded_file($productImage1TmpName, '../../../assets/images/' . $newImageName);
                    unlink('../../../assets/images/' . $productOldImage);
        
                    $updateProduct = mysqli_query($conn, "UPDATE product SET category_id = '$productCategory', subcategory_id = NULL, product_title = '$productTitle', product_slug = '$productUrl', product_img1 = '$newImageName', product_keyword = '$productKeyword', product_price = '$productPrice', product_sale = '$productSalePrice', product_status = $product_status WHERE product_id = $productId");
        
                    if ($updateProduct) {
                        echo 'success';
                    }
                }
            } else {
                $imgExt = explode('.', $productImage1Name);
                $imgExt = strtolower(end($imgExt));
        
                $newImageName = uniqid() . '.' . $imgExt;
        
                move_uploaded_file($productImage1TmpName, '../../../assets/images/' . $newImageName);
                unlink('../../../assets/images/' . $productOldImage);
        
                $updateProduct = mysqli_query($conn, "UPDATE product SET category_id = '$productCategory', subcategory_id = NULL, product_title = '$productTitle', product_slug = '$productUrl', product_img1 = '$newImageName', product_keyword = '$productKeyword', product_price = '$productPrice', product_sale = '$productSalePrice', product_status = $product_status WHERE product_id = $productId");
        
                if ($updateProduct) {
                    echo 'success';
                }
            }
        }
    } else {
        if ($_FILES['product_image1']['error'] === 4) {
            $checkProduct = mysqli_query($conn, "SELECT * FROM product WHERE product_title = '$productTitle'");
        
            if (mysqli_num_rows($checkProduct) > 0) {
                $checkIfProductExist2 = mysqli_query($conn, "SELECT * FROM product WHERE product_title = '$productTitle' AND product_id = $productId");
        
                if (mysqli_num_rows($checkIfProductExist2) == 0) {
                    echo 'product already exist';
                } else {
                    $updateProduct = mysqli_query($conn, "UPDATE product SET category_id = '$productCategory', subcategory_id = '$productSubcategory', product_title = '$productTitle', product_slug = '$productUrl', product_keyword = '$productKeyword', product_price = '$productPrice', product_sale = '$productSalePrice', product_status = $product_status WHERE product_id = $productId");
        
                    if ($updateProduct) {
                        echo 'success';
                    }
                }
            } else {
                $updateProduct = mysqli_query($conn, "UPDATE product SET category_id = '$productCategory', subcategory_id = '$productSubcategory', product_title = '$productTitle', product_slug = '$productUrl', product_keyword = '$productKeyword', product_price = '$productPrice', product_sale = '$productSalePrice', product_status = $product_status WHERE product_id = $productId");
        
                if ($updateProduct) {
                    echo 'success';
                }
            }
        }
        
        if ($_FILES['product_image1']['error'] === 0) {
            $checkIfProductExist = mysqli_query($conn, "SELECT * FROM product WHERE product_title = '$productTitle'");
        
            if (mysqli_num_rows($checkIfProductExist) > 0) {
                $checkIfProductExist2 = mysqli_query($conn, "SELECT * FROM product WHERE product_title = '$productTitle' AND product_id = $productId");
        
                if (mysqli_num_rows($checkIfProductExist2) == 0) {
                    echo 'product already exist';
                } else {
                    $imgExt = explode('.', $productImage1Name);
                    $imgExt = strtolower(end($imgExt));
        
                    $newImageName = uniqid() . '.' . $imgExt;
        
                    move_uploaded_file($productImage1TmpName, '../../../assets/images/' . $newImageName);
                    unlink('../../../assets/images/' . $productOldImage);
        
                    $updateProduct = mysqli_query($conn, "UPDATE product SET category_id = '$productCategory', subcategory_id = '$productSubcategory', product_title = '$productTitle', product_slug = '$productUrl', product_img1 = '$newImageName', product_keyword = '$productKeyword', product_price = '$productPrice', product_sale = '$productSalePrice', product_status = $product_status WHERE product_id = $productId");
        
                    if ($updateProduct) {
                        echo 'success';
                    }
                }
            } else {
                $imgExt = explode('.', $productImage1Name);
                $imgExt = strtolower(end($imgExt));
        
                $newImageName = uniqid() . '.' . $imgExt;
        
                move_uploaded_file($productImage1TmpName, '../../../assets/images/' . $newImageName);
                unlink('../../../assets/images/' . $productOldImage);
        
                $updateProduct = mysqli_query($conn, "UPDATE product SET category_id = '$productCategory', subcategory_id = '$productSubcategory', product_title = '$productTitle', product_slug = '$productUrl', product_img1 = '$newImageName', product_keyword = '$productKeyword', product_price = '$productPrice', product_sale = '$productSalePrice', product_status = $product_status WHERE product_id = $productId");
        
                if ($updateProduct) {
                    echo 'success';
                }
            }
        }
    }
}

if(isset($_POST['insert_simple'])) {
    $product_category = $_POST['product_category'] ?? null;
    $product_subcategory = $_POST['product_subcategory'] ?? null;
    $product_image = $_FILES['product_image']['name'] ?? null;
    $product_image_tmp = $_FILES['product_image']['tmp_name'] ?? null;
    $product_keyword = $_POST['product_keyword'] ?? null;
    $product_name = $_POST['product_name'] ?? null;
    $product_desc = $_POST['product_desc'] ?? null;
    $product_slug = $_POST['product_slug'] ?? null;
    $reg_price = $_POST['reg_price'] ?? null;
    $sale_price = $_POST['sale_price'] ?? null;
    $stock = $_POST['stock_qty'] ?? null;
    $stock_status = $_POST['stock_status'];
    $product_type = $_POST['product_type'];
    $product_id_saved = $_POST['product_id'] ?? null;

    if($product_id_saved == null) {
        if($_FILES['product_image']['error'] === 4) {
            $check_if_product_exist = mysqli_query($conn, "SELECT * FROM product WHERE product_title = '$product_name' AND category_id = $product_category");
    
            if(mysqli_num_rows($check_if_product_exist) > 0) {
                echo 'Product already exist!';
            } else {
                $insert_product = mysqli_query($conn, "INSERT INTO product (category_id, subcategory_id, product_title, product_slug, product_keyword, product_price, product_sale, product_desc, product_status, product_stock, product_type) VALUES ('$product_category', NULLIF('$product_subcategory', ''), '$product_name', '$product_slug', '$product_keyword', NULLIF('$reg_price', ''), NULLIF('$sale_price', ''), NULLIF('$product_desc', ''), '$stock_status', NULLIF('$stock', ''), '$product_type')");
    
                if($insert_product) {
                    $product_id = mysqli_insert_id($conn);
                    echo 'insert-product?id=' . $product_id;
                }
            }
        } else {
            $check_if_product_exist = mysqli_query($conn, "SELECT * FROM product WHERE product_title = '$product_name' AND category_id = $product_category");
    
            if(mysqli_num_rows($check_if_product_exist) > 0) {
                echo 'Product already exist!';
            } else {
                $img_ext = explode('.', $product_image);
                $img_ext = strtolower(end($img_ext));
    
                $new_img_name = uniqid() . '.' . $img_ext;
    
                move_uploaded_file($product_image_tmp, '../../../assets/images/' . $new_img_name);
    
                $insert_product = mysqli_query($conn, "INSERT INTO product (category_id, subcategory_id, product_title, product_slug, product_keyword, product_price, product_sale, product_desc, product_status, product_stock, product_img1, product_type) VALUES ('$product_category', NULLIF('$product_subcategory', ''), '$product_name', '$product_slug', '$product_keyword', NULLIF('$reg_price', ''), NULLIF('$sale_price', ''), NULLIF('$product_desc', ''), '$stock_status', NULLIF('$stock', ''), '$new_img_name', '$product_type')");
    
                if($insert_product) {
                    $product_id = mysqli_insert_id($conn);
                    echo 'insert-product?id=' . $product_id;
                }
            }
        }
    } else {
        if($_FILES['product_image']['error'] === 4) {

            $update_product = mysqli_query($conn, "UPDATE product SET category_id = '$product_category', subcategory_id = NULLIF('$product_subcategory', ''), product_title = '$product_name', product_slug = '$product_slug', product_keyword = '$product_keyword', product_price = NULLIF('$reg_price', ''), product_sale = NULLIF('$sale_price', ''), product_desc = NULLIF('$product_desc', ''), product_status = '$stock_status', product_stock = NULLIF('$stock', ''), product_type = '$product_type' WHERE product_id = $product_id_saved");

            if($update_product) {
                $product_id = mysqli_insert_id($conn);
                echo 'insert-product?id=' . $product_id_saved;
            }
        } else {
            $img_ext = explode('.', $product_image);
            $img_ext = strtolower(end($img_ext));

            $new_img_name = uniqid() . '.' . $img_ext;

            move_uploaded_file($product_image_tmp, '../../../assets/images/' . $new_img_name);

            $update_product = mysqli_query($conn, "UPDATE product SET category_id = '$product_category', subcategory_id, NULLIF('$product_subcategory', ''), product_title = '$product_name', product_slug = '$product_slug', product_keyword = '$product_keyword', product_price = NULLIF('$reg_price', ''), product_sale = NULLIF('$sale_price', ''), product_desc = NULLIF('$product_desc', ''), product_status = '$stock_status', product_stock = NULLIF('$stock', ''), product_type = '$product_type', product_img1 = '$new_img_name' WHERE product_id = $product_id_saved");

            if($update_product) {
                $product_id = mysqli_insert_id($conn);
                echo 'insert-product?id=' . $product_id_saved;
            }
        }
    }
}

if(isset($_POST['insert_variable'])) {
    $product_id_saved = $_POST['product_id'] ?? null;
    $product_category = $_POST['product_category'] ?? null;
    $product_subcategory = $_POST['product_subcategory'] ?? null;
    $product_image = $_FILES['product_image']['name'] ?? null;
    $product_image_tmp = $_FILES['product_image']['tmp_name'] ?? null;
    $product_keyword = $_POST['product_keyword'] ?? null;
    $product_name = $_POST['product_name'] ?? null;
    $product_desc = $_POST['product_desc'] ?? null;
    $product_slug = $_POST['product_slug'] ?? null;
    $attribute_name = $_POST['attribute_name'] ?? null;
    $product_type = $_POST['product_type'];
    $variation_id = $_POST['variation_id'] ?? null;
    $variation_name = $_POST['variation_name'] ?? null;
    $variable_reg_price = $_POST['variable_reg_price'] ?? null;
    $variable_sale_price = $_POST['variable_sale_price'] ?? null;
    $variable_stock = $_POST['variable_stock'] ?? null;
    $variable_stock_status = $_POST['variable_stock_status'] ?? null;

    if($product_id_saved == null) {
        if($_FILES['product_image']['error'] === 4) {
            $check_if_product_exist = mysqli_query($conn, "SELECT * FROM product WHERE product_title = '$product_name' AND category_id = $product_category");
    
            if(mysqli_num_rows($check_if_product_exist) > 0) {
                echo 'Product already exist!';
            } else {
                $insert_product = mysqli_query($conn, "INSERT INTO product (category_id, subcategory_id, product_title, product_slug, product_keyword, product_desc, product_type) VALUES ('$product_category', NULLIF('$product_subcategory', ''), '$product_name', '$product_slug', '$product_keyword', NULLIF('$product_desc', ''), '$product_type')");
    
                if($insert_product) {
                    $product_id = mysqli_insert_id($conn);
    
                    if($attribute_name == '') {
                        echo 'insert-product?id=' . $product_id;
                    } else {
                        if(count($attribute_name) > 0) {
                            for($i = 0; $i < count($attribute_name); $i++) {
                                $insert_attribute = mysqli_query($conn, "INSERT INTO product_attribute (product_id, attribute_name) VALUES ('$product_id', '$attribute_name[$i]')");
    
                                $attribute_id = mysqli_insert_id($conn);
                                
                                $attribute_values = explode('|', $_POST['attribute_values'][$i]);
    
                                foreach($attribute_values as $attr_val) {
                                    $insert_variation = mysqli_query($conn, "INSERT INTO product_variation (product_id, attribute_id, variation_value) VALUES ('$product_id', '$attribute_id', '$attr_val')");
                                }
                            }
                                $attribute_id = mysqli_insert_id($conn);
    
                                echo 'insert-product?id=' . $product_id;
                        }
                    }
                }
            }
        } else {
            $check_if_product_exist = mysqli_query($conn, "SELECT * FROM product WHERE product_title = '$product_name' AND category_id = $product_category");
    
            if(mysqli_num_rows($check_if_product_exist) > 0) {
                echo 'Product already exist!';
            } else {
                $img_ext = explode('.', $product_image);
                $img_ext = strtolower(end($img_ext));
    
                $new_img_name = uniqid() . '.' . $img_ext;
    
                move_uploaded_file($product_image_tmp, '../../../assets/images/' . $new_img_name);
    
                $insert_product = mysqli_query($conn, "INSERT INTO product (category_id, subcategory_id, product_title, product_slug, product_keyword, product_desc, product_type, product_img1) VALUES ('$product_category', NULLIF('$product_subcategory', ''), '$product_name', '$product_slug', '$product_keyword', NULLIF('$product_desc', ''), '$product_type', '$new_img_name')");
    
                if($insert_product) {
                    $product_id = mysqli_insert_id($conn);
                    
                    if($attribute_name == '') {
                        echo 'insert-product?id=' . $product_id;
                    } else {
                        if(count($attribute_name) > 0) {
                            for($i = 0; $i < count($attribute_name); $i++) {
                                $insert_attribute = mysqli_query($conn, "INSERT INTO product_attribute (product_id, attribute_name) VALUES ('$product_id', '$attribute_name[$i]')");
    
                                $attribute_id = mysqli_insert_id($conn);
                                
                                $attribute_values = explode('|', $_POST['attribute_values'][$i]);
    
                                foreach($attribute_values as $attr_val) {
                                    $insert_variation = mysqli_query($conn, "INSERT INTO product_variation (product_id, attribute_id, variation_value) VALUES ('$product_id', '$attribute_id', '$attr_val')");
                                }
                            }
                                $attribute_id = mysqli_insert_id($conn);
    
                                echo 'insert-product?id=' . $product_id;
                        }
                    }
                }
            }
        }
    } else {
        if($_FILES['product_image']['error'] === 4) {
            $update_product = mysqli_query($conn, "UPDATE product SET category_id = '$product_category', subcategory_id = NULLIF('$product_subcategory', ''), product_title = '$product_name', product_slug = '$product_slug', product_keyword = '$product_keyword', product_desc = NULLIF('$product_desc', ''), product_type = '$product_type' WHERE product_id = $product_id_saved");

            if($update_product) {

                if($attribute_name == '') {
                    
                } else {
                    $delete_attributes = mysqli_query($conn, "DELETE FROM product_attribute WHERE product_id = $product_id_saved");

                    if(count($attribute_name) > 0) {
                        for($i = 0; $i < count($attribute_name); $i++) {
                            
                            $insert_attribute = mysqli_query($conn, "INSERT INTO product_attribute (product_id, attribute_name) VALUES ('$product_id_saved', '$attribute_name[$i]')");

                            $attribute_id = mysqli_insert_id($conn);
                            
                            $attribute_values = explode('|', $_POST['attribute_values'][$i]);

                            foreach($attribute_values as $attr_val) {
                                $insert_variation = mysqli_query($conn, "INSERT INTO product_variation (product_id, attribute_id, variation_value) VALUES ('$product_id_saved', '$attribute_id', '$attr_val')");

                                $insert_variation_id = mysqli_insert_id($conn);
                            }
                        }
                        if(count($variation_id) > 0) {
                            $variation_value = mysqli_query($conn, "SELECT * FROM product_variation WHERE product_id = $product_id_saved");

                            $j = 0;

                            while($row = mysqli_fetch_assoc($variation_value)) {
                                
                                $variation_id_db = $row['variation_id'];

                                $update_variation = mysqli_query($conn, "UPDATE product_variation SET product_price = NULLIF('$variable_reg_price[$j]', ''), product_sale = NULLIF('$variable_sale_price[$j]', ''), stock = NULLIF('$variable_stock[$j]', ''), stock_status = '$variable_stock_status[$j]' WHERE variation_id = $variation_id_db");

                                $j++;
                            }
                            echo 'insert-product?id=' . $product_id_saved;
                        } else {
                            echo 'insert-product?id=' . $product_id_saved;
                        }
                    } else {
                        $delete_attributes = mysqli_query($conn, "DELETE FROM product_attribute WHERE product_id = $product_id_saved");

                        echo 'insert-product?id=' . $product_id_saved;
                    }
                }
            }
        } else {
            $img_ext = explode('.', $product_image);
            $img_ext = strtolower(end($img_ext));

            $new_img_name = uniqid() . '.' . $img_ext;

            move_uploaded_file($product_image_tmp, '../../../assets/images/' . $new_img_name);

            $update_product = mysqli_query($conn, "UPDATE product SET category_id = '$product_category', subcategory_id = NULLIF('$product_subcategory', ''), product_title = '$product_name', product_slug = '$product_slug', product_keyword = '$product_keyword', product_desc = NULLIF('$product_desc', ''), product_type = '$product_type', product_img1 = '$new_img_name' WHERE product_id = $product_id_saved");

            if($update_product) {
                if($attribute_name == '') {
                } else {
                    $delete_attributes = mysqli_query($conn, "DELETE FROM product_attribute WHERE product_id = $product_id_saved");

                    if(count($attribute_name) > 0) {
                        for($i = 0; $i < count($attribute_name); $i++) {
                            
                            if($attribute_name[$i] != '') {
                                $insert_attribute = mysqli_query($conn, "INSERT INTO product_attribute (product_id, attribute_name) VALUES ('$product_id_saved', '$attribute_name[$i]')");

                                $attribute_id = mysqli_insert_id($conn);
                            
                                $attribute_values = explode('|', $_POST['attribute_values'][$i]);

                                foreach($attribute_values as $attr_val) {
                                    $insert_variation = mysqli_query($conn, "INSERT INTO product_variation (product_id, attribute_id, variation_value) VALUES ('$product_id_saved', '$attribute_id', '$attr_val')");
                                }
                            }
                        }
                        if(count($variation_id) > 0) {
                            $variation_value = mysqli_query($conn, "SELECT * FROM product_variation WHERE product_id = $product_id_saved");

                            $j = 0;

                            while($row = mysqli_fetch_assoc($variation_value)) {
                                
                                $variation_id_db = $row['variation_id'];

                                $update_variation = mysqli_query($conn, "UPDATE product_variation SET product_price = NULLIF('$variable_reg_price[$j]', ''), product_sale = NULLIF('$variable_sale_price[$j]', ''), stock = NULLIF('$variable_stock[$j]', ''), stock_status = '$variable_stock_status[$j]' WHERE variation_id = $variation_id_db");

                                $j++;
                            }
                            echo 'insert-product?id=' . $product_id_saved;
                        } else {
                            echo 'insert-product?id=' . $product_id_saved;
                        }
                    } else {
                        echo 'insert-product?id=' . $product_id_saved;
                    }
                }
            }
        }
    }
}

