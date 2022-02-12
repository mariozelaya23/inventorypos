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

if(isset($_POST['btnpadd'])){
  $pname = $_POST['txtpname'];
  $pcategory = $_POST['selectcategory'];
  $purchaseprice = $_POST['txtpprice'];
  $saleprice = $_POST['txtsprice'];
  $stock = $_POST['txtstock'];
  $pdescription = $_POST['txtpdescription'];

  //upload the image
  $f_name= $_FILES['myfile']['name'];
  $f_tmp = $_FILES['myfile']['tmp_name'];
  $f_size =  $_FILES['myfile']['size'];
  $f_extension = explode('.',$f_name);
  $f_extension= strtolower(end($f_extension));
  $f_newfile =  uniqid().'.'. $f_extension;   
  $store = "productimages/".$f_newfile;
  
  if($f_extension=='jpg' || $f_extension=='jpeg' || $f_extension=='png' || $f_extension=='gif'){
    if($f_size>=1000000){
      $error = '<script type="text/javascript">
      jQuery(function validation(){

        swal({
          title: "Error!",
          text: "Max file size should be 1MB",
          icon: "Warning",
          button: "Ok",
        });

      })
      </script>';
      echo $error;
    }else{
      if(move_uploaded_file($f_tmp,$store)){
        $productimage=$f_newfile;

        if(!isset($error)){
          $insert = $pdo->prepare("INSERT INTO tbl_product(pname,pcategory,purchaseprice,saleprice,pstock,pdescription,pimage) 
          VALUES(:pname,:pcategory,:purchaseprice,:saleprice,:pstock,:pdescription,:pimage)");
      
          $insert->bindParam(':pname',$pname);
          $insert->bindParam(':pcategory',$pcategory);
          $insert->bindParam(':purchaseprice',$purchaseprice);
          $insert->bindParam(':saleprice', $saleprice);
          $insert->bindParam(':pstock',$stock);
          $insert->bindParam(':pdescription',$pdescription);
          $insert->bindParam(':pimage',$productimage);
      
          if($insert->execute()){
            echo '<script type="text/javascript">
            jQuery(function validation(){
      
              swal({
                title: "Product added",
                text: "Product added successfully",
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
                text: "Product added Fail",
                icon: "error",
                button: "Ok",
              });
      
            })
            </script>';
          }
      
        }
      }
    }
  }else{
    $error = '<script type="text/javascript">
    jQuery(function validation(){

      swal({
        title: "Warning!",
        text: "Only jpg, png and gif can be upload",
        icon: "error",
        button: "Ok",
      });

    })
    </script>';
    echo $error;
  }

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
      
        <div class="box box-info">
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
              <button type="submit" class="btn btn-info" name="btnpadd">Add Product</button>
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