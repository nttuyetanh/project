<?php
    ob_start();
    session_start();
    // if(!$_SESSION["login"]) {
    //   header("location:login.php");
    // }
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    include ("../../connection.php");
    include ("../../common.php");
?>

<?php 
    
    if(isset($_POST['editPro'])){
        
        //tim san pham cu
        $pro_id = $_POST['pro_id'];
        $query_select_pro_edit = "SELECT * FROM tbl_product WHERE pro_id = '$pro_id'";
        $result_select_pro_edit = $conn->query($query_select_pro_edit);
        $row_select_pro_edit = $result_select_pro_edit->fetch();
        

        $pro_name = $_POST["pro_name"];
        $cat_id = $_POST["cat_id"] ;
        $brand_id = $_POST["brand_id"] ;
        $image = $row_select_pro_edit['image'];
        $price = $_POST["price"] ;
        $description = $_POST["description"] ;
        $status = isset($_POST["status"])?1:0;
        $date_create = date("Y-m-d H:i:s");


        //neu upload anh moi
        if($_FILES['image']['name']!=""){
            //xoa anh cu
            if($image!=""){
                $path_image_old = "../../uploads/".$image;
                if(file_exists($path_image_old)){
                    unlink($path_image_old);
                }
            }

            //upload image moi
            $allowTypes = array('jpg','png','jpeg','gif','image/jpeg'); //type image
            $path = "../../uploads/";
            if($_FILES['image']['name']){
                if(in_array($_FILES['image']['type'],$allowTypes)){
                    $file_name = $_FILES['image']['name'];
                    $array = explode('.',$file_name);

                    $new_name = $array[0].rand(0,999).'.'.$array[1];
                    $image = $new_name;
                    move_uploaded_file($_FILES['image']['tmp_name'],$path.$new_name);
                }
            }
        }

        //lenh update prouct
        $query_update_product_edit = "UPDATE tbl_product SET pro_name='$pro_name',cat_id='$cat_id',brand_id='$brand_id',image='$image',description='$description',status='$status' WHERE pro_id = '$pro_id'";
        $conn->query($query_update_product_edit);


        if($_FILES['images']['name'][0]!=""){
            
            //Xoa anh cu trong tbl_images
            // xoa trong thu muc upload
            $query_select_image_by_pro_id = "SELECT * FROM tbl_images WHERE pro_id = '$pro_id'";
            $result = $conn->query($query_select_image_by_pro_id);
            $categories = array();
            while($row = $result->fetch()){
                if($row['image']!=""){
                    $path_image_old = "../../uploads/".$row['image'];
                    if(file_exists($path_image_old)){
                        unlink($path_image_old);
                    }
                }
            }
            //xoa anh cu trong table tbl_images voi pro_id
            $query_delete_image_by_pro_id =  "DELETE FROM tbl_images WHERE pro_id = '$pro_id'";
            $conn->query($query_delete_image_by_pro_id);
           

            $allowTypes = array('jpg','png','jpeg','gif','image/jpeg');
            $path = "../../uploads/";
            foreach($_FILES['images']['name'] as $key => $file){
                if(in_array($_FILES['images']['type'][$key],$allowTypes)){
                    if($_FILES['images']['error'][$key]==0){
                        $file_name = $_FILES['images']['name'][$key];
                        $array = explode('.',$file_name);
                        $new_name = $array[0].rand(0,999).'.'.$array[1];

                        $image              = $new_name;
                        move_uploaded_file($_FILES['images']['tmp_name'][$key],$path.$new_name);
                        //insert hinh anh moi
                        $query_insert_new_image = "INSERT INTO tbl_images VALUES(null,'$pro_id','$image')";
                       
                        $conn->query($query_insert_new_image);
                    }
                }
            }
        }
        
    }
    header('location: ../index.php?page=product');
?>