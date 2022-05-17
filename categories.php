<?php include('partials-front/menu.php'); ?>




    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>

            <?php 
                //Display all the categories that are actrive
                //SQL Query
                $sql ="SELECT * FROM tbl_category WHERE active='Yes'";

                //Execute query
                $res = mysqli_query($conn, $sql);

                //count rows
                $count = mysqli_num_rows($res);

                //check whether categories availaible or not
                if($count>0)
                {
                    //Categories Available
                    while($row=mysqli_fetch_assoc($res))
                    {
                        //Get the values
                        $id =$row['id'];
                        $title = $row['title'];
                        $image_name = $row['image_name'];
                        ?>

                            <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id; ?>">
                                <div class="box-3 float-container">
                                    <?php 
                                        if($image_name=="")
                                        {
                                            //Image Not Avalaible
                                            echo "<div class='error'>Image Not Found.</div>";
                                        }
                                        else 
                                        {
                                            //Image Availaible
                                            ?>

                                                <img src="<?php echo SITEURL; ?>images/categories/<?php echo $image_name; ?>" alt="Pizza" class="img-responsive img-curve">

                                            <?php
                                        }
                                    ?>
                                    

                                    <h3 class="float-text text-white">Pizza</h3>
                                </div>
                            </a>

                        <?php
                    }
                }
                else 
                {
                    //Categories Not Available
                    echo "<div class='error'>Category Not Found.</div>";
                }
            
            ?>

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->


    <?php include('partials-front/footer.php'); ?>
