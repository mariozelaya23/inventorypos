<?php
    include_once 'connectdb.php';
    session_start();

    if($_SESSION['useremail']=="" OR $_SESSION['role']=="User"){   //this username comes from the variable in index.php, we are restricting the access
        header('location:index.php');
    }

    if($_SESSION['role']=="Admin"){
        include_once'header.php';
    }else{
        include_once'headeruser.php';
    }

    $id = $_POST['pidd'];  //pidd comes from the ajax code in productlist.php

    $sql = "DELETE FROM tbl_product WHERE pid=$id";
    $delete = $pdo->prepare($sql);

    if($delete->execute()){

    }else{
        echo 'Error deleting';
    }
?>