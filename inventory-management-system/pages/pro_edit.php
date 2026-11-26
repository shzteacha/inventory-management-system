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
$sql = "SELECT DISTINCT CNAME, CATEGORY_ID FROM category order by CNAME asc";
$result = mysqli_query($db, $sql) or die ("Bad SQL: $sql");

$opt = "<select class='form-control' name='category' required>
        <option value='' disabled selected hidden>Select Category</option>";
  while ($row = mysqli_fetch_assoc($result)) {
    $opt .= "<option value='".$row['CATEGORY_ID']."'>".$row['CNAME']."</option>";
  }

$opt .= "</select>";

$sql2 = "SELECT DISTINCT SUPPLIER_ID, COMPANY_NAME FROM supplier order by COMPANY_NAME asc";
$result2 = mysqli_query($db, $sql2) or die ("Bad SQL: $sql2");

$sup = "<select class='form-control' name='supplier'>
        <option disabled selected>Select Supplier</option>";
  while ($row = mysqli_fetch_assoc($result2)) {
    $sup .= "<option value='".$row['SUPPLIER_ID']."'>".$row['COMPANY_NAME']."</option>";
  }

$sup .= "</select>";

$sql3 = "SELECT DISTINCT COSTCENTER_ID, COST_CENTER, DEPARTMENT, LOCATION FROM cost_center order by DEPARTMENT asc";
$result3 = mysqli_query($db, $sql3) or die ("Bad SQL: $sql3");

$cost = "<select class='form-control' name='costcenter' required>
        <option disabled selected hidden>Select Cost Center</option>";
  while ($row = mysqli_fetch_assoc($result3)) {
    $cost .= "<option value='".$row['COSTCENTER_ID']."'>".$row['DEPARTMENT']."</option>";
  }

$cost .= "</select>";

$sql4 = "SELECT DISTINCT EMPLOYEE_ID, FIRST_NAME, LAST_NAME, GENDER, EMAIL, PHONE_NUMBER, HIRED_DATE FROM employee order by EMPLOYEE_ID asc";
$result4 = mysqli_query($db, $sql4) or die ("Bad SQL: $sql4");

$emp = "<select class='form-control' name='employee' required>
        <option disabled selected hidden>Select Employee</option>";
  while ($row = mysqli_fetch_assoc($result4)) {
   $emp .= "<option value='".$row['EMPLOYEE_ID']."'>".$row['EMPLOYEE_ID']." - ".$row['FIRST_NAME']." ".$row['LAST_NAME']."</option>";
  }

$emp .= "</select>";

$query = 'SELECT 
            ASSET_ID, ASSET_TAG,
            HOSTNAME,
            SERIAL_NUMBER,
            MODEL,
            CUSTODIAN,
            DATE_STOCK_IN, t.CNAME,
            s.COMPANY_NAME,
            c.DEPARTMENT,
            e.EMPLOYEE_ID
          FROM asset a
	  JOIN category t ON a.CATEGORY_ID = t.CATEGORY_ID
	  JOIN supplier s ON a.SUPPLIER_ID = s.SUPPLIER_ID
          JOIN cost_center c ON a.COSTCENTER_ID = c.COSTCENTER_ID
          JOIN employee e ON a.EMPLOYEE_ID = e.EMPLOYEE_ID
          WHERE ASSET_ID = ' . $_GET['id'];
  $result = mysqli_query($db, $query) or die(mysqli_error($db));
    while($row = mysqli_fetch_array($result))
    {   
      $zz = $row['ASSET_ID'];
      $y = $row['ASSET_TAG']; 
      $zzz = $row['HOSTNAME'];
      $A = $row['SERIAL_NUMBER'];
      $B = $row['MODEL'];
      $C = $row['CUSTODIAN'];
      $D = $row['DATE_STOCK_IN'];
    }
      $id = $_GET['id'];
?>

  <center>
      <div class="card shadow mb-4 col-xs-12 col-md-8 border-bottom-primary">
          <div class="card-header py-3">
              <h4 class="m-2 font-weight-bold text-primary">Edit Asset</h4>
          </div>
          <a href="product.php?action=add" type="button" class="btn btn-primary bg-gradient-primary">Back</a>
          <div class="card-body">

              <form role="form" method="post" action="pro_edit1.php">

                  <div class="form-group row text-left text-warning">
                      <div class="col-sm-3" style="padding-top: 5px;">
                          Asset ID:
                      </div>
                      <div class="col-sm-9">
                          <input class="form-control" placeholder="Asset ID" name="assetid" value="<?php echo $zz; ?>" required>
                      </div>
                  </div>
                  <div class="form-group row text-left text-warning">
                      <div class="col-sm-3" style="padding-top: 5px;">
                          Asset Tag:
                      </div>
                      <div class="col-sm-9">
                          <input class="form-control" placeholder="Asset Tag" name="assetag" value="<?php echo $y; ?>" required>
                      </div>
                  </div>
                  <div class="form-group row text-left text-warning">
                      <div class="col-sm-3" style="padding-top: 5px;">
                          Hostname:
                      </div>
                      <div class="col-sm-9">
                          <input class="form-control" placeholder="Hostname" name="hostname" value="<?php echo $zzz; ?>" required>
                      </div>
                  </div>
                  <div class="form-group row text-left text-warning">
                      <div class="col-sm-3" style="padding-top: 5px;">
                          Serial Number:
                      </div>
                      <div class="col-sm-9">
                          <input class="form-control" placeholder="Serial Number" name="serialnum" value="<?php echo $A; ?>" required>
                      </div>
                  </div>
                  <div class="form-group row text-left text-warning">
                      <div class="col-sm-3" style="padding-top: 5px;">
                          Model:
                      </div>
                      <div class="col-sm-9">
                          <input class="form-control" placeholder="Model" name="model" value="<?php echo $B; ?>" required>
                      </div>
                  </div>
                  <div class="form-group row text-left text-warning">
                      <div class="col-sm-3" style="padding-top: 5px;">
                          Custodian:
                      </div>
                      <div class="col-sm-9">
                          <input class="form-control" placeholder="Custodian" name="custodian" value="<?php echo $C; ?>" required>
                      </div>
                  </div>
                  <div class="form-group row text-left text-warning">
                      <div class="col-sm-3" style="padding-top: 5px;">
                          Date Stock In:
                      </div>
                      <div class="col-sm-9">
                          <div class="form-group">
                              <input type="text" onfocus="(this.type='date')" onblur="(this.type='text')" class="form-control" placeholder="Date Stock In" name="datestock" required>
                          </div>
                      </div>
                  </div>
                   <div class="form-group row text-left text-warning">
                      <div class="col-sm-3" style="padding-top: 5px;">
                          Cost Center:
                      </div>
                      <div class="col-sm-9">
                          <?php
                    echo $cost;
                   ?>
                      </div>
                  </div>
                  <div class="form-group row text-left text-warning">
                      <div class="col-sm-3" style="padding-top: 5px;">
                          Category:
                      </div>
                      <div class="col-sm-9">
                          <?php
                    echo $opt;
                   ?>
                      </div>
                  </div>
                   <div class="form-group row text-left text-warning">
                      <div class="col-sm-3" style="padding-top: 5px;">
                          Supplier:
                      </div>
                      <div class="col-sm-9">
                          <?php
                    echo $sup;
                   ?> 
                      </div>
                  </div>
                  <div class="form-group row text-left text-warning">
                      <div class="col-sm-3" style="padding-top: 5px;">
                          Employee:
                      </div>
                      <div class="col-sm-9">
                          <?php
                    echo $emp;
                   ?> 
                      </div>
                  </div>
                  
                  <hr>

                  <button type="submit" class="btn btn-warning btn-block"><i class="fa fa-edit fa-fw"></i>Update</button>
              </form>
          </div>
      </div>
  </center>
<?php
include'../includes/footer.php';
?>