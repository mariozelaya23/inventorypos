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
        Admin Dashboard
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
          <h3 class="box-title"></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div style="overflow-x:auto">
                <table id="producttable" class="table table-striped">
                    <thead> <!-- table heading -->  
                        <tr>
                        <th>Inovice ID</th>
                        <th>Customer Name</th>
                        <th>Order Date</th>
                        <th>Total</th>
                        <th>Paid</th>
                        <th>Due</th>
                        <th>Payment Type</th>
                        <th>Print</th>
                        <th>Edit</th>
                        <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody> <!-- table body --> 
                        <?php
                        $select=$pdo->prepare("SELECT * FROM tbl_invoice ORDER BY invoice_id");
                        $select->execute();
                        
                        while($row=$select->fetch(PDO::FETCH_OBJ)){  //using while to fetch all the data from the database // using FETCH_OBJ because I'm fetching each fild of the database
                            echo '
                            <tr>
                            <td>'.$row->invoice_id.'</td>
                            <td>'.$row->customer_name.'</td>
                            <td>'.$row->order_date.'</td>
                            <td>'.$row->total.'</td>
                            <td>'.$row->paid.'</td>
                            <td>'.$row->due.'</td>
                            <td>'.$row->payment_type.'</td>
                            <td>
                                <a href="viewproduct.php?id='.$row->invoice_id.'" class="btn btn-success" role="button" name="btndelete"><span class="glyphicon glyphicon-eye-open" style="color=#ffffff" data-toggle="tooltip" title="Print Invoice"></span></a>
                            </td>
                            <td>
                                <a href="editproduct.php?id='.$row->invoice_id.'" class="btn btn-info" role="button" name="btndelete"><span class="glyphicon glyphicon-edit" style="color=#ffffff" data-toggle="tooltip" title="Edit Order"></span></a>
                            </td>
                            <td>
                                <button id='.$row->invoice_id.' class="btn btn-danger btndelete" name="btndelete"><span class="glyphicon glyphicon-trash" style="color=#ffffff" data-toggle="tooltip" title="Delete Order"></span></button>
                            </td>
                            </tr>
                            ';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
      </div>


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php 
    include_once 'footer.php';
  ?>