<!-- this is the header -->
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

  // getting the product id from product list page as well the data from that page
  $id = $_GET['id'];
  $select = $pdo->prepare("SELECT * FROM tbl_product WHERE pid=$id");
  $select->execute();
  $row = $select->fetch(PDO::FETCH_ASSOC);

  $id_db = $row['pid'];
  $pname_db = $row['pname'];
  $pcategory_db = $row['pcategory'];
  $purchaseprice_db = $row['purchaseprice'];
  $saleprice_db = $row['saleprice'];
  $pstock_db = $row['pstock'];
  $pdescription_db = $row['pdescription'];
  $pimage_db = $row['pimage'];

  //print_r($row);

  if(isset($_POST['btnpupdate'])){
    $pname_txt = $_POST['txtpname'];
    $pcategory_txt = $_POST['selectcategory'];
    $purchaseprice_txt = $_POST['txtpprice'];
    $saleprice_txt = $_POST['txtsprice'];
    $stock_txt = $_POST['txtstock']; 
    $pdescription_txt = $_POST['txtpdescription'];
  
    //upload the image
    $f_name = $_FILES['myfile']['name'];

    if(!empty($f_name)){

    }else{
      $update = $pdo->prepare("UPDATE tbl_product SET pname=:pname, pcategory=:pcategory, purchaseprice=:pprice, saleprice=:saleprice, pstock=:pstock, 
      pdescription=:pdescription, pimage=:pimage WHERE pid=$id");

      $update->bindParam(':pname',$pname_txt);
      $update->bindParam(':pcategory',$pcategory_txt);
      $update->bindParam(':pprice',$purchaseprice_txt);
      $update->bindParam(':saleprice',$saleprice_txt);
      $update->bindParam(':pstock',$stock_txt);
      $update->bindParam(':pdescription',$pdescription_txt);
      $update->bindParam(':pimage',$pimage_db);

      if($update->execute()){
        echo '<script type="text/javascript">
        jQuery(function validation(){
  
          swal({
            title: "Product updated",
            text: "Product updated successfully",
            icon: "success",
            button: "Ok",
          });
  
        })
        </script>';
      }else{
        echo '<script type="text/javascript">
        jQuery(function validation(){
  
          swal({
            title: "Error!",
            text: "Product update Fail",
            icon: "error",
            button: "Ok",
          });
  
        })
        </script>';
      }

    }

  }





?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit Product
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->
      
      <div class="box box-warning">
        <div class="box-header with-border">
          <h3 class="box-title"><a href="productlist.php" class="btn btn-primary" role="button">Back to Product List</a></h3>
        </div>
        <!-- /.box-header -->
        <form action="" method="POST" name="formproduct" enctype="multipart/form-data"> <!-- remember always add enctype to the form if you plan to upload a file -->
          <div class="box-body">

            <div class="col-md-6">
              <div class="form-group">
                  <label>Product Name</label>
                  <input type="text" class="form-control" placeholder="Enter..." name="txtpname" value="<?php echo $pname_db;?>" required>
              </div>
              <div class="form-group">
                <label>Category</label>
                <select class="form-control" name="selectcategory" required>
                  <option value="" disabled selected>Select category</option>  <!-- Fetching category from the category table -->
                  <?php
                    $select = $pdo->prepare("SELECT * FROM tbl_category ORDER BY catid");
                    $select->execute();
                    while($row=$select->fetch(PDO::FETCH_ASSOC)){
                      extract($row);
                      ?> <!-- $pcategory_db this comes from product table and $row['category'] comes from category table, if both are iqual, we are going to select the value -->
                      <option <?php if($row['category']==$pcategory_db){?>
                        selected="selected"
                        <?php } ?> >

                        <?php echo $row['category']?></option>
                      <?php
                    }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label>Purchase price</label> <!-- this is numeric field -->
                <input type="number" min="0" step="0.01" class="form-control" placeholder="Enter..." name="txtpprice" value="<?php echo $purchaseprice_db;?>" required>
              </div>
              <div class="form-group">
                <label>Sale price</label> <!-- this is numeric field -->
                <input type="number" min="0" step="0.01" class="form-control" placeholder="Enter..." name="txtsprice" value="<?php echo $saleprice_db;?>" required>
              </div>
            </div>
            
            
            <div class="col-md-6">
              <div class="form-group">
                <label>Stock</label>  <!-- this is numeric field -->
                <input type="number" min="0" step="0.01" class="form-control" placeholder="Enter..." name="txtstock" value="<?php echo $pstock_db;?>" required>
              </div>
              <div class="form-group">
                <label>Product description</label>
                <textarea type="text" class="form-control" placeholder="Enter..." name="txtpdescription" rows="4" required><?php echo $pdescription_db;?></textarea>
              </div>
              <div class="form-group">
                <label>Product image</label>   <!-- this myfile name comes from the code for upload a file -->
                <img src="productimages/<?php echo $pimage_db;?>" class="img-responsive" width="150px" height="150px">
                </br>
                <input type="file" class="input-group" name="myfile">
                <p>Upload image</p>
              </div>
            </div>
          </div>
          <div class="box-footer">
            <button type="submit" class="btn btn-warning" name="btnpupdate">Update Product</button>
          </div>
        </form>
      </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php 
    include_once 'footer.php';
  ?>