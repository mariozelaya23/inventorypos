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
                  <input type="text" class="form-control" placeholder="Enter..." name="txtpname" required>
              </div>
              <div class="form-group">
                <label>Category</label>
                <select class="form-control" name="selectcategory" required>
                  <option value="" disabled selected>Select category</option>  <!-- Fetching category from the database -->
                  <?php
                    $select = $pdo->prepare("SELECT * FROM tbl_category ORDER BY catid");
                    $select->execute();
                    while($row=$select->fetch(PDO::FETCH_ASSOC)){
                      extract($row);
                      ?>
                      <option><?php echo $row['category']?></option>
                      <?php
                    }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label>Purchase price</label> <!-- this is numeric field -->
                <input type="number" min="0" step="0.01" class="form-control" placeholder="Enter..." name="txtpprice" required>
              </div>
              <div class="form-group">
                <label>Sale price</label> <!-- this is numeric field -->
                <input type="number" min="0" step="0.01" class="form-control" placeholder="Enter..." name="txtsprice" required>
              </div>
            </div>
            
            
            <div class="col-md-6">
              <div class="form-group">
                <label>Stock</label>  <!-- this is numeric field -->
                <input type="number" min="0" step="0.01" class="form-control" placeholder="Enter..." name="txtstock" required>
              </div>
              <div class="form-group">
                <label>Product description</label>
                <textarea type="text" class="form-control" placeholder="Enter..." name="txtpdescription" rows="4" required></textarea>
              </div>
              <div class="form-group">
                <label>Product image</label>   <!-- this myfile name comes from the code for upload a file -->
                <input type="file" class="input-group" name="myfile" required>
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