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

    function fill_product($pdo){ //function passing the connection object $pdo
      $output='';
      $select=$pdo->prepare("SELECT * FROM tbl_product ORDER BY pname");
      $select->execute();
      $result=$select->fetchAll();

      foreach($result as $row){
        $output.='<option data-purchaseprice="'.$row['purchaseprice'].'" data-saleprice="'.$row['saleprice'].'" data-stock="'.$row['pstock'].'" value"'.$row["pid"].'">'.$row["pname"].'</option>';
      }
      return $output; //return of the function
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
              <div style="overflow-x:auto">
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
        // var html='';
        // html+='<tr>';
        // html+='<td><input type="hidden" class="form-control pname" name="productname[]" readonly></td>';
        // html+='<td><select class="form-control productid" name="productid[]" style="width:300px";><option value="">Select Option</option><?php echo fill_product($pdo);?></select></td>';
        // html+='<td><input type="text" class="form-control stock" name="stock[]" readonly></td>';
        // html+='<td><input type="text" class="form-control price" name="price[]" readonly></td>';
        // html+='<td><input type="text" class="form-control qty" name="qty[]" ></td>';
        // html+='<td><input type="text" class="form-control total" name="total[]" readonly></td>';
        // html+='<td><center><button type="button" name="remove" class="btn btn-danger btn-sm btnremove"><span class="glyphicon glyphicon-remove"></span></button></center></td>';
        
        var html=`
        <tr>
        <td><input type="hidden" class="form-control pname" name="productname[]" readonly></td>
        <td><select class="form-control productid" name="productid[]" style="width:300px";><option value="">Select Option</option><?php echo fill_product($pdo);?></select></td>
        <td><input type="text" class="form-control stock" name="stock[]" readonly></td>
        <td><input type="text" class="form-control price" name="price[]" readonly></td>
        <td><input type="text" class="form-control qty" name="qty[]" ></td>
        <td><input type="text" class="form-control total" name="total[]" readonly></td>
        <td><center><button type="button" name="remove" class="btn btn-danger btn-sm btnremove"><span class="glyphicon glyphicon-remove"></span></button></center></td>`;

        $('#producttable').append(html);

        //Initialize Select2 Elements
        $('.productid').select2()
// You don't need use ajax here
// Let me work then you can see
      });
      $(document).on('change','.productid',function(e){  //this productid comes from the function above, passing the id and the name,  $output.='<option value"'.$row["pid"].'">'.$row["pname"].'</option>';
        var selectPro = $(e.currentTarget); // jQuery get current selection
        var stock = selectPro.find('option:selected').attr('data-stock');
        var price = selectPro.find('option:selected').attr('data-purchaseprice');
        var tr = selectPro.parent().parent();
        tr.find(".stock").val(stock);
        tr.find(".price").val(price);
        tr.find(".qty").val(1);
        tr.find(".total").val(tr.find(".qty").val() * tr.find(".price").val());
      
        // var productid=this.value;
        // var tr=$(this).parent().parent();
        // $.ajax({
        //   url:"getproduct.php",
        //   method:"GET",
        //   data:{id:productid},
        //   success:function(data){
        //     console.log(data);
        //     tr.find(".stock").val(data["pstock"]);// .stock comes from html+= class="form-control stock" and pstock is the column in the database
        //   }
        //   })
      })
      $(document).on('click','.btnremove',function(){  //when you say this is because we are working here on the button
        $(this).closest('tr').remove();
      })
    });

  </script>


  <?php 
    include_once 'footer.php';
  ?>