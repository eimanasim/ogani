<?php
session_start();
session_abort();
session_destroy();  

echo "<script>alert('Logged out successfully');window.location.href='../ogani/index.php';</script>";



    ?>