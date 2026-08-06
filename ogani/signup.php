<?php
include 'header.php';
?>
    

    <!-- Hero Section Begin -->

    <!-- Hero Section End -->

    <!-- Breadcrumb Section Begin -->
 
    <!-- Breadcrumb Section End -->

    <!-- Checkout Section Begin -->
    <section class="checkout spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h6>Signup
                    </h6>
                </div>
            </div>
            <div class="checkout__form">
                <h4>SignupDetails</h4>
                <form action="" method="post">
                    <div class="row">
                        <div class="col-lg-8 col-md-6">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p> Name<span>*</span></p>
                                        <input type="text" name="s_name" placeholder="Enter your name" required>
                                    </div>
                                </div>
                               
                            
                        
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Phone<span>*</span></p>
                                        <input type="text" name="s_phone" placeholder="Enter your phone number" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Email<span>*</span></p>
                                        <input type="text" name="s_email" placeholder="Enter your email" required>
                                    </div>
                                </div>
                            </div>
                              <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Password<span>*</span></p>
                                        <input type="password" name="s_password" placeholder="Enter your password" required>
                                    </div>
                                </div>
                            </div>
                           
                            
                                <button type="submit" name="btn" class="site-btn">Signup</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- Checkout Section End -->

<?php
include ('../dashboard/connect.php');

if(isset($_POST['btn']))
{
    $s_name=$_POST['s_name'];
    $s_email=$_POST['s_email'];
    $s_phone=$_POST['s_phone'];
    $s_password=$_POST['s_password'];

    $query="INSERT INTO `signup`(`name`, `email`, `phone`, `password`,`role`) VALUES ('$s_name','$s_email','$s_phone','$s_password','customer')";
    $result=mysqli_query($con,$query);
    // if($result)
    // {
    //     echo "<script>alert('Signup Successfully');</script>";
    //     }
    // else
    // {
    //     echo "<script>alert('Signup Failed');</script>";   
    // }
}


   
include 'footer.php';   
?>  