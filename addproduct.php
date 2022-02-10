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


?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add Product
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Add Product</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->
      
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Product Form</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <form action="" method="POST" name="formproduct">

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
                  <input type="number" min="1" step="1" class="form-control" placeholder="Enter..." name="txtpprice" required>
                </div>
                <div class="form-group">
                  <label>Sale price</label> <!-- this is numeric field -->
                  <input type="number" min="1" step="1" class="form-control" placeholder="Enter..." name="txtsprice" required>
                </div>
              </div>
              
              
              <div class="col-md-6">
                <div class="form-group">
                  <label>Stock</label>  <!-- this is numeric field -->
                  <input type="number" min="1" step="1" class="form-control" placeholder="Enter..." name="txtstock" required>
                </div>
                <div class="form-group">
                  <label>Product description</label>
                  <textarea type="text" class="form-control" placeholder="Enter..." name="txtpdescription" rows="4" required></textarea>
                </div>
                <div class="form-group">
                  <label>Product image</label>
                  <input type="file" class="input-group" name="pimage" required>
                  <p>Upload image</p>
                </div>
              </div>
            </form>
          </div>
        </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php 
    include_once 'footer.php';
  ?>