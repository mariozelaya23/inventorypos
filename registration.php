<!-- this is the header -->
<?php
  include_once 'connectdb.php';
  session_start();

  if($_SESSION['useremail']==""){   //this username comes from the variable in index.php, we are restricting the access
    header('location:index.php');
  }

  if($_SESSION['role']=="Admin"){
    include_once'header.php';
  }else{
    include_once'headeruser.php';
  }


  //1- when click on save button we get out values in the textboxes from user into variables
  if(isset($_POST['btnsave'])){
    $name_txt=$_POST['txtname'];
    $email_txt=$_POST['txtemail'];
    $password_txt=$_POST['txtpassword'];
    $role_txt=$_POST['selectrole'];

    //echo $name_txt.' '.$email_txt.' '.$password_txt.' '.$role_txt;

    //2- using of select query we insert into the database
    $insert = $pdo->prepare("INSERT INTO tbl_user (username,useremail,password,role ) 
    VALUES(:name,:email,:pass,:role)"); // using placeholders
    
    $insert->bindParam(':name', $name_txt);  //passing placeholders into variables
    $insert->bindParam(':email', $email_txt);
    $insert->bindParam(':pass', $password_txt);
    $insert->bindParam(':role', $role_txt);

    if($insert->execute()){
      echo '<script type="text/javascript">
      jQuery(function validation(){

        swal({
          title: "Good Job",
          text: "'.$role_txt.' inserted",
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

?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        User Registration
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
      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">Registration Form</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" action="" method="POST">
          <div class="box-body">
            <!-- because in bootstrap the page is diveded in 12 columns, I'm going to devide this 12 columns in 4 colums on left and 8 columns on right -->
            <div class="col-md-4"> <!-- 4 columns on the left side -->  <!-- FORM -->
              <div class="form-group">
                  <label>Name</label>
                  <input type="text" class="form-control" placeholder="Enter name" name="txtname" required>
              </div>
              <div class="form-group">
                <label>Email address</label>
                <input type="email" class="form-control" placeholder="Enter email" name="txtemail" required>
              </div>
              <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control" placeholder="Password" name="txtpassword" required>
              </div>  
              <div class="form-group">
                  <label>Role</label>
                  <select class="form-control" name="selectrole" required>
                    <option value="" disabled selected>Select role</option>
                    <option>User</option>
                    <option>Admin</option>
                  </select>
                </div>
                <button type="submit" class="btn btn-info" name="btnsave">Save</button>
            </div><!-- /. FORM -->
            <div class="col-md-8"> <!-- 8 columns on the right side -->  <!-- TABLE -->
              <table class="table table-striped">
                <thead> <!-- table heading -->  
                  <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Role</th>
                    <th>Delete</th>
                  </tr>
                </thead>
                <tbody> <!-- table body --> 
                  <?php
                    $select=$pdo->prepare("SELECT * FROM tbl_user ORDER BY userid");
                    $select->execute();
                    
                    while($row=$select->fetch(PDO::FETCH_OBJ)){  //using while to fetch all the data from the database // using FETCH_OBJ because I'm fetching each fild of the database
                      echo '
                        <tr>
                        <td>'.$row->userid.'</td>
                        <td>'.$row->username.'</td>
                        <td>'.$row->useremail.'</td>
                        <td>'.$row->password.'</td>
                        <td>'.$row->role.'</td>
                        <td></td>
                        </tr>
                      ';
                    }
                  ?>
                </tbody>
              </table>
            </div> 
          </div>
          <!-- /.box-body -->

          <div class="box-footer">
            
          </div>
        </form>
      </div>
      <!-- /.box -->    

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php 
    include_once 'footer.php';
  ?>