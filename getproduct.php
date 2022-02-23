<!-- this is the header -->
<?php 
    include_once 'connectdb.php';
    //session_start();

    $id = $_GET["id"];  //this id comes from the ajax request in createorder.php, data:{id:productid}, using get method

    $select = $pdo->prepare("SELECT * FROM tbl_product WHERE pid = :ppid");  //this :ppid, you can use any name
    $select->bindParam(":ppid",$id);
    $select->execute();
    $row=$select->fetch(PDO::FETCH_ASSOC);

    $respose=$row;

    header('Content-Type: application/json');

    echo json_encode($respose);


?>
