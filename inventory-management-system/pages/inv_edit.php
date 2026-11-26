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

$sql = "SELECT DISTINCT a.ASSET_ID, a.CATEGORY_ID, t.CNAME, a.ASSET_TAG, a.HOSTNAME, a.SERIAL_NUMBER, 
                a.MODEL, a.CUSTODIAN, a.COSTCENTER_ID, a.DATE_STOCK_IN, a.SUPPLIER_ID, a.EMPLOYEE_ID 
        FROM asset a
        JOIN category t ON a.CATEGORY_ID = t.CATEGORY_ID 
        ORDER BY a.ASSET_ID ASC";
$result = mysqli_query($db, $sql) or die("Bad SQL: $sql");

$ast = "<select class='form-control' name='assetid' required>
        <option value=''>Select Asset ID</option>";

while ($row = mysqli_fetch_assoc($result)) {
    $ast .= "<option value='" . htmlspecialchars($row['ASSET_ID']) . "'>"
          . htmlspecialchars($row['ASSET_ID']) . " - " 
          . htmlspecialchars($row['CNAME']) . " - " 
          . htmlspecialchars($row['HOSTNAME']) 
          . "</option>";
}

$ast .= "</select>";

$sql2 = "SELECT DISTINCT MOVE_ID, MOVE_TYPE FROM move_type ORDER BY MOVE_ID ASC";
$result2 = mysqli_query($db, $sql2) or die("Bad SQL: $sql2");

$mov = "<select class='form-control' name='movetype' required>
        <option value=''>Select Move Type</option>";

while ($row = mysqli_fetch_assoc($result2)) {
    $mov .= "<option value='" . htmlspecialchars($row['MOVE_ID']) . "'>" . htmlspecialchars($row['MOVE_TYPE']) . "</option>";
}

$mov .= "</select>";

$sql3 = "SELECT DISTINCT EMPLOYEE_ID, FIRST_NAME, LAST_NAME, GENDER, EMAIL, PHONE_NUMBER, HIRED_DATE FROM employee order by EMPLOYEE_ID asc";
$result3 = mysqli_query($db, $sql3) or die ("Bad SQL: $sql3");

$emp = "<select class='form-control' name='employee' required>
        <option disabled selected hidden>Select Employee</option>";
  while ($row = mysqli_fetch_assoc($result3)) {
   $emp .= "<option value='".$row['EMPLOYEE_ID']."'>".$row['EMPLOYEE_ID']." - ".$row['FIRST_NAME']." ".$row['LAST_NAME']."</option>";
  }

$emp .= "</select>";

  $query = 'SELECT STOCK_ID, a.ASSET_ID, QUANTITY, o.MOVE_ID, START_DATE, END_DATE, e.EMPLOYEE_ID, LOCATION, REMARKS, TIMESTAMP FROM stock_movement m
  JOIN asset a ON m.ASSET_ID=a.ASSET_ID
  JOIN move_type o ON m.MOVE_ID=o.MOVE_ID
  JOIN employee e ON m.EMPLOYEE_ID=e.EMPLOYEE_ID
  WHERE STOCK_ID ='.$_GET['id'];
  $result = mysqli_query($db, $query) or die(mysqli_error($db));
    while($row = mysqli_fetch_array($result))
    {   
      $zz = $row['STOCK_ID'];
      $zzz = $row['QUANTITY'];
      $A = $row['START_DATE'];
      $B = $row['END_DATE'];
      $C = $row['LOCATION'];
      $D = $row['REMARKS'];
      $E = $row['TIMESTAMP'];
    }
      $id = $_GET['id'];
?>

  <center><div class="card shadow mb-4 col-xs-12 col-md-8 border-bottom-primary">
            <div class="card-header py-3">
              <h4 class="m-2 font-weight-bold text-primary">Edit Stock Movement</h4>
            </div>
            <a type="button" class="btn btn-primary bg-gradient-primary" href="inv_searchfrm.php?action=edit & id='<?php echo $zz; ?>'"><i class="fas fa-fw fa-flip-horizontal fa-share"></i> Back</a>
                
            <div class="card-body">

            <form role="form" method="post" action="inv_edit1.php">
              <input type="hidden" name="stockid" value="<?php echo $zz; ?>" />
              <div class="form-group row text-left text-warning">
                <div class="col-sm-3" style="padding-top: 5px;">
                 Stock ID:
                </div>
                <div class="col-sm-9">
                  <input class="form-control" value="<?php echo $zz; ?>" required>
                </div>
              </div>
              <div class="form-group row text-left text-warning">
                    <div class="col-sm-3" style="padding-top: 5px;">
                        Asset ID:
                    </div>
                    <div class="col-sm-9">
                        <?php
                    echo $ast;
                   ?>
                    </div>
              </div>
              <div class="form-group row text-left text-warning">
                  <div class="col-sm-3" style="padding-top: 5px;">Quantity:</div>
                  <div class="col-sm-9">
                      <input class="form-control" placeholder="Quantity" name="quantity" value="<?php echo $zzz; ?>" required>
                  </div>
              </div>
              <div class="form-group row text-left text-warning">
                    <div class="col-sm-3" style="padding-top: 5px;">
                        Move:
                    </div>
                    <div class="col-sm-9">
                        <?php
                    echo $mov;
                   ?>
                    </div>
              </div>
              <div class="form-group row text-left text-warning">
                      <div class="col-sm-3" style="padding-top: 5px;">
                          Start Date:
                      </div>
                      <div class="col-sm-9">
                          <div class="form-group">
                              <input type="text" onfocus="(this.type='date')" onblur="(this.type='text')" class="form-control" placeholder="Start Date" name="startdate" required>
                          </div>
                      </div>
                  </div>
                  <div class="form-group row text-left text-warning">
                      <div class="col-sm-3" style="padding-top: 5px;">
                          End Date:
                      </div>
                      <div class="col-sm-9">
                          <div class="form-group">
                              <input type="text" onfocus="(this.type='date')" onblur="(this.type='text')" class="form-control" placeholder="End Date" name="enddate" required>
                          </div>
                      </div>
                  </div>
              <div class="form-group row text-left text-warning">
                    <div class="col-sm-3" style="padding-top: 5px;">
                        Employee ID:
                    </div>
                    <div class="col-sm-9">
                        <?php
                    echo $emp;
                   ?>
                    </div>
              </div>
              <div class="form-group row text-left text-warning">
                <div class="col-sm-3" style="padding-top: 5px;">
                 Location:
                </div>
                <div class="col-sm-9">
                  <input class="form-control" placeholder="Location" name="location" value="<?php echo $C; ?>" required>
                </div>
              </div>
              <div class="form-group row text-left text-warning">
                <div class="col-sm-3" style="padding-top: 5px;">
                 Remarks:
                </div>
                <div class="col-sm-9">
                  <input class="form-control" placeholder="Remarks" name="remarks" value="<?php echo $D; ?>" required>
                </div>
              </div>
              <div class="form-group row text-left text-warning">
                <div class="col-sm-3" style="padding-top: 5px;">
                 Timestamp:
                </div>
                <div class="col-sm-9">
                  <input class="form-control" placeholder="Timestamp" name="timestamp" value="<?php echo $E; ?>" required readonly>
                </div>
              </div>
              <hr>

                <button type="submit" class="btn btn-warning btn-block"><i class="fa fa-edit fa-fw"></i>Update</button>    
              </form>  
            </div>
          </div></center>
          
<script>
function updateTimestamp() {
    const startDate = document.querySelector('input[name="startdate"]').value;
    const endDate = document.querySelector('input[name="enddate"]').value;

    if (startDate && endDate) {
        const startTimestamp = new Date(startDate).getTime();
        const endTimestamp = new Date(endDate).getTime();
        const timestamp = (startTimestamp + endTimestamp) / 2; // You can adjust this calculation as needed
        document.getElementById('timestamp').value = new Date(timestamp).toISOString().slice(0, 19).replace('T', ' ');
    }
}
</script>

<?php
include'../includes/footer.php';
?>