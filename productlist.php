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
          <div style="overflow-x:auto">
            <table id="producttable" class="table table-striped">
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
                      <td><img src="productimages/'.$row->pimage.'" class="img-rounded" width="40px" height="40px"></td>
                      <td>
                        <a href="viewproduct.php?id='.$row->pid.'" class="btn btn-success" role="button" name="btndelete"><span class="glyphicon glyphicon-eye-open" style="color=#ffffff" data-toggle="tooltip" title="View Product"></span></a>
                      </td>
                      <td>
                        <a href="editproduct.php?id='.$row->pid.'" class="btn btn-info" role="button" name="btndelete"><span class="glyphicon glyphicon-edit" style="color=#ffffff" data-toggle="tooltip" title="Edit Product"></span></a>
                      </td>
                      <td>
                        <button id='.$row->pid.' class="btn btn-danger btndelete" name="btndelete"><span class="glyphicon glyphicon-trash" style="color=#ffffff" data-toggle="tooltip" title="Delete Product"></span></button>
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
  $('#producttable').DataTable({
    "order":[[0,"desc"]]
  });
  } );
</script>

<script>
  $(document).ready( function () {
    $('[data-toggle="tooltip"]').tooltip();
  } );
</script>

<!-- DELETE BUTTON AJAX CODE -->
<script>
  $(document).ready(function(){
    $('.btndelete').click(function(){
      //alert('Test');

      var tdh = $(this);
      var id = $(this).attr("id");
      //alert(id);
      //sweet alert
      swal({
        title: "Do you want to delete the product?",
        text: "Once deleted, you can not recover this product!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) { //ajax code
          $.ajax({
            url:'productdelete.php',
            type:'post',
            data:{
              pidd:id
            },
            success:function(data){
              tdh.parents('tr').hide();
            }
          })
          swal("Your product has been deleted!", {
            icon: "success",
          });
        } else {
          swal("Your product is safe!");
        }
      });

    });
  
  });

</script>



<?php 
    include_once 'footer.php';
?>