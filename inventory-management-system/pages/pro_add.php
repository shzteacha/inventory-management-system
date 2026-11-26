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

$opt = "<select class='form-control' name='category'>
        <option disabled selected>Select Category</option>";
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

?>
          <center><div class="card shadow mb-4 col-xs-12 col-md-8 border-bottom-primary">
            <div class="card-header py-3">
              <h4 class="m-2 font-weight-bold text-primary">Add Asset</h4>
            </div>
            <a href="product.php?action=add" type="button" class="btn btn-primary bg-gradient-primary">Back</a>
            <div class="card-body">
                      <div class="table-responsive">



                        <form role="form" method="post" action="pro_transac.php?action=add">
                            <div class="form-group">
                                <input class="form-control" placeholder="Asset ID" name="assetid" required>
                            </div>
                            <div class="form-group">
                                <?php
                                echo $opt;
                              ?>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Asset Tag" name="assetag" required>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Hostname" name="hostname" required>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Serial Number" name="serialnum" required>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Model" name="model" required>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Custodian" name="custodian" required>
                            </div>
                            <div class="form-group">
                                <?php
                                echo $cost;
                                ?>
                            </div>

                            <div class="form-group">
                                <?php
                                echo $sup;
                              ?>
                            </div>
                            <div class="form-group">
                                <?php
                                echo $emp;
                              ?>
                            </div>
                            <div class="form-group">
                                <input type="datet" class="form-control" placeholder="Date Stock In" name="datestock" required>
                            </div>
                            <hr>
                            <button type="submit" class="btn btn-success btn-block"><i class="fa fa-check fa-fw"></i>Save</button>
                            <button type="reset" class="btn btn-danger btn-block"><i class="fa fa-times fa-fw"></i>Reset</button>

                        </form>







                        </div>
                        </div>
                        </div>
                        </center>
        
<?php
include '../includes/footer.php';
?>
