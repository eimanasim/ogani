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
                
            </div>
            <div class="checkout__form">
                <h4>Login Details</h4>
                <form action="" method="POST">
                    <div class="row">
                        <div class="col-lg-8 col-md-6">
                          
                        
                           
                            <div class="row">
                               
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Email<span>*</span></p>
                                        <input type="text" name = "s_email">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Password<span>*</span></p>
                                        <input type="password" name = "s_password">
                                    </div>
                                </div>
                            </div>
                             <button type="submit" name="btn" class="site-btn">LOGIN</button>
                            
                           
                        
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- Checkout Section End -->

<?php
include('../dashboard/connect.php');


if(isset($_POST['btn'])){
    $s_email = $_POST['s_email'];
    $s_password = $_POST['s_password'];

    $query = "SELECT * FROM `signup` WHERE `email` = '$s_email' AND `password` = '$s_password'";

    
    $result = mysqli_query($con,$query);

    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_array($result);
        $_SESSION['id'] = $row['id'];
        $_SESSION['name'] = $row['name'];
        $_SESSION['role'] = $row['role']??"admin";

        if($_SESSION['role'] === 'admin'){
           echo "<script>window.location.href='../dashboard/index.php';</script>";
      
        }else{
            echo "<script>window.location.href='index.php';</script>";
    }
   
}
}
?>
<?php
include 'footer.php';
?>