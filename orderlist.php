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
          <h3 class="box-title">Order Table</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div style="overflow-x:auto">
                <table id="ordertable" class="table table-striped">
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
                                <a href="invoice.php?id='.$row->invoice_id.'" class="btn btn-warning" role="button"><span class="glyphicon glyphicon-print" style="color=#ffffff" data-toggle="tooltip" title="Print Invoice"></span></a>
                            </td>
                            <td>
                                <a href="editorder.php?id='.$row->invoice_id.'" class="btn btn-info" role="button"><span class="glyphicon glyphicon-edit" style="color=#ffffff" data-toggle="tooltip" title="Edit Order"></span></a>
                            </td>
                            <td>
                                <button id='.$row->invoice_id.' class="btn btn-danger btndelete"><span class="glyphicon glyphicon-trash" style="color=#ffffff" data-toggle="tooltip" title="Delete Order"></span></button>
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

<!-- Call this single function -->
<script>
  $(document).ready( function () {
  $('#ordertable').DataTable({
    "order":[[0,"desc"]]
  });
  });
</script>

<script>
  $(document).ready( function () {
    $('[data-toggle="tooltip"]').tooltip();
  });

  $(document).ready(function(){
    $('.btndelete').click(function(){
      //alert('Test');

      var tdh = $(this);
      var id = $(this).attr("id");
      //alert(id);
      //sweet alert
      swal({
        title: "Do you want to delete the order?",
        text: "Once order, you can not recover this order!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) { //ajax code
          $.ajax({
            url:'orderdelete.php',
            type:'post',
            data:{
              pidd:id
            },
            success:function(data){
              tdh.parents('tr').hide();
            }
          })
          swal("Your order has been deleted!", {
            icon: "success",
          });
        } else {
          swal("Your order is safe!");
        }
      });

    });
  
  });
</script>


<?php 
    include_once 'footer.php';
?>