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
          <div class="box-body"><!-- Customer and dates -->

            <div class="col-md-6">
              <div class="form-group">
                  <label>Customer Name</label>
                  <input type="text" class="form-control" placeholder="Enter Customer Name" name="txtcustomer" required>
              </div>
            </div>

            <div class="col-md-6">
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

          </div>
          <div class="box-body"><!-- Table -->

          </div>

          <div class="box-body"><!-- tax dis. etc -->

          </div>

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