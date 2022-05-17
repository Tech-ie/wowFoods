<?php 

//include constants file
include('../config/constants.php');

//check whether the id and image_name value is set or not
if(isset($_GET['id']) && isset($_GET['image_name'])) //either use '&&' or AND
{
            //Process to delete
            //echo "get value and delete";

            //get id and image name
            $id =$_GET['id'];
            $image_name = $_GET['image_name'];

            //Remove te physical image file is availaible 
                if($image_name != "")
                {
                    //Image is avaialible so remove it
                    $path ="../images/food/".$image_name;

                    //remove image file from folder
                    $remove = unlink($path);
                    
                        //if failed to remove image then add an error message and stop the process
                        if($remove==false)
                        {
                            //set the session message
                            $_SESSION['remove'] = "<div class='error' >Failed to Remove Food Image.</div>";
                            //redirect to manage category page
                            header('location:'.SITEURL.'admin/manage-food.php');
                            //stop the process
                            die();
                        }
                }
            //delete data from database
            //sql query to delete data from database
            $sql = "DELETE FROM tbl_food WHERE id=$id";
            
            //execute the query
            $res = mysqli_query($conn, $sql);

            //check whether the data is delete from database or not
                if($res==true)
                {
                    //set success message and redirect
                    $_SESSION['delete'] = "<div class='success' >Food Deleted Successfully</div>";
                    //redirect to manage category
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
                else 
                {
                    //set fail message and redirects
                    $_SESSION['delete'] = "<div class='error' >Failed To Delete Food.</div>";
                    //redirect to manage category
                    header('location:'.SITEURL.'admin/manage-food.php');
                }



}
else 
{
    //redirect to manage food page
    $_SESSION['unauthorize'] = "<div class='error' >Unauthorized Access.</div>";
    header('location:'.SITEURL.'admin/manage-food.php');
}

?>