<?php
session_start();
require_once '../../../includes/database_conn.php';

if(isset($_POST['insert_category'])) {
    if(empty($_POST['insert_category_title']) && $_FILES['insert_category_thumbnail']['error'] === 4) {
        echo 'empty fields';
    } else if(empty($_POST['insert_category_title'])) {
        echo 'empty category title';
    } else if($_FILES['insert_category_thumbnail']['error'] === 4) {
        echo 'empty thumbnail';
    } else {
        $categoryTitle = mysqli_real_escape_string($conn, $_POST['insert_category_title']);
        $categoryThumbnailName = $_FILES['insert_category_thumbnail']['name'];
        $categoryThumbnailSize = $_FILES['insert_category_thumbnail']['size'];
        $categoryThumbnailTmpName = $_FILES['insert_category_thumbnail']['tmp_name'];
    
        $validImgExt = ['jpg', 'jpeg', 'png'];
        $imgExt = explode('.', $categoryThumbnailName);
        $imgExt = strtolower(end($imgExt));
    
        if(!in_array($imgExt, $validImgExt)) {
            echo 'file not supported';
        } else if($categoryThumbnailSize > 10485760) {
            echo 'file too large';
        } else {
            $categoryTitle = mysqli_real_escape_string($conn, $_POST['insert_category_title']);
    
            $check = mysqli_query($conn, "SELECT * FROM category WHERE category_title = '$categoryTitle'");
    
            if(mysqli_num_rows($check) > 0) {
                echo 'title already exist';
            } else {
                $newThumbnailName = uniqid() . '.' . $imgExt;
    
                move_uploaded_file($categoryThumbnailTmpName, '../../../assets/images/' . $newThumbnailName);
    
                $insertCategory = mysqli_query($conn, "INSERT INTO category VALUES ('', '$categoryTitle', '$newThumbnailName')");
    
                if($insertCategory) {
                    echo 'successful';
                }
            }
        }
    }
}

if (isset($_REQUEST['category_id_edit'])) {
    $category_id = $_REQUEST['category_id_edit'];
    $get_category = mysqli_query($conn, "SELECT * FROM category WHERE category_id = '$category_id'");

    $result_array = array();
    while ($result = mysqli_fetch_assoc($get_category)) {
        $result_array['category_id'] = $result['category_id'];
        $result_array['category_title'] = $result['category_title'];
        $result_array['category_thumbnail'] = $result['categoty_thumbnail'];
    }
    
    echo json_encode($result_array);
}

if(isset($_POST['update_category'])) {
    if (empty($_POST['update_category_title'])) {
        echo 'category is empty';
    }
    
    if (!empty($_POST['update_category_title']) && $_FILES['update_category_thumbnail']['error'] === 4) {
        $categoryId = $_POST['update_category_id'];
        $categoryTitle = mysqli_real_escape_string($conn, $_POST['update_category_title']);
    
        $checkTitle = mysqli_query($conn, "SELECT * FROM category WHERE category_title = '$categoryTitle'");
    
        if (mysqli_num_rows($checkTitle) == 1) {
            $checkTitle2 = mysqli_query($conn, "SELECT * FROM category WHERE category_title = '$categoryTitle' AND category_id = $categoryId");
    
            if (mysqli_num_rows($checkTitle2) == 0) {
                echo 'category title already exist';
            } else {
                $categoryId = mysqli_real_escape_string($conn, $_POST['update_category_id']);
                $categoryTitle = mysqli_real_escape_string($conn, $_POST['update_category_title']);
    
                $updateCategory = mysqli_query($conn, "UPDATE category SET category_title = '$categoryTitle' WHERE category_id = $categoryId");
    
                if ($updateCategory) {
                    echo 'title updated';
                }
            }
        } else {
            $categoryId = mysqli_real_escape_string($conn, $_POST['update_category_id']);
            $categoryTitle = ucwords(mysqli_real_escape_string($conn, $_POST['update_category_title']));
    
            $updateCategory = mysqli_query($conn, "UPDATE category SET category_title = '$categoryTitle' WHERE category_id = $categoryId");
    
            if ($updateCategory) {
                echo 'title updated';
            }
        }
    }
    
    if (!empty($_POST['update_category_title']) && $_FILES['update_category_thumbnail']['error'] === 0) {
        $categoryThumbnailName = $_FILES['update_category_thumbnail']['name'];
        $categoryThumbnailSize = $_FILES['update_category_thumbnail']['size'];
        $categoryThumbnailTmpName = $_FILES['update_category_thumbnail']['tmp_name'];
    
        $validImgExt = ['jpg', 'jpeg', 'png'];
        $thumbnailExt = explode('.', $categoryThumbnailName);
        $thumbnailExt = strtolower(end($thumbnailExt));
    
        if (!in_array($thumbnailExt, $validImgExt)) {
            echo 'invalid file';
        } else if ($categoryThumbnailSize > 10485760 || $categoryThumbnailSize > 41943040) {
            echo 'too large';
        } else {
            $categoryId = mysqli_real_escape_string($conn, $_POST['update_category_id']);
            $categoryTitle = mysqli_real_escape_string($conn, $_POST['update_category_title']);
            $checkTitle = mysqli_query($conn, "SELECT * FROM category WHERE category_title = '$categoryTitle'");
    
            if (mysqli_num_rows($checkTitle) > 0) {
                $checkTitle2 = mysqli_query($conn, "SELECT * FROM category WHERE category_title = '$categoryTitle' AND category_id = $categoryId");
    
                if (mysqli_num_rows($checkTitle2) == 0) {
                    echo 'category title already exist';
                } else {
                    $categoryId = mysqli_real_escape_string($conn, $_POST['update_category_id']);
                    $categoryTitle = mysqli_real_escape_string($conn, $_POST['update_category_title']);

                    $getOldCategoryThumbnail = mysqli_query($conn, "SELECT * FROM category WHERE category_id = $categoryId");
                    $row = mysqli_fetch_array($getOldCategoryThumbnail);

                    $oldCategoryThumbnail = $row['categoty_thumbnail'];
    
                    $newCategoryThumbnailName = uniqid() . '.' .$thumbnailExt;
    
                    move_uploaded_file($categoryThumbnailTmpName, '../../../assets/images/' . $newCategoryThumbnailName);
                    unlink('../../../assets/images/' . $oldCategoryThumbnail);
    
                    $updateCategory = mysqli_query($conn, "UPDATE category SET category_title = '$categoryTitle', categoty_thumbnail = '$newCategoryThumbnailName' WHERE category_id = $categoryId");
    
                    if ($updateCategory) {
                        echo 'updated successfully';
                    }
                }
            } else {
                $categoryId = mysqli_real_escape_string($conn, $_POST['update_category_id']);
                $categoryTitle = mysqli_real_escape_string($conn, $_POST['update_category_title']);
                $getOldCategoryThumbnail = mysqli_query($conn, "SELECT * FROM category WHERE category_id = $categoryId");
                $row = mysqli_fetch_array($getOldCategoryThumbnail);

                $oldCategoryThumbnail = $row['categoty_thumbnail'];
    
                $newCategoryThumbnailName = uniqid() . '.' . $thumbnailExt;
    
                move_uploaded_file($categoryThumbnailTmpName, '../../../assets/images/' . $newCategoryThumbnailName);
                unlink('../../../assets/images/' . $oldCategoryThumbnail);
    
                $updateCategory = mysqli_query($conn, "UPDATE category SET category_title = '$categoryTitle', categoty_thumbnail = '$newCategoryThumbnailName' WHERE category_id = $categoryId");
    
                if ($updateCategory) {
                    echo 'updated successfully';
                }
            }
        }
    }    
}

if(isset($_POST['delete_category'])) {
    if(!empty($_POST['delete_category_id'])) {
        $deleteCategoryId = $_POST['delete_category_id'];
    
        $getCategory = mysqli_query($conn, "SELECT * FROM category WHERE category_id = $deleteCategoryId");
    
        $categoryImg = '';
    
        while($row = mysqli_fetch_array($getCategory)) {
            $categoryImg = $row['categoty_thumbnail'];
        }
    
        $deleteCategory = mysqli_query($conn, "DELETE FROM category WHERE category_id = $deleteCategoryId");
    
        if($deleteCategory) {
            echo 'deleted';
            unlink('../../../assets/images/' . $categoryImg);
        }
    }
}