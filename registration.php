<!-- this is the header -->
<?php
  include_once 'connectdb.php';
  session_start();

  include_once'header.php';
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
                  <input type="text" class="form-control" placeholder="Enter name" name="txt_name">
              </div>
              <div class="form-group">
                <label>Email address</label>
                <input type="email" class="form-control" placeholder="Enter email" name="txt_email">
              </div>
              <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control" placeholder="Password" name="txt_password">
              </div>  
              <div class="form-group">
                  <label>Role</label>
                  <select class="form-control" name="select_role">
                    <option value="" disabled selected>Select role</option>
                    <option>User</option>
                    <option>Admin</option>
                  </select>
                </div>
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
            <button type="submit" class="btn btn-info">Save</button>
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