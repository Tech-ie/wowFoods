<?php include('partials/menu.php');  ?>

    <?php 
            
               //check whether the id is set or not
               if(isset($_GET['id']))
                {
                        //get the id and all other details
                        // echo "getting the data"; 
                        $id = $_GET['id'];
                        //create sql query to get all other details
                        $sql2 = "SELECT * FROM tbl_food WHERE id=$id";

                        //execute the query
                        $res2 = mysqli_query($conn, $sql2);

                        //count the rows to check whether the id is valid or not
                        $row2 = mysqli_fetch_assoc($res2);
                
                        //get all the data
                                            
                        $title = $row2['title'];
                        $description = $row2['description'];
                        $price = $row2['price'];
                        $current_image = $row2['image_name'];
                        $current_category = $row2['category_id'];
                        $featured = $row2['featured'];
                        $active = $row2['active'];
                            
                            
                }
               else 
                {
                            //redirect to manage category
                            header('location:'.SITEURL.'admin/manage-food.php');
                }          
    ?>




<div class="main-content">
    <div class="wrapper">
    <h1>Update Food</h1>

            <br> <br>
            <form action="" method="POST" enctype="multipart/form-data">
                    <table class="tbl-30">
                                <tr>
                                    <td>Title:</td>
                                    <td>
                                        <input type="text" name="title" value="<?php echo $title; ?>">
                                    </td>
                                </tr>

                                <tr>
                                    <td>Description:</td>
                                    <td>
                                        <textarea name="description" cols="30" rows="5"> <?php echo $description; ?></textarea>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Price:</td>
                                    <td>
                                        <input type="number" name="price" value="<?php echo $price; ?>"> <!--number for only num digits-->
                                    </td>
                                </tr>


                                <tr>
                                    <td>Current Image:</td>
                                    <td>
                                        <?php 
                                        
                                                if($current_image != "")
                                                {
                                                    //Display the message
                                                    ?>
                                                    <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" width="100px">
                                                    <?php
                                                }
                                                else 
                                                {
                                                    //Display the message
                                                    echo "<div class='error'>Image Not Added.</div>";
                                                }
                                        
                                        
                                        ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Select New Image:</td>
                                    <td>
                                        <input type="file" name="image">
                                    </td>
                                </tr>

                                <tr>
                                    <td>Category:</td>
                                    <td>
                                        <select name="category">

                                        <?php 
                                        //create PHP code to display categories from database
                                        //1. create SQL to get all active categories from database
                                        $sql = "SELECT * FROM tbl_category WHERE active='Yes'";

                                        //Executing query
                                        $res = mysqli_query($conn, $sql);

                                        //count rows to check whether we have categories or not
                                        $count = mysqli_num_rows($res);

                                        //if count is greater than zero, we have categories else we donot have categories
                                        if($count>0)
                                        {
                                            //we have categories
                                            while($row=mysqli_fetch_assoc($res))
                                            {
                                                //get the details of categories
                                                $category_title =$row['title'];
                                                $category_id = $row['id'];
                                                ?>
                                                <option <?php if($current_category==$category_id){echo "selected"; } ?> value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>

                                                <?php
                                            }
                                        }
                                        else 
                                        {
                                            //we donot have category
                                            ?>
                                            <option value="0">Category Not Availaible.</option>
                                            <?php 
                                        }
                                        
                                        //2. Display on dropdown
                                    
                                        
                                        ?>
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Featured:</td>
                                    <td>
                                        <input <?php if($featured=="Yes") {echo "checked";} ?> type="radio" name="featured" value="Yes"> Yes

                                        <input <?php if($featured=="No") {echo "checked";} ?> type="radio" name="featured" value="No"> No

                                    </td>
                                </tr>

                                <tr>
                                    <td>Active:</td>
                                    <td>
                                    <input <?php if($active=="Yes") {echo "checked";} ?> type="radio" name="active" value="Yes"> Yes

                                    <input <?php if($active=="No") {echo "checked";} ?> type="radio" name="active" value="No"> No

                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2">
                                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                                        <input type="submit" name="submit" value="Update Food" class="btn-secondary">

                                    </td>
                                </tr>

                            </table>
            </form>


            <?php 
            
               if(isset($_POST['submit']))
               {
                   //1. get all the values from our form
                   $id = mysqli_real_escape_string($conn,$_POST['id']);
                   $title = mysqli_real_escape_string($conn,$_POST['title']);
                   $description = mysqli_real_escape_string($conn,$_POST['description']);
                   $price = mysqli_real_escape_string($conn,$_POST['price']);
                   $current_image = mysqli_real_escape_string($conn,$_POST['current_image']);
                   $category = mysqli_real_escape_string($conn,$_POST['category']);
                   $featured = mysqli_real_escape_string($conn,$_POST['featured']);
                   $active = mysqli_real_escape_string($conn,$_POST['active']);

                   //2. updating new image if selected
                   //check whether the image is selected or not
                            if(isset($_FILES['image']['name']))
                            {
                                //get the image details
                                $image_name = $_FILES['image']['name'];

                                //check whether the image is availaible or not
                                    if($image_name != "")
                                    {
                                        //Image Availaible
                                        //A.Upload the new image
                                            //Auto rename our image
                                                //get the extension of our image (jpg, png, gif, etc) e.g. "food1.jpg"
                                                $ext = end(explode('.', $image_name));

                                                //Rename the image
                                                $image_name = "Food-Name-".rand(0000, 9999).'.'.$ext;  //e.g. Food_Category_834.jpg 

                                                $src_path = $_FILES['image']['tmp_name'];

                                                $dest_path = "../images/food/".$image_name;

                                                //Finally upload the image
                                                $upload = move_uploaded_file($src_path, $dest_path);

                                                //Check whether image is uploaded or not
                                                //and if the image is not uploaded then we will stop the process and redirect with error message
                                                if($upload==false)
                                                {
                                                    //set message
                                                    $_SESSION['upload'] = "<div class='error'>Failed to upload new image. </div>";
                                                    //Redirect to Add Category page
                                                    header('location:'.SITEURL.'admin/manage-food.php');
                                                    //stop the process
                                                    die();
                                                }


                                        //B.Remove the old(current) image if availaible
                                                 if($current_image != "")
                                                 {
                                                            $remove_path = "../images/food/".$current_image;

                                                            $remove = unlink($remove_path);
                
                                                            //check whether the image is removed or not
                                                            //if failed to remove then display message and stop the process
                                                           if($remove==false)
                                                           {
                                                               //Failed to remove image
                                                               $_SESSION['remove-failed'] = "<div class='error'>Failed to remove current image. </div>";
                                                               header('location:'.SITEURL.'admin/manage-food.php');
                                                               die(); //to stop the process
                                                           }

                                                   }
                            
                                    }
                                    else 
                                    {
                                        $image_name = $current_image; //default image when image is not selected
                                    }
                            }
                            else 
                            {
                                $image_name = $current_image;  //default image when button is not clicked
                            }

                    //3. update the database
                    $sql3 = "UPDATE tbl_food SET
                        title = '$title',
                        description = '$description',
                        price = $price,
                        image_name = '$image_name',
                        category_id = '$category',
                        featured ='$featured',
                        active = '$active'
                        WHERE id=$id
                    ";

                    //execute the sql query
                    $res3 = mysqli_query($conn, $sql3);

                    //4. Redirectto manage category with message
                    //check whether executed or not
                            if($res3==true)
                            {
                                //food updated
                                $_SESSION['update'] = "<div class='success'>Food Updated Successfully.</div>";
                                //redirect to manage food page
                                header('location:'.SITEURL.'admin/manage-food.php');
                            }
                            else 
                            {
                                //failed to update food
                                $_SESSION['update'] = "<div class='error'>Failed To Update Food.</div>";
                                //redirect to manage food page
                                header('location:'.SITEURL.'admin/manage-food.php');
                            }

               }

            ?>
    </div>        
</div>

<?php include('partials/footer.php');  ?>
