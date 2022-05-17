<?php include('partials-front/menu.php'); ?>


    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            <?php 
             //get the search keyword
             $search = mysqli_real_escape_string($conn, $_POST['search']);
            
            
            ?>
            <h2>Foods on Your Search <a href="#" class="text-white">"<?php echo $search; ?>"</a></h2>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php  

                    //sql query to get foods based on search keyword
                    //how hackers attack:
                    //$search = burger '; DROP database name;
                    //"SELECT * FROM tbl_food WHERE title LIKE '%$burger'%' OR description LIKE '%$burger'%'";
                    //to protect this use mysqli_real_escape_string();
                    $sql = "SELECT * FROM tbl_food WHERE title LIKE '%$search%' OR description LIKE '%$search%'";

                    //Execute the query
                    $res = mysqli_query($conn, $sql);

                    //count rows
                    $count = mysqli_num_rows($res);

                    //check whether food availaoble or not
                    if($count>0)
                    {
                        //Food Availaible
                        while($row=mysqli_fetch_assoc($res))
                        {
                            //Get The Details
                            $id = $row['id'];
                            $title = $row['title'];
                            $price = $row['price'];
                            $description = $row['description'];
                            $image_name = $row['image_name'];
                            ?>
                                    <div class="food-menu-box">
                                        <div class="food-menu-img">
                                            <?php 
                                                //check whether image availaible or not
                                                if($image_name=="")
                                                {
                                                    //Image Not Availaible
                                                    echo "<div class='error'>Image Not Available.</div>";
                                                }
                                                else 
                                                {
                                                    //Image Avalaible
                                                    ?>
                                                        <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                                                    <?php
                                                }    
                                            
                                            ?>
                                            
                                        </div>

                                        <div class="food-menu-desc">
                                            <h4><?php echo $title; ?></h4>
                                            <p class="food-price">$<?php echo $price; ?></p>
                                            <p class="food-detail">
                                            <?php echo $description; ?>
                                            </p>
                                            <br>

                                            <a href="#" class="btn btn-primary">Order Now</a>
                                        </div>
                                    </div>
                            <?php

                        }
                    }
                    else 
                    {
                        //Food Not Avaialiable
                        echo "<div class='error'>Food Not Found.</div>";
                    }
            
            ?>
            <div class="clearfix"></div>
        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->

    <?php include('partials-front/footer.php'); ?>
