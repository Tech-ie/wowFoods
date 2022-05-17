<?php include('partials/menu.php');  ?>

<!--Main Section starts here-->
<div class="main-content">
    <div class="wrapper">
    <h1>Add Admin</h1>
    <br> <br>

       <?php 
          if(isset($_SESSION['add'])) //checking whether the session is set or not
          {
               echo $_SESSION['add']; //displaying session message
               unset($_SESSION['add']); //removing session message
          }

     ?>




       <form action="" method="POST"> <!--post values are hidden-->
           <table class="tbl-30">
               <tr>
                   <td>Full Name:</td>
                   <td>
                       <input type="text" name="full_name" placeholder="Your Username">  
                    </td>
               </tr>

               <tr>
                   <td>Username:</td>
                   <td>
                       <input type="text" name="username" placeholder="Your Username">  
                    </td>
               </tr>

               <tr>
                   <td>Password:</td>
                   <td>
                       <input type="password" name="password" placeholder="Your Password">  
                    </td>
               </tr>

               <tr>
                  
                   <td colspan="2"> <!--Merge two columns-->
                       <input type="submit" name="submit" value="Add Admin" class="btn-secondary">  
                    </td>
               </tr>
           </table>
       </form>



    </div>
</div>
<!--Main Section ends here-->

<?php include('partials/footer.php');  ?>

<?php 
//process the value from form and save it in database. 

//check whether the submit button is clicked or not

if(isset($_POST['submit']))
{
    //if value is passed or button clicked
  //echo"button clicked";

  //process the data from our form

  //1-step Get the data from form
  $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $password = mysqli_real_escape_string($conn, md5($_POST['password'])); //password encryption with MD5()

  //2-step SQL query to save the data into database
  $sql = "INSERT INTO tbl_admin SET
  full_name = '$full_name',
  username = '$username',
  password = '$password'
  ";

 //executing query and saving data into database

  $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

  //4- check whether the (query is executed) data is inserted or not and display appropriate message

  if($res==TRUE)
  {
      //Data inserted
      //echo "Data Inserted";
      //create a seesion variale to display message (for that we created session in constant)
      $_SESSION['add'] = "<div class='success'>Admin Added Successfully</div>";
      //then Redirect page to Manage Admin Page (for that we created constant siteurl)
      header("location:".SITEURL.'admin/manage-admin.php'); //we concatenate siteurl here
  }
  else 
  {
      //Failed to insert data
      //echo "Failed to insert data";
      //create a seesion variale to display message (for that we created session in constant)
      $_SESSION['add'] = "<div class='error'>Failed to Add Admin.</div>";
      //then Redirect page to Add Admin Page (for that we created constant siteurl)
      header("location:".SITEURL.'admin/add-admin.php'); //we concatenate siteurl here
  }
}

?>