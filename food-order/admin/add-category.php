<?php include('partials/menu.php');  ?>


<!--Main Section starts here-->
<div class="main-content">
    <div class="wrapper">
    <h1>Add Category</h1>

            <br> <br>

            <?php 
                if(isset($_SESSION['add'])) //checking whether the session is set or not
                {
                    echo $_SESSION['add']; //displaying session message
                    unset($_SESSION['add']); //removing session message
                }

                if(isset($_SESSION['upload'])) //checking whether the session is set or not
                {
                    echo $_SESSION['upload']; //displaying session message
                    unset($_SESSION['upload']); //removing session message
                }

           ?>

          <br><br>

        <!-- Add category Form Starts -->
            <form action="" method="POST" enctype="multipart/form-data"> <!--This enctype allow us to upload file -->
                            <table class="tbl-30">
                                <tr>
                                    <td>Title:</td>
                                    <td>
                                        <input type="text" name="title" placeholder="Category Title">
                                    </td>
                                </tr>

                                <tr>
                                    <td>Select Image:</td>
                                    <td>
                                        <input type="file" name="image">
                                    </td>
                                </tr>

                                <tr>
                                    <td>Featured:</td>
                                    <td>
                                        <input type="radio" name="featured" value="Yes"> Yes
                                        <input type="radio" name="featured" value="No"> No

                                    </td>
                                </tr>

                                <tr>
                                    <td>Active:</td>
                                    <td>
                                    <input type="radio" name="active" value="Yes"> Yes
                                    <input type="radio" name="active" value="No"> No

                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2">
                                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">

                                    </td>
                                </tr>

                            </table>




            </form>

        <!-- Add category Form Ends -->

        <?php 
        
        //check whether the submit button is clicked or not

            if(isset($_POST['submit']))
            {
                //if value is passed or button clicked
            //echo"button clicked";

            //process the data from our form

            //1-step Get the data from form
            $title = mysqli_real_escape_string($conn, $_POST['title']);

            //For radio input, we need to check whether te button is selected or not
                if(isset($_POST['featured']))
                {
                    //Get the value from form
                    $featured = $_POST['featured'];
                }
                else 
                {
                    //set the default value
                    $featured = "No";
                }

                if(isset($_POST['active']))
                {
                    //Get the value from form
                    $active = $_POST['active'];
                }
                else 
                {
                    //set the default value
                    $active = "No";
                }

            //check weather image is selected or not and set te value for image name accordingly
            //print_r($_FILES['image']); //echo doesnot display array values

            //die(); //Break the code here

            if(isset($_FILES['image']['name']))
            {
                //Only then upload the image
                //To upload image we need image name, source path and destination path
                $image_name = $_FILES['image']['name'];

                //Upload the image only if image is selected
                if($image_name != "") 
                {

                

                        //Auto rename our image
                        //get the extension of our image (jpg, png, gif, etc) e.g. "food1.jpg"
                        $ext = end(explode('.', $image_name));

                        //Rename the image
                        $image_name = "Food_Category_".rand(000, 999).'.'.$ext;  //e.g. Food_Category_834.jpg 

                        $source_path = $_FILES['image']['tmp_name'];

                        $destination_path = "../images/categories/".$image_name;

                        //Finally upload the image
                        $upload = move_uploaded_file($source_path, $destination_path);

                        //Check whether image is uploaded or not
                        //and if the image is not uploaded then we will stop the process and redirect with error message
                        if($upload==false)
                        {
                            //set message
                            $_SESSION['upload'] = "<div class='error'>Failed to upload image. </div>";
                            //Redirect to Add Category page
                            header('location:'.SITEURL.'admin/add-category.php');
                            //stop the process
                            die();
                        }

                }  


            }
            else 
            {
                //Don't upload the image and set the image_name value as blank
                $image_name = "";
            }

            //2. Create SQL query to Insert  Category into database

            $sql = "INSERT INTO tbl_category SET
                  title = '$title',
                  image_name ='$image_name',
                  featured = '$featured',
                  active = '$active'
            ";

            //3. execute the query
            $res = mysqli_query($conn, $sql);

            //4. check whether the query executed or not and data added or not
            if($res==true)
            {
                //query executed and category added
                $_SESSION['add'] = "<div class='success'>Category Added Successfully.</div>";
                //redirect to manage category page
                header('location:'.SITEURL.'admin/manage-category.php');
            }
            else 
            {
                //failed to add category
                $_SESSION['add'] = "<div class='error'>Failed to Add Category.</div>";
                //redirect to manage category page
                header('location:'.SITEURL.'admin/add-category.php');
                
            }



            }
        
        ?>

   </div>
</div>

<!--Main Section ends here-->



<?php include('partials/footer.php');  ?>

