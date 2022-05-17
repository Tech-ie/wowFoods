<?php include('partials/menu.php');  ?>

<!--Main Section starts here-->
    <div class="main-content">
                <div class="wrapper">
                        <h1>Change Password</h1>
                        <br> <br>

                        <?php   
                        
                        if(isset($_GET['id']))
                        {
                            $id=$_GET['id'];
                        }
                        
                        
                        
                        
                        ?>


                        <form action="" method="POST"> <!--post values are hidden-->
                                <table class="tbl-30"> 
                                    <tr>
                                        <td>Current Password:</td>
                                        <td>
                                            <input type="password" name="current_password"  placeholder="Current Password">  
                                            </td>
                                    </tr>

                                    <tr>
                                        <td>New Password:</td>
                                        <td>
                                            <input type="password" name="new_password"  placeholder="New Password">  
                                            </td>
                                    </tr>

                                    <tr>
                                        <td>Confirm Password:</td>
                                        <td>
                                            <input type="password" name="confirm_password"  placeholder="Confirm Password">  
                                            </td>
                                    </tr>
                                    

                                    <tr>
                                        
                                        <td colspan="2"> <!--Merge two columns-->
                                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                                            <input type="submit" name="submit" value="Change Password" class="btn-secondary">  
                                            </td>
                                    </tr>
                                </table>
                        </form>
               </div>
    </div>


    <!--check whether btn is clicked or not only then password will be changed -->
    <?php 
    if(isset($_POST['submit']))
    {
        //1. get the data from form
        $id=mysqli_real_escape_string($conn,$_POST['id']);
        $current_password = mysqli_real_escape_string($conn,md5($_POST['current_password']));
        $new_password = mysqli_real_escape_string($conn,md5($_POST['new_password']));
        $confirm_password = mysqli_real_escape_string($conn,md5($_POST['confirm_password']));

        //2. check whether the user with current id and current password exists or not
        $sql = "SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";

        //Execute the query 
        $res = mysqli_query($conn, $sql);

        if($res==true)
        {
            //check whether data is availaible or not
            $count=mysqli_num_rows($res);

            if($count==1)
            {
                //user exists and password can be changed
                //echo "usr found";
                //check whether the new password and confirm password match or not
                if($new_password==$confirm_password)
                {
                    //update the password
                    //we cannot create two same sqls in one sheet so  name will be changed
                    $sql2 = "UPDATE tbl_admin SET 
                    password = '$new_password'
                    WHERE id=$id
                    ";

                    // execute the query
                    $res2 =mysqli_query($conn, $sql2);

                    //check whether the query executed or not
                    if($res2==true)
                    {
                        //display success message
                        //redirect to manage admin page with success message
                        $_SESSION['change-pwd'] = "<div class='success'> Password changed successfully. </div>";
                        //redirect the user
                        header("location:".SITEURL.'admin/manage-admin.php');
                    }
                    else
                    {
                        //dispaly error message
                        $_SESSION['change-pwd'] = "<div class='error'> Failed to change password. </div>";
                        //redirect the user
                        header("location:".SITEURL.'admin/manage-admin.php');

                    }




                }
                else
                {
                    //redirect to manage admin page with error message
                    $_SESSION['pwd-not-match'] = "<div class='error'> Password did not match. </div>";
                    //redirect the user
                    header("location:".SITEURL.'admin/manage-admin.php');

                }
            }

            else
            {
                //user does not exist set message and redirect
                $_SESSION['user-not-found'] = "<div class='error'> User Not Found. </div>";
                //redirect the user
                header("location:".SITEURL.'admin/manage-admin.php');

            }
        }
        //3. check whether the new password and confirm password match or not
        //4. change password if all above is true
    }
    
    
    ?>


    <?php include('partials/footer.php');  ?>

