<?php include('partials/menu.php');  ?>

<!--Main Section starts here-->
    <div class="main-content">
                <div class="wrapper">
                <h1>Update Admin</h1>
                <br> <br>

                <?php 
                
                        //1. get the ID of selected admin
                        $id = $_GET['id'];

                        //2. create SQL Query to get the details
                        $sql = "SELECT * FROM tbl_admin WHERE id=$id";

                        //Execute the query
                        $res = mysqli_query($conn, $sql);

                        //check whether the query executed successfully or not
                            if($res==true)
                            {
                                //ceck wheher the data is availaible or not
                                $count = mysqli_num_rows($res);
                                //check whether we have admin data or not
                                if($count==1)
                                {
                                    //get the details
                                    //echo "Admin Availaible";
                                    $row=mysqli_fetch_assoc($res);

                                    $full_name = $row['full_name'];
                                    $username = $row['username'];
                                }

                                else
                                {
                                    //redirect to manage admin page
                                    header('location:'.SITEURL.'admin/manage-admin.php');
                                }

                            }
                
                
                ?>

                <form action="" method="POST"> <!--post values are hidden-->
                        <table class="tbl-30"> 
                            <tr>
                                <td>Full Name:</td>
                                <td>
                                    <input type="text" name="full_name"  value="<?php echo $full_name; ?>">  
                                    </td>
                            </tr>

                            <tr>
                                <td>Username:</td>
                                <td>
                                    <input type="text" name="username"  value="<?php echo $username; ?>">  
                                    </td>
                            </tr>
                               

                            <tr>
                                
                                <td colspan="2"> <!--Merge two columns-->
                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                                    <input type="submit" name="submit" value="Update Admin" class="btn-secondary">  
                                    </td>
                            </tr>
                        </table>
       </form>

                </div>
    </div>


    <!--check whether button is clicked or not we will update admin once btn is clicked -->
    <?php 
    
    if(isset($_POST['submit']))
                    {
                        //if value is passed or button clicked
                    //echo"button clicked";

                    //process the data from our form

                    //1-step Get the data from form to update
                    $id =  mysqli_real_escape_string($conn, $_POST['id']);
                    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
                    $username = mysqli_real_escape_string($conn, $_POST['username']);
                    

                    //2-step SQL query to update admin
                    $sql = "UPDATE tbl_admin SET
                    full_name = '$full_name',
                    username = '$username' 
                    WHERE id='$id'
                    ";

                    //executing query and saving data into database

                    $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

                    //4- check whether the (query is executed) data is updated or not and display appropriate message

                    if($res==TRUE)
                    {
                        //Data updated
                        //echo "Data Updated";
                        //create a seesion variale to display message (for that we created session in constant)
                        $_SESSION['update'] = "<div class='success'> Admin Updated Successfully </div>";
                        //then Redirect page to Manage Admin Page (for that we created constant siteurl)
                        header("location:".SITEURL.'admin/manage-admin.php'); //we concatenate siteurl here
                    }
                    else 
                    {
                        //Failed to update data
                        //echo "Failed to update data";
                        //create a seesion variale to display message (for that we created session in constant)
                        $_SESSION['update'] = "<div class='error'>Failed to Delete Admin.</div>";
                        //then Redirect page to Add Admin Page (for that we created constant siteurl)
                        header("location:".SITEURL.'admin/add-admin.php'); //we concatenate siteurl here
                    }
                    }
    
    
    
    ?>


    <?php include('partials/footer.php');  ?>
