<!-- this is the header -->
<?php 
    include_once 'connectdb.php';

    $id = $_GET["id"];  //this id comes from the ajax request in createorder.php, data:{id:productid}, using get method

    $select = $pdo->prepare("SELECT * FROM tbl_product WHERE pid = :ppid");  //this :ppid, you can use any name
    $select->bindParam(":ppid",$id);
    $select->execute();
    $row=$select->fetch(PDO::FETCH_ASSOC);

    $response=$row;

    header("Content-type: application/json");

    echo json_encode($response);


?>
