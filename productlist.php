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
        Product List
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
          <h3 class="box-title">Product List</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table class="table table-striped">
            <thead> <!-- table heading -->  
              <tr>
                <th>#</th>
                <th>Product Name</th>
                <th>Category</th>
                <th>Purchased price</th>
                <th>Sale price</th>
                <th>Stock</th>
                <th>Description</th>
                <th>Image</th>
                <th>View</th>
                <th>Edit</th>
                <th>Delete</th>
              </tr>
            </thead>
            <tbody> <!-- table body --> 
              <?php
                $select=$pdo->prepare("SELECT * FROM tbl_product ORDER BY pid");
                $select->execute();
                
                while($row=$select->fetch(PDO::FETCH_OBJ)){  //using while to fetch all the data from the database // using FETCH_OBJ because I'm fetching each fild of the database
                  echo '
                    <tr>
                    <td>'.$row->pid.'</td>
                    <td>'.$row->pname.'</td>
                    <td>'.$row->pcategory.'</td>
                    <td>'.$row->purchaseprice.'</td>
                    <td>'.$row->saleprice.'</td>
                    <td>'.$row->pstock.'</td>
                    <td>'.$row->pdescription.'</td>
                    <td>'.$row->pimage.'</td>
                    <td>
                      <a href="registration.php?id='.$row->pid.'" class="btn btn-danger" role="button" name="btndelete"><span class="glyphicon glyphicon-trash" title="delete"></span></a>
                    </td>
                    <td>
                      <a href="registration.php?id='.$row->pid.'" class="btn btn-danger" role="button" name="btndelete"><span class="glyphicon glyphicon-trash" title="delete"></span></a>
                    </td>
                    <td>
                      <a href="registration.php?id='.$row->pid.'" class="btn btn-danger" role="button" name="btndelete"><span class="glyphicon glyphicon-trash" title="delete"></span></a>
                    </td>
                    </tr>
                  ';
                }
              ?>
            </tbody>
          </table>
        </div>
      </div>


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php 
    include_once 'footer.php';
  ?>