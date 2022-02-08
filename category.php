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


  //*********** ADD BUTTON STARTS HERE ***********/
  if(isset($_POST['btnsave'])){
    $category = $_POST['txtcategory'];
    //echo $category;

    if(empty($category)){
      $error ='<script type="text/javascript">
      jQuery(function validation(){
  
        swal({
          title: "Field Empty",
          text: "Please type a category!",
          icon: "error",
          button: "Ok",
        });
  
      })
      </script>';
      echo $error;
    }

    if(!isset($error)){
      $insert = $pdo->prepare("INSERT INTO tbl_category(category) VALUES(:category)");
      $insert->bindParam(':category',$category);

      if($insert->execute()){
        echo '<script type="text/javascript">
        jQuery(function validation(){
    
          swal({
            title: "Added!!",
            text: "Category has been inserted",
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
            text: "Query Fail",
            icon: "error",
            button: "Ok",
          });
  
        })
        </script>';
      }
    }
  }//***********ADD BUTTON ENDS HERE ***********/

  //*********** UPDATE BUTTON STARTS HERE ***********/
  if(isset($_POST['btnupdate'])){
    $category = $_POST['txtcategory'];
    $id = $_POST['txtid'];

    if(empty($category)){
      $errorupdate ='<script type="text/javascript">
      jQuery(function validation(){
  
        swal({
          title: "Field Empty",
          text: "Please type a category!",
          icon: "error",
          button: "Ok",
        });
  
      })
      </script>';
      echo $errorupdate;
    }

    if(!isset($errorupdate)){  //if user type something
      $update = $pdo->prepare("UPDATE tbl_category SET category=:category WHERE catid=".$id);
      //$update = $pdo->prepare("UPDATE tbl_category SET category='$category' WHERE catid=".$id);  (this is without placeholder)
      //if you use the code from above (commented one), comment the line beneth this comment, you dont need it
      //but the recommended way to code this, is the one that is right know to prevent sql injection
      $update->bindParam(':category',$category);

      if($update->execute()){
        echo '<script type="text/javascript">
        jQuery(function validation(){
    
          swal({
            title: "Updated!",
            text: "Category has been updated",
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
            text: "Query Fail",
            icon: "error",
            button: "Ok",
          });
  
        })
        </script>';
      }
    }


  }//***********UPDATE BUTTON ENDS HERE ***********/


  //*********** DELETE BUTTON STARTS HERE ***********/
  if(isset($_POST['btndelete'])){
    $delete = $pdo->prepare("DELETE FROM tbl_category WHERE catid=".$_POST['btndelete']);
    
    if($delete->execute()){
      echo '<script type="text/javascript">
      jQuery(function validation(){
  
        swal({
          title: "Deleted!",
          text: "Category has been deleted",
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
          text: "Category has not been deleted",
          icon: "error",
          button: "Ok",
        });

      })
      </script>';
    }
  }//***********DELETE BUTTON ENDS HERE ***********/

?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Category
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

      
            <!-- general form elements -->
      <div class="box box-warning">
        <div class="box-header with-border">
          <h3 class="box-title">Category Form</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <!-- because in bootstrap the page is diveded in 12 columns, I'm going to devide this 12 columns in 4 colums on left and 8 columns on right -->
          <!-- form start -->
          <form role="form" action="" method="POST">
            <?php 
              if(isset($_POST['btnedit'])){
                  $select = $pdo->prepare("SELECT * FROM tbl_category WHERE catid=".$_POST['btnedit']);
                  $select->execute();
                  if($select){
                    $row=$select->fetch(PDO::FETCH_OBJ);
                    //HERE ARE TWO FORMS
                    echo'
                      <div class="col-md-4"> <!-- 4 columns on the left side -->  <!-- FORM -->
                        <div class="form-group">
                            <label>Category</label>
                            <input type="hidden" class="form-control" value="'.$row->catid.'" placeholder="Enter category" name="txtid">
                            <input type="text" class="form-control" value="'.$row->category.'" placeholder="Enter category" name="txtcategory">
                        </div>
                        <button type="submit" class="btn btn-info" name="btnupdate">Update</button>
                      </div><!-- /. FORM -->
                    ';
                  }
              }else{
                echo'
                  <div class="col-md-4"> <!-- 4 columns on the left side -->  <!-- FORM -->
                    <div class="form-group">
                        <label>Category</label>
                        <input type="text" class="form-control" placeholder="Enter category" name="txtcategory">
                    </div>
                    <button type="submit" class="btn btn-warning" name="btnsave">Save</button>
                  </div><!-- /. FORM -->
                ';
              }
            
            ?>

            <div class="col-md-8"> <!-- 8 columns on the right side -->  <!-- TABLE -->
              <table id="tablecategory" class="table table-striped">
                <thead> <!-- table heading -->  
                  <tr>
                    <th>#</th>
                    <th>Category</th>
                    <th>Edit</th>
                    <th>Delete</th>
                  </tr>
                </thead>
                <tbody> <!-- table body -->
                  <?php
                    $select = $pdo->prepare("SELECT * FROM tbl_category order by catid");
                    $select->execute();
                    while($row=$select->fetch(PDO::FETCH_OBJ)){
                      echo '
                        <tr>
                          <td>'.$row->catid.'</td>
                          <td>'.$row->category.'</td>
                          <td>
                            <button type="submit" value="'.$row->catid.'" class="btn btn-success" name="btnedit">Edit</button>
                          </td>
                          <td>
                            <button type="submit" value="'.$row->catid.'" class="btn btn-danger" name="btndelete">Delete</button>
                          </td>
                        </tr>
                      ';
                    }

                  ?>
                </tbody>
              </table>
            </div>
          </form> 
        </div>
          <!-- /.box-body -->

          <div class="box-footer">
            
          </div>
      </div>




    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Call this single function -->
  <script>
    $(document).ready( function () {
    $('#tablecategory').DataTable();
    } );
  </script>

  <?php 
    include_once 'footer.php';
  ?>