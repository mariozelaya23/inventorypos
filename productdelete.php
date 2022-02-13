<?php
    include_once 'connectdb.php';
    $id = $_POST['pidd'];  //pidd comes from the ajax code in productlist.php

    $sql = "DELETE FROM tbl_product WHERE pid=$id";
    $delete = $pdo->prepare($sql);

    if($delete->execute()){

    }else{
        echo 'Error deleting';
    }

?>