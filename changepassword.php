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

  //1- when click on update password button we get out values in the textboxes from user into variables

  if(isset($_POST['btnupdate'])){
    $oldpassword_txt=$_POST['txtoldpass'];
    $newpassword_txt=$_POST['txtnewpass'];
    $confpassword_txt=$_POST['txtconfpass'];

    //echo $oldpassword_txt."-".$newpassword_txt."-".$confpassword_txt;

    //2- using of select query we get out database record according to useremail
    $email = $_SESSION['useremail'];
    $select = $pdo->prepare("SELECT * FROM tbl_user where useremail='$email'");
    $select->execute();
    $row = $select->fetch(PDO::FETCH_ASSOC);

    $useremail_db = $row['useremail'];
    $password_db = $row['password'];

    //3- we compare userinput and database values
    if($oldpassword_txt==$password_db){
      if($newpassword_txt==$confpassword_txt){
        //4- if values match then we run update query
        $update=$pdo->prepare("UPDATE tbl_user SET password=:pass WHERE useremail=:email");
        $update->bindParam(':pass', $confpassword_txt);
        $update->bindParam(':email', $email);

        if($update->execute()){
          echo '<script type="text/javascript">
          jQuery(function validation(){
    
            swal({
              title: "Good Job",
              text: "Your password has been changed successfully",
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
      }else{
        echo '<script type="text/javascript">
        jQuery(function validation(){
  
          swal({
            title: "Oops!",
            text: "Your new password and confirm password dont match",
            icon: "warning",
            button: "Ok",
          });
  
        })
        </script>';
      }
    }else{
      echo '<script type="text/javascript">
      jQuery(function validation(){

        swal({
          title: "Warning",
          text: "Your Password is wrong please fill the right password",
          icon: "warning",
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
      <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Change password form</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="" method="POST">
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputPassword1">Old Password</label>
                  <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Password" name="txtoldpass" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">New Password</label>
                  <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="txtnewpass" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Confirm Password</label>
                  <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="txtconfpass" required>
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary" name="btnupdate">Submit</button>
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