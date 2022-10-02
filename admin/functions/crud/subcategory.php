<?php
session_start();
require_once '../../../includes/database_conn.php';

if (isset($_REQUEST['category_id_view'])) {
    $category_id = $_REQUEST['category_id_view'];
    $get_category = mysqli_query($conn, "SELECT category_title, categoty_thumbnail FROM category WHERE category_id = '$category_id'");

    $result_array = array();
    while ($result = mysqli_fetch_assoc($get_category)) {
        $result_array['category_title'] = $result['category_title'];
        $result_array['category_thumbnail'] = $result['categoty_thumbnail'];
    }

    echo json_encode($result_array);
}

if(isset($_REQUEST['subcategory_id_edit'])) {
    $subcategory_id = $_REQUEST['subcategory_id_edit'];
    $get_subcategory = mysqli_query($conn, "SELECT category.category_id, subcategory.subcategory_id, subcategory.subcategory_title
    FROM subcategory
    INNER JOIN category
    ON subcategory.category_id=category.category_id
    WHERE subcategory.subcategory_id = $subcategory_id");

    $result_array = array();
    while ($result = mysqli_fetch_assoc($get_subcategory)) {
        $result_array['category_id'] = $result['category_id'];
        $result_array['subcategory_id'] = $result['subcategory_id'];
        $result_array['subcategory_title'] = $result['subcategory_title'];
    }

    echo json_encode($result_array);
}

if(isset($_POST['update_subcategory'])) {
    if ($_POST['update_category-list'] == "" && empty($_POST['update-subcategory'])) {
        echo 'empty field';
    } else if ($_POST['update_category-list'] == "") {
        echo 'empty category';
    } else if (empty($_POST['update-subcategory'])) {
        echo 'empty subcategory';
    } else {
        $category = $_POST['update_category-list'];
        $subcategoryId = $_POST['update_subcategory_id'];
        $subcategoryTitle = ucwords($_POST['update-subcategory']);
    
        $check = mysqli_query($conn, "SELECT * FROM subcategory WHERE subcategory_title = '$subcategoryTitle'");
    
        if (mysqli_num_rows($check) == 1) {
            $check2 = mysqli_query($conn, "SELECT * FROM subcategory WHERE category_id = $category AND subcategory_title = '$subcategoryTitle'");
    
            if (mysqli_num_rows($check2) > 0) {
                echo 'subcategory title already exist';
            } else {
                $update = mysqli_query($conn, "UPDATE subcategory SET category_id = $category, subcategory_id = $subcategoryId, subcategory_title = '$subcategoryTitle' WHERE subcategory_id = $subcategoryId");
    
                if ($update) {
                    echo 'success';
                }
            }
        } else {
            $update = mysqli_query($conn, "UPDATE subcategory SET category_id = $category, subcategory_title = '$subcategoryTitle' WHERE subcategory_id = $subcategoryId");
    
            if ($update) {
                echo 'success';
            }
        }
    }
}

if(isset($_POST['insert_subcategory'])) {
    if($_POST['category-list'] == "CATEGORY" && empty($_POST['insert-subcategory'])) {
        echo 'empty field';
    } else if ($_POST['category-list'] == "CATEGORY") {
        echo 'empty category';
    } else if (empty($_POST['insert-subcategory'])) {
        echo 'empty subcategory';
    } else {
        $category =  $_POST['category-list'];
        $subcategoryTitle = ucwords($_POST['insert-subcategory']);
    
        $check = mysqli_query($conn, "SELECT * FROM subcategory WHERE subcategory_title = '$subcategoryTitle' AND category_id = $category");
    
        if(mysqli_num_rows($check) > 0) {
            echo 'title already exist';
        } else {
            $insertSubcategory = mysqli_query($conn, "INSERT INTO subcategory VALUES ($category, '', '$subcategoryTitle')");
    
            if($insertSubcategory) {
                echo 'success';
            } else {
                echo 'failed';
            }
        }
    }
}

if(isset($_POST['delete_subcategory'])) {
    if(!empty($_POST['delete_subcategory_id'])) {
        $deleteSubcategoryId = $_POST['delete_subcategory_id'];
    
        $deleteCategory = mysqli_query($conn, "DELETE FROM subcategory WHERE subcategory_id = $deleteSubcategoryId");
    
        if($deleteCategory) {
            echo 'deleted';
        }
    }
}