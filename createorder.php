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
        Create Order
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
        <form action="" method="POST" name="">
          <div class="box-header with-border">
            <h3 class="box-title">New Order</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body"><!-- Customer and dates --> <!-- row 1 -->

            <div class="col-md-6"><!-- 6 columns -->
              <div class="form-group">
                  <label>Customer Name</label>
                  <input type="text" class="form-control" placeholder="Enter Customer Name" name="txtcustomer" required>
              </div>
            </div>

            <div class="col-md-6"><!-- 6 columns -->
              <!-- Date -->
              <div class="form-group">
                <label>Date:</label>
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="datepicker">
                </div>
                <!-- /.input group -->
              </div>
              <!-- /.form group -->
            </div>

          </div> <!-- end of row 1 -->
          <div class="box-body"><!-- Table --> <!-- row 2 -->
            <div class="col-md-12"><!-- 12 columns -->
              <table id="producttable" class="table table-striped">
                <thead> <!-- table heading -->  
                  <tr>
                    <th>#</th>
                    <th>Search Product</th>
                    <th>Stock</th>
                    <th>price</th>
                    <th>Enter Quantity</th>
                    <th>Total</th>
                    <th>
                    <button type="button" name="add" class="btn btn-success btn-sm btnadd" name="btnadd"><span class="glyphicon glyphicon-plus"></span></button>
                    </th>
                  </tr>
                </thead>
              </table>
            </div>
          </div><!-- end row 2 -->

          <div class="box-body"><!-- tax dis. etc --> <!-- row 3 -->

            <div class="col-md-6"><!-- 6 columns -->
              <div class="form-group">
                  <label>SubTotal</label>
                  <input type="text" class="form-control" name="txtsubtotal" required>
              </div>
              <div class="form-group">
                  <label>Tax (5%)</label>
                  <input type="text" class="form-control" name="txttax" required>
              </div>
              <div class="form-group">
                  <label>Discount</label>
                  <input type="text" class="form-control" name="txtdiscount" required>
              </div>
            </div>

            <div class="col-md-6"><!-- 6 columns -->
              <div class="form-group">
                  <label>Total</label>
                  <input type="text" class="form-control" name="txttotal" required>
              </div>
              <div class="form-group">
                  <label>Paid</label>
                  <input type="text" class="form-control" name="txtpaid" required>
              </div>
              <div class="form-group">
                  <label>Due</label>
                  <input type="text" class="form-control" name="txtdue" required>
              </div>
            </div>
          </div><!-- end row 3 -->

        </form>
      </div>


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <script>
    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })
  </script>


  <?php 
    include_once 'footer.php';
  ?>