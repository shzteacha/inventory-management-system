<?php
include '../includes/connection.php';
include '../includes/sidebar.php';

// Ensure the session is started to access SESSION variables
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if MEMBER_ID is set in the session
if (!isset($_SESSION['MEMBER_ID'])) {
    echo "<script>alert('Access Denied. Please log in.'); window.location = 'login.php';</script>";
    exit;
}

$memberId = $_SESSION['MEMBER_ID'];

// Use prepared statement for better security
$query = 'SELECT ID, t.TYPE
          FROM users u
          JOIN type t ON t.TYPE_ID = u.TYPE_ID
          WHERE ID = ?';
$stmt = $db->prepare($query);
$stmt->bind_param('i', $memberId);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $Aa = $row['TYPE'];

    if ($Aa == 'User') {
        echo "<script type='text/javascript'>
                alert('Restricted Page! You will be redirected to POS');
                window.location = 'pos.php';
              </script>";
        exit; // Stop further script execution after the redirect
    }
}

// Prepare the SQL statement to select cost centers

$sql = "SELECT DISTINCT a.ASSET_ID, a.CATEGORY_ID, a.ASSET_TAG, t.CNAME, a.HOSTNAME, a.SERIAL_NUMBER, 
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
?>

<center>
    <div class="card shadow mb-4 col-xs-12 col-md-8 border-bottom-primary">
        <div class="card-header py-3">
            <h4 class="m-2 font-weight-bold text-primary">Add Stock Movement</h4>
        </div>
        <a href="inventory.php" type="button" class="btn btn-primary bg-gradient-primary">Back</a>
        <div class="card-body"> 
            <div class="table-responsive">
                <form role="form" method="post" action="inv_transac.php?action=add">
                    <div class="form-group">
                        <input class="form-control" placeholder="Stock ID" name="stockid" required>
                    </div>
                    <div class="form-group">
                        <?php echo $ast; ?>
                    </div>
                    <div class="form-group">
                        <input class="form-control" placeholder="Quantity" name="quantity" required>
                    </div>
                    <div class="form-group">
                        <?php echo $mov; ?>
                    </div>
                    <div class="form-group">
                        <input type="date" id="startdate" name="startdate" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <input type="date" id="enddate" name="enddate" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <?php echo $emp; ?>
                    </div>
                    <div class="form-group">
                        <input class="form-control" placeholder="Location" name="location" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control" placeholder="Remarks" name="remarks" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control" placeholder="Timestamp" name="timestamp" required>
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


<!-- HOW TO PRINT YOUR VALUE JUST FOR CHECKINGGGGG
<script language='JavaScript'>
function getwords()
{
textbox = document.getElementById('FromDate');
if (textbox.value != "")
document.write("You entered: " + textbox.value)
else
alert("No word has been entered!")
}
</script>
<input type="button" onclick="getwords()" value="Enter" /> -->
