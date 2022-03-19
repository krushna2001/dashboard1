<?php
$firstname= $_POST['firstname'];
$lastname= $_POST['lastname'];
$email= $_POST['email'];
$password1= $_POST['password1'];
$gender= $_POST['gender'];
$number1= $_POST['number1'];
$address1= $_POST['address1'];
$city= $_POST['city'];
$state1= $_POST['state1'];
$zip= $_POST['zip'];

if ( !empty($firstname) || !empty($lastname) || !empty($email) || !empty($password1) || !empty($gender) || !empty($number1) || !empty($address1) || !empty($city) || !empty($state1) || !empty($zip))
{
    $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbName = "data";
    //create connection
    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);
    if(mysqli_connect_error())
    {
        die('Connect Error('.mysqli_connect_errno().')'.mysqli_connect_error());
    }
    else
    {
        $SELECT = "SELECT email from data1 Where email = ? Limit 1";
        $INSERT = " INSERT Into data1 (firstname, lastname, email, password1, gender, number1, address1, city, state1 zip) values(?,?,?,?,?,?,?,?,?,?)";
        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($email);
        $stmt->store_result();
        $rnum = $stmt->num_rows();

        if($rnum==0){
            $stmt = $conn->prepare($INSERT);
            $stmt->bind_param("sssssisssi" , $firstname,$lastname,$email,$password1,$gender,$number1,$address1,$city,$state1,$zip);
            $stmt->execute();
            echo "New record inserted successfully";
        }
        else{
            echo "Someone already registered using this email";
        }
        $stmt->close();
        $conn->close();
    }
}
else{
    echo "All Field are required";
    die();
}

?>