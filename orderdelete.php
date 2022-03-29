<?php
    include_once 'connectdb.php';
    session_start();

    $id = $_POST['pidd'];  //pidd comes from the ajax code in productlist.php

    // DELETE T1, T2 FROM T1 INNER JOIN T2 ON T1.KEY = T2.KEY WHERE CONDITION T1.KEY = id;
    $sql = "DELETE tbl_invoice, tbl_invoice_details 
    FROM tbl_invoice
    INNER JOIN tbl_invoice_details 
    ON tbl_invoice.invoice_id = tbl_invoice_details.invoice_id
    WHERE tbl_invoice.invoice_id=$id";

    $delete = $pdo->prepare($sql);

    if($delete->execute()){

    }else{
        echo 'Error deleting';
    }
?>