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
//OPTION; TAB;
$sql = "SELECT DISTINCT DEPARTMENT, COSTCENTER_ID FROM cost_center ORDER BY COSTCENTER_ID ASC";
$result = mysqli_query($db, $sql) or die("Bad SQL: $sql");

$opt = "<select class='form-control' name='costcenter_id' required>
        <option value=''>Select Cost Center</option>";

while ($row = mysqli_fetch_assoc($result)) {
    $selected = ($row['DEPARTMENT'] == $opt) ? "selected" : ""; // Preselect the current department
    $opt .= "<option value='" . htmlspecialchars($row['COSTCENTER_ID']) . "' $selected>" . htmlspecialchars($row['DEPARTMENT']) . "</option>";
}

$opt .= "</select>";

         $id = mysqli_real_escape_string($db, $_GET['id']); // Sanitize the input
         $query = "SELECT EMPLOYEE_ID, FIRST_NAME, LAST_NAME, GENDER, EMAIL, PHONE_NUMBER, c.DEPARTMENT, HIRED_DATE
         FROM employee e
         JOIN cost_center c ON c.COSTCENTER_ID = e.COSTCENTER_ID
         WHERE EMPLOYEE_ID = '$id'";

         $result = mysqli_query($db, $query) or die(mysqli_error($db));

         if ($row = mysqli_fetch_assoc($result)) {
    $emp_id = $row['EMPLOYEE_ID'];
    $fname = $row['FIRST_NAME'];
    $lname = $row['LAST_NAME'];
    $gender = $row['GENDER'];
    $email = $row['EMAIL'];
    $phone = $row['PHONE_NUMBER'];
    $dept = $row['DEPARTMENT'];
    $hdate = $row['HIRED_DATE'];
} else {
    echo "Error: Employee not found.";
    exit;
}
  
      ?>
  <center><div class="card shadow mb-4 col-xs-12 col-md-8 border-bottom-primary">
            <div class="card-header py-3">
              <h4 class="m-2 font-weight-bold text-primary">Edit Employee</h4>
            </div><a  type="button" class="btn btn-primary bg-gradient-primary btn-block" href="employee.php"> <i class="fas fa-flip-horizontal fa-fw fa-share"></i> Back </a>
            <div class="card-body">
          
            <form role="form" method="post" action="emp_edit1.php">
              <input type="hidden" name="old_employee_id" value="<?php echo $emp_id; ?>" />

              <div class="form-group row text-left text-warning">
                <div class="col-sm-3" style="padding-top: 5px;">
                 Employee ID:
                </div>
                <div class="col-sm-9">
                  <input class="form-control" placeholder="Employee ID" name="employee_id" value="<?php echo $emp_id; ?>" required>
                </div>
              </div>
              <div class="form-group row text-left text-warning">
                <div class="col-sm-3" style="padding-top: 5px;">
                 First Name:
                </div>
                <div class="col-sm-9">
                  <input class="form-control" placeholder="First Name" name="firstname" value="<?php echo $fname; ?>" required>
                </div>
              </div>
              <div class="form-group row text-left text-warning">
                <div class="col-sm-3" style="padding-top: 5px;">
                 Last Name:
                </div>
                <div class="col-sm-9">
                  <input class="form-control" placeholder="Last Name" name="lastname" value="<?php echo $lname; ?>" required>
                </div>
              </div>
              <div class="form-group row text-left text-warning">
                <div class="col-sm-3" style="padding-top: 5px;">
                 Gender:
                </div>
                <div class="col-sm-9">
                  <select class='form-control' name='gender' required>
                    <option value="" disabled selected hidden>Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                  </select>
                </div>
              </div>
              <div class="form-group row text-left text-warning">
                <div class="col-sm-3" style="padding-top: 5px;">
                 Email:
                </div>
                <div class="col-sm-9">
                  <input class="form-control" placeholder="Email" name="email" value="<?php echo $email; ?>" required>
                </div>
              </div>
              <div class="form-group row text-left text-warning">
                <div class="col-sm-3" style="padding-top: 5px;">
                 Contact #:
                </div>
                <div class="col-sm-9">
                   <input class="form-control" placeholder="Phone Number" name="phone" value="<?php echo $phone; ?>" required>
                </div>
              </div>
              <div class="form-group row text-left text-warning">
                <div class="col-sm-3" style="padding-top: 5px;">
                 Department:
                </div>
                <div class="col-sm-9">
                 <div class="form-group">
                        <?php echo $opt; ?>
                    </div>
              </div>
            </div>
              <div class="form-group row text-left text-warning">
                <div class="col-sm-3" style="padding-top: 5px;">
                 Hired Date:
                </div>
                <div class="col-sm-9">
                  <input placeholder="Hired Date" type="date" id="FromDate" name="hireddate" value="<?php echo $hdate; ?>" class="form-control" required>
                </div>
              </div>

              <hr>

                <button type="submit" class="btn btn-warning btn-block"><i class="fa fa-edit fa-fw"></i>Update</button>    
              </form>  
                    
            </div>
          </div></center>

<?php
include'../includes/footer.php';
?>
