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

    function fill_product($pdo,$pid){ //function passing the connection object $pdo
      $output='';
      $select=$pdo->prepare("SELECT * FROM tbl_product ORDER BY pname");
      $select->execute();
      $result=$select->fetchAll();

      foreach($result as $row){
        $output.='<option data-purchaseprice="'.$row['purchaseprice'].'" data-saleprice="'.$row['saleprice'].'" data-stock="'.$row['pstock'].'" data-pname="'.$row['pname'].'" value="'.$row["pid"].'"';
          if($pid == $row['pid']){  //this part of code show the product name on the select option
            $output.='selected';
          }
          $output.='>'.$row["pname"].'</option>';
      }
      return $output; //return of the function
    }

    //fetch invoice data from the database
    $id = $_GET['id']; //you can see this id when you clic on the editorder button from orderlist.php
    $select = $pdo->prepare("SELECT * FROM tbl_invoice WHERE invoice_id=$id");
    $select->execute();
    $row = $select->fetch(PDO::FETCH_ASSOC);

    //Placing the database values on variables
    $customer_name = $row['customer_name'];  //database value
    $order_date = date('Y-m-d',strtotime($row['order_date']));
    $subtotal = $row['subtotal'];
    $tax = $row['tax'];
    $discount = $row['discount'];
    $total = $row['total'];
    $paid = $row['paid'];
    $due = $row['due'];
    $payment_type = $row['payment_type'];

    //fetch invoice details data from the database
    $id = $_GET['id']; //you can see this id when you clic on the editorder button from orderlist.php
    $select = $pdo->prepare("SELECT * FROM tbl_invoice_details WHERE invoice_id=$id");
    $select->execute();
    $row_invoice_details = $select->fetchAll(PDO::FETCH_ASSOC);


    if(isset($_POST['btnupdateorder'])){
      //invoice table
      $customer_name = $_POST['txtcustomer'];
      $order_date = date('Y-m-d',strtotime($_POST['orderdate']));
      $subtotal = $_POST['txtsubtotal'];
      $tax = $_POST['txttax'];
      $discount = $_POST['txtdiscount'];
      $total = $_POST['txttotal'];
      $paid = $_POST['txtpaid'];
      $due = $_POST['txtdue'];
      $payment_type = $_POST['rb'];
      
      //this variables are for invoice details db table (this variables comes from the JQuery table)
      $arr_productid = $_POST['productid']; //this name comes from the JQuery table name="productid[]"
      $arr_productname = $_POST['productname'];
      $arr_stock = $_POST['stock'];
      $arr_qty = $_POST['qty'];
      $arr_price = $_POST['price'];
      $arr_total = $_POST['total'];

      //invoice table
      $insert = $pdo->prepare("INSERT INTO tbl_invoice(customer_name,order_date,subtotal,tax,discount,total,paid,due,payment_type)
      VALUES(:customer_name,:order_date,:subtotal,:tax,:discount,:total,:paid,:due,:payment_type)");

      $insert->bindParam(':customer_name',$customer_name);
      $insert->bindParam(':order_date',$order_date);
      $insert->bindParam(':subtotal',$subtotal);
      $insert->bindParam(':tax',$tax);
      $insert->bindParam(':discount',$discount);
      $insert->bindParam(':total',$total);
      $insert->bindParam(':paid',$paid);
      $insert->bindParam(':due',$due);
      $insert->bindParam(':payment_type',$payment_type);

      $insert->execute();

      //inserting data in invoice details table
      $invoice_id = $pdo->lastInsertId();
      
      if($invoice_id!=null){
        for($i=0; $i<count($arr_productid); $i++){

          //rem means remaining qty of the stock
          $rem_qty = $arr_stock[$i] - $arr_qty[$i];

          if($rem_qty < 0){
            return "Order is not complete";
          }else{
            $update = $pdo->prepare("UPDATE tbl_product SET pstock = '$rem_qty' WHERE pid='".$arr_productid[$i]."'");
            $update->execute();
          }

          $insert = $pdo->prepare("INSERT INTO tbl_invoice_details(invoice_id,product_id,product_name,qty,price,order_date)
          VALUES(:invoice_id,:product_id,:product_name,:qty,:price,:order_date)");

          $insert->bindParam(':invoice_id',$invoice_id);
          $insert->bindParam(':product_id',$arr_productid[$i]);
          $insert->bindParam(':product_name',$arr_productname[$i]);
          $insert->bindParam(':qty',$arr_qty[$i]);
          $insert->bindParam(':price',$arr_price[$i]);
          $insert->bindParam(':order_date',$order_date);

          $insert->execute();
        }
        //echo "success fully created order";
        header('location:orderlist.php');
      }


    }

?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit Order
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
            <h3 class="box-title"></h3>
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
                    <input type="text" class="form-control" name="txtcustomer" value="<?php echo $customer_name;?>" required>
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
                  <input type="text" class="form-control pull-right" id="datepicker" name="orderdate" value="<?php echo $order_date;?>" data-date-format="yyyy-mm-dd">
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
                        <center><button type="button" class="btn btn-info btn-sm btnadd" name="btnadd"><span class="glyphicon glyphicon-plus"></span></button></center>
                      </th>
                    </tr>
                  </thead>
                  <?php 
                    foreach($row_invoice_details as $item_invoice_details){

                      //fetch invoice details data from the database
                      $id = $_GET['id']; //you can see this id when you clic on the editorder button from orderlist.php
                      $select = $pdo->prepare("SELECT * FROM tbl_product WHERE pid='{$item_invoice_details['product_id']}'");
                      $select->execute();
                      $row_product = $select->fetch(PDO::FETCH_ASSOC);

                  ?>
                    <!-- invoice details product table -->
                    <tr>
                      <?php 
                        echo'<td><input type="hidden" class="form-control pname" name="productname[]" readonly></td>';
                        echo'<td><select class="form-control productidedit" name="productid[]" style="width:300px";><option value="">Select Option</option>'.fill_product($pdo,$item_invoice_details['product_id']).'</select></td>';
                        echo'<td><input type="text" class="form-control stock" name="stock[]" value="'.$row_product['pstock'].'" readonly></td>';
                        echo'<td><input type="text" class="form-control price" name="price[]" value="'.$row_product['saleprice'].'" readonly></td>';
                        echo'<td><input type="number" min="1" class="form-control qty" name="qty[]" value="'.$item_invoice_details['qty'].'" ></td>';
                        echo'<td><input type="text" class="form-control total" name="total[]" value="'.$row_product['saleprice']*$item_invoice_details['qty'].'" readonly></td>';
                        echo'<td><center><button type="button" name="remove" class="btn btn-danger btn-sm btnremove"><span class="glyphicon glyphicon-remove"></span></button></center></td>';
                      ?>
                    </tr>
                    <?php }?>
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
                    <input type="text" class="form-control" name="txtsubtotal" value="<?php echo $subtotal;?>" id="txtsubtotal" required readonly>
                  </div>
              </div>
              <div class="form-group">
                  <label>Tax (5%)</label>
                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-usd"></i>
                    </div>
                    <input type="text" class="form-control" name="txttax" value="<?php echo $tax;?>" id="txttax" required readonly>
                  </div>
              </div>
              <div class="form-group">
                  <label>Discount</label>
                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-usd"></i>
                    </div>
                    <input type="text" class="form-control" name="txtdiscount" value="<?php echo $discount;?>" id="txtdiscount" required>
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
                    <input type="text" class="form-control" name="txttotal" value="<?php echo $total;?>" id="txttotal" required readonly>
                  </div>
              </div>
              <div class="form-group">
                  <label>Paid</label>
                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-usd"></i>
                    </div>
                    <input type="text" class="form-control" name="txtpaid" value="<?php echo $paid;?>" id="txtpaid" required>
                  </div>
              </div>
              <div class="form-group">
                  <label>Due</label>
                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-usd"></i>
                    </div>
                    <input type="text" class="form-control" name="txtdue" id="txtdue" value="<?php echo $due;?>" required readonly>
                  </div>
              </div>
              <label>Payment Method</label>
              <div class="form-group">
                <label>
                  <input type="radio" name="rb" class="minimal-red" value="Cash"<?php echo ($payment_type == 'Cash')?'checked':''?>> Cash
                </label>
                <label>
                  <input type="radio" name="rb" class="minimal-red" value="Card"<?php echo ($payment_type == 'Card')?'checked':''?>> Card
                </label>
                <label>
                  <input type="radio" name="rb" class="minimal-red" value="Check"<?php echo ($payment_type == 'Check')?'checked':''?>> Check
                </label>
              </div>
            </div>
          </div><!-- end row 3 -->
          <!-- radio -->
          <hr>
          <div align="center">
            <input type="submit" name="btnupdateorder" value="Update Order" class="btn btn-warning">
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
        <td><select class="form-control productid" name="productid[]" style="width:300px";><option value="">Select Option</option><?php echo fill_product($pdo,'');?></select></td>
        <td><input type="text" class="form-control stock" name="stock[]" readonly></td>
        <td><input type="text" class="form-control price" name="price[]" readonly></td>
        <td><input type="number" min="1" class="form-control qty" name="qty[]" ></td>
        <td><input type="text" class="form-control total" name="total[]" readonly></td>
        <td><center><button type="button" name="remove" class="btn btn-danger btn-sm btnremove"><span class="glyphicon glyphicon-remove"></span></button></center></td>`;

        $('#producttable').append(html);

        //Initialize Select2 Elements
        $('.productid').select2();

        $('.productidedit').select2();
      // You don't need use ajax here
      // Let me work then you can see
      });
      $(document).on('change','.productid',function(e){  //this productid comes from the function above, passing the id and the name,  $output.='<option value"'.$row["pid"].'">'.$row["pname"].'</option>';
        var selectPro = $(e.currentTarget); // jQuery get current selection
        var pname = selectPro.find('option:selected').attr('data-pname');
        var stock = selectPro.find('option:selected').attr('data-stock');
        var price = selectPro.find('option:selected').attr('data-purchaseprice');
        var tr = selectPro.parent().parent();
        tr.find(".pname").val(pname);
        tr.find(".stock").val(stock);
        tr.find(".price").val(price);
        tr.find(".qty").val(1);
        tr.find(".total").val(tr.find(".qty").val() * tr.find(".price").val());
        calculate(0,0);
      
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

      $(document).on('change','.productidedit',function(e){  //this productid comes from the function above, passing the id and the name,  $output.='<option value"'.$row["pid"].'">'.$row["pname"].'</option>';
        var selectPro = $(e.currentTarget); // jQuery get current selection
        var pname = selectPro.find('option:selected').attr('data-pname');
        var stock = selectPro.find('option:selected').attr('data-stock');
        var price = selectPro.find('option:selected').attr('data-purchaseprice');
        var tr = selectPro.parent().parent();
        tr.find(".pname").val(pname);
        tr.find(".stock").val(stock);
        tr.find(".price").val(price);
        tr.find(".qty").val(1);
        tr.find(".total").val(tr.find(".qty").val() * tr.find(".price").val());
        calculate(0,0);
      
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
        calculate(0,0);
        $("#txtpaid").val(0);
      })

      $("#producttable").delegate(".qty","keyup change" ,function(){ // this function calculate the qty column
        var quantity = $(this);
        var tr=$(this).parent().parent();
        if((quantity.val()-0)>(tr.find(".stock").val()-0)){  // this value (quantity.val()-0) is when a user type a value, the other one is the quantity in the db
          swal("WARNING","This much of quantity is not available","warning");
          quantity.val(1);
          tr.find(".total").val(quantity.val() * tr.find(".price").val());
          calculate(0,0);
        }else{
          tr.find(".total").val(quantity.val() * tr.find(".price").val());
          calculate(0,0);
        }
      })

      function calculate(dis,paid){  //dis is when the user pass the discount amount on the text field
        var subtotal = 0;
        var tax = 0;
        var discount = dis;
        var net_total = 0;
        var paid_amt = paid;
        var due = 0;

        $(".total").each(function(){  // . = class
          subtotal = subtotal+($(this).val()*1);  //$(this) = $(".total")

        })

        tax = 0.05 * subtotal;
        net_total = tax + subtotal;
        net_total = net_total - discount;
        due = net_total - paid_amt;
        
        $("#txtsubtotal").val(subtotal.toFixed(2));  // # = ID | toFixed(2) = 2 decimal
        $("#txttax").val(tax.toFixed(2));
        $("#txttotal").val(net_total.toFixed(2));
        $("#txtdiscount").val(discount);
        $("#txtdue").val(due.toFixed(2));

      } //function calculate ends here
      $("#txtdiscount").keyup(function(){
        var discount = $(this).val();
        calculate(discount,0);
      });

      $("#txtpaid").keyup(function(){
        var paid = $(this).val();
        var discount = $("#txtdiscount").val();
        calculate(discount,paid);
      });


    });

  </script>


  <?php 
    include_once 'footer.php';
  ?>