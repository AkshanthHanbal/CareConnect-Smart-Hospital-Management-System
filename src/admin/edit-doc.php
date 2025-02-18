<?php

//import database
include("../connection.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $oldemail = $_POST["oldemail"];
    $spec = $_POST['spec'];
    $email = $_POST['email'];
    $tele = $_POST['Tele'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $id = $_POST['id00'];

    if ($password == $cpassword) {
        $error = '3';
        $result = $database->query("select doctor.docid from doctor inner join webuser on doctor.docemail=webuser.email where webuser.email='$email';");
        if ($result->num_rows == 1) {
            $id2 = $result->fetch_assoc()["docid"];
        } else {
            $id2 = $id;
        }

        if ($id2 != $id) {
            $error = '1';
        } else {
            // Update doctor and webuser records
            $sql1 = "update doctor set docemail='$email', docname='$name', docpassword='$password', doctel='$tele', specialties=$spec where docid=$id;";
            $database->query($sql1);

            $sql2 = "update webuser set email='$email' where email='$oldemail';";
            $database->query($sql2);

            $error = '4';
        }
    } else {
        $error = '2';
    }
} else {
    $error = '3';
}

// Make sure there is no output before the header() call
// Remove or relocate any unwanted output

// Perform the redirection
header("location: doctors.php?action=edit&error=".$error."&id=".$id);
exit; // Ensure that no code is executed after the header() call
?>
