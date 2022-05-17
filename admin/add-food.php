<?php include('partials/menu.php');  ?>

<div class="main-content">
    <div class="wrapper">
    <h1>Add Food</h1>

            <br> <br>

            <?php 
                
                if(isset($_SESSION['upload'])) //checking whether the session is set or not
                {
                    echo $_SESSION['upload']; //displaying session message
                    unset($_SESSION['upload']); //removing session message
                }

           ?>

            <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                                <tr>
                                    <td>Title:</td>
                                    <td>
                                        <input type="text" name="title" placeholder="Title of the Food">
                                    </td>
                                </tr>

                                <tr>
                                    <td>Description:</td>
                                    <td>
                                        <textarea name="description" cols="30" rows="5" placeholder="Description of the Food"></textarea>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Price:</td>
                                    <td>
                                        <input type="number" name="price"> <!--number for only num digits-->
                                    </td>
                                </tr>


                                <tr>
                                    <td>Select Image:</td>
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
                                                $id =$row['id'];
                                                $title = $row['title'];
                                                ?>
                                                <option value="<?php echo $id; ?>"><?php echo $title; ?></option>

                                                <?php
                                            }
                                        }
                                        else 
                                        {
                                            //we donot have category
                                            ?>
                                            <option value="0">No Category Found</option>
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
                                        <input  type="radio" name="featured" value="Yes"> Yes

                                        <input  type="radio" name="featured" value="No"> No

                                    </td>
                                </tr>

                                <tr>
                                    <td>Active:</td>
                                    <td>
                                    <input  type="radio" name="active" value="Yes"> Yes

                                    <input  type="radio" name="active" value="No"> No

                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2">
                                        
                                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">

                                    </td>
                                </tr>

                            </table>
            </form>

           <?php 
           
           //check whether the button is clicked or not
           if(isset($_POST['submit']))
           {
               //1. get the data from form
                $title = mysqli_real_escape_string($conn, $_POST['title']);
                $description = mysqli_real_escape_string($conn, $_POST['description']);
                $price = mysqli_real_escape_string($conn, $_POST['price']);
                $category = $_POST['category'];

                //check whether radion button for featured and active are checked or not
                if(isset($_POST['featured']))
                {
                    $featured = $_POST['featured'];
                }
                else 
                {
                    $featured = "No"; //setting default value
                }

                if(isset($_POST['active']))
                {
                    $active = $_POST['active'];
                }
                else 
                {
                    $active = "No"; //setting default value
                }

                //2. upload the image if selected 
                //check whether the select image is clicked or not and upload the image only if the image is selected
                if(isset($_FILES['image']['name']))
                {
                    //get the details of the selected image
                    $image_name = $_FILES['image']['name'];

                    //check whether the image is selected or not and upload the image only if the image is selected
                    if($image_name != "")
                    {
                        //image is selected
                        //A. rename the image
                        //get the extension of selectd image (jpg, png, gif, etc)
                        $ext = end(explode('.', $image_name));

                        $image_name = "Food-Name-".rand(0000, 9999).".".$ext;  //e.g. Food_Category_834.jpg 

                        $src = $_FILES['image']['tmp_name'];

                        $dst = "../images/food/".$image_name;
                        
                        //Finally upload the image
                        $upload = move_uploaded_file($src, $dst);

                        //Check whether image is uploaded or not
                        //and if the image is not uploaded then we will stop the process and redirect with error message
                        if($upload==false)
                        {
                            //set message //Redirect to Add Food page with error message
                            $_SESSION['upload'] = "<div class='error'>Failed to upload image. </div>";
                            header('location:'.SITEURL.'admin/add-food.php');
                            //stop the process
                            die();
                        }
                    }
                }
                else 
                {
                    $image_name = ""; //setting default value as blank
                }



                //3. insert into database

                // create a sql query to save or add food
                // for numerical we do not need to pass value inside quotes '' but for string it is compulsory to add quotes''
                    $sql2 = "INSERT INTO tbl_food SET
                    title = '$title',
                    description = '$description',
                    price = $price,
                    image_name ='$image_name',
                    category_id =$category,
                    featured = '$featured',
                    active = '$active'
                        ";

                    //3. execute the query
                    $res2 = mysqli_query($conn, $sql2);

                    //4. check whether the query executed or not and data added or not
                    if($res2==true)
                    {
                        //query executed and food added
                        $_SESSION['add'] = "<div class='success'>Food Added Successfully.</div>";
                        //redirect to manage food page
                        header('location:'.SITEURL.'admin/manage-food.php');
                    }
                    else 
                    {
                        //failed to add food
                        $_SESSION['add'] = "<div class='error'>Failed to Add Food.</div>";
                        //redirect to manage food page
                        header('location:'.SITEURL.'admin/manage-food.php');
                        
                    }
                //4. redirect with message to manage food page

           }
           
           
           
           ?>

    </div>
</div>           






<?php include('partials/footer.php');  ?>
