<?php
include'../includes/connection.php';
include'../includes/sidebar.php';
  $query = 'SELECT ID, t.TYPE
            FROM users u
            JOIN type t ON t.TYPE_ID=u.TYPE_ID WHERE ID = '.$_SESSION['MEMBER_ID'].'';
  $result = mysqli_query($db, $query) or die (mysqli_error($db));
  
  while ($row = mysqli_fetch_assoc($result)) {
            $Aa = $row['TYPE'];
                   
  if ($Aa=='User'){
?>
  <script type="text/javascript">
    //then it will be redirected
    alert("Restricted Page! You will be redirected to POS");
    window.location = "pos.php";
  </script>
<?php
  }           
}  
$sql = "SELECT DISTINCT TYPE, TYPE_ID FROM type order by TYPE_ID asc";
$result = mysqli_query($db, $sql) or die ("Bad SQL: $sql");

$opt = "<select class='form-control' name='type'>
        <option>Select Type</option>";
  while ($row = mysqli_fetch_assoc($result)) {
    $opt .= "<option value='".$row['TYPE_ID']."'>".$row['TYPE']."</option>";
  }

$opt .= "</select>";

$sql2 = "SELECT DISTINCT EMPLOYEE_ID, FIRST_NAME, LAST_NAME, GENDER, EMAIL, PHONE_NUMBER, COSTCENTER_ID, HIRED_DATE FROM employee order by EMPLOYEE_ID asc";
$result2 = mysqli_query($db, $sql2) or die ("Bad SQL: $sql2");

$emp = "<select class='form-control' name='empid'>
        <option>Select Employee ID</option>";
  while ($row = mysqli_fetch_assoc($result2)) {
    $emp .= "<option value='".$row['EMPLOYEE_ID']."'>".$row['FIRST_NAME']."</option>";
  }

$emp .= "</select>";

$sql3 = "SELECT DISTINCT COSTCENTER_ID, COST_CENTER, DEPARTMENT, LOCATION FROM cost_center order by COSTCENTER_ID asc";
$result3 = mysqli_query($db, $sql3) or die ("Bad SQL: $sql3");

$cost = "<select class='form-control' name='costid'>
        <option>Select Cost Center</option>";
  while ($row = mysqli_fetch_assoc($result3)) {
    $cost .= "<option value='".$row['COSTCENTER_ID']."'>".$row['COST_CENTER']." - ".$row['DEPARTMENT']."</option>";
}

$cost .= "</select>";
?>

          <center><div class="card shadow mb-4 col-xs-12 col-md-8 border-bottom-primary">
            <div class="card-header py-3">
              <h4 class="m-2 font-weight-bold text-primary">Add User</h4>
            </div>
            <a href="user.php?action=add" type="button" class="btn btn-primary bg-gradient-primary">Back</a>
            <div class="card-body">
              <div class="table-responsive">
                        <form role="form" method="post" action="adm_transac.php?action=add">
                            
                            <div class="form-group">
                              <?php
                                echo $emp;
                              ?>
                            </div>
                            <div class="form-group">
                              <input class="form-control" placeholder="Username" name="username" required>
                            </div>
                            <div class="form-group">
                              <input class="form-control" placeholder="Password" name="password" required>
                            </div>
                            <div class="form-group">
                              <?php
                                echo $cost;
                              ?>
                            </div>
                            <div class="form-group">
                              <?php
                                echo $opt;
                              ?>
                            </div>
                            <hr>
                            <button type="submit" class="btn btn-success btn-block"><i class="fa fa-check fa-fw"></i>Save</button>
                            <button type="reset" class="btn btn-danger btn-block"><i class="fa fa-times fa-fw"></i>Reset</button>
                            
                        </form>  
                      </div>
            </div>
          </div></center>
        
<?php
include '../includes/footer.php';
?>
