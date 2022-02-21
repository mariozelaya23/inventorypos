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
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-user"></i>
                    </div>
                    <input type="text" class="form-control" placeholder="Enter Customer Name" name="txtcustomer" required>
                  </div>
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
                      <center><button type="button" class="btn btn-success btn-sm btnadd" name="btnadd"><span class="glyphicon glyphicon-plus"></span></button></center>
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
                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-usd"></i>
                    </div>
                    <input type="text" class="form-control" name="txtsubtotal" required>
                  </div>
              </div>
              <div class="form-group">
                  <label>Tax (5%)</label>
                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-usd"></i>
                    </div>
                    <input type="text" class="form-control" name="txttax" required>
                  </div>
              </div>
              <div class="form-group">
                  <label>Discount</label>
                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-usd"></i>
                    </div>
                    <input type="text" class="form-control" name="txtdiscount" required>
                  </div>
              </div>
            </div>

            <div class="col-md-6"><!-- 6 columns -->
              <div class="form-group">
                  <label>Total</label>
                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-usd"></i>
                    </div>
                    <input type="text" class="form-control" name="txttotal" required>
                  </div>
              </div>
              <div class="form-group">
                  <label>Paid</label>
                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-usd"></i>
                    </div>
                    <input type="text" class="form-control" name="txtpaid" required>
                  </div>
              </div>
              <div class="form-group">
                  <label>Due</label>
                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-usd"></i>
                    </div>
                    <input type="text" class="form-control" name="txtdue" required>
                  </div>
              </div>
              <label>Payment Method</label>
              <div class="form-group">
                <label>
                  <input type="radio" name="r2" class="minimal-red" checked> Cash
                </label>
                <label>
                  <input type="radio" name="r2" class="minimal-red"> Card
                </label>
                <label>
                  <input type="radio" name="r2" class="minimal-red" > Check
                </label>
              </div>
            </div>
          </div><!-- end row 3 -->
          <!-- radio -->
          <hr>
          <div align="center">
            <input type="submit" name="btnsaveorder" value="Save Order" class="btn btn-info">
          </div>
          <hr>
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
    });
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass   : 'iradio_minimal-red'
    })

    $(document).ready(function(){
      $(document).on('click','.btnadd',function(){ //btnadd comes from where the table started
        var html='';
        html+='<tr>';
        html+='<td><input type="hidden" class="form-control pname" name="productname[]" readonly></td>';
        html+='<td><select class="form-control productid" name="productid[]"><option value="">Select Option</option></select></td>';
        html+='<td><input type="text" class="form-control stock" name="stock[]" readonly></td>';
        html+='<td><input type="text" class="form-control price" name="price[]" readonly></td>';
        html+='<td><input type="text" class="form-control qty" name="qty[]" ></td>';
        html+='<td><input type="text" class="form-control total" name="total[]" readonly></td>';
        html+='<td><center><button type="button" name="remove" class="btn btn-danger btn-sm btnremove"><span class="glyphicon glyphicon-remove"></span></button></center></td>';
        $('#producttable').append(html);
      })
      $(document).on('click','.btnremove',function(){  //when you say this is because we are working here on the button
        $(this).closest('tr').remove();
      })
    });

  </script>


  <?php 
    include_once 'footer.php';
  ?>