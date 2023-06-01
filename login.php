<?php
    include 'connection.php';
    include 'flag_msg.php';

    $name = $_POST["username"];
    $pwd = $_POST['pwd'];

    if(isset($name) && isset($pwd)){
        $sql = "SELECT * FROM administration WHERE username='".$name."'";
        $result = mysqli_query($conn, $sql); 
        if (!empty($result)) {
            while($row = mysqli_fetch_array($result)) {
                if (password_verify($pwd, $row['password'])) {
                    header("location: index.html");
                }else{
                    var_dump("hi");
                    header('Location: login.html');
                    echo '<script type="text/javascript">alert("' . $login_err . '")</script>';
                }
            }
        }
    }

?>