<?php
include '../includes/connection.php';
include '../includes/sidebar.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['MEMBER_ID'])) {
    echo "<script>alert('Access Denied. Please log in.'); window.location = 'login.php';</script>";
    exit;
}

$memberId = $_SESSION['MEMBER_ID'];
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
        exit;
    }
}

$sql = "SELECT DISTINCT DEPARTMENT, COSTCENTER_ID FROM cost_center ORDER BY COSTCENTER_ID ASC";
$result = mysqli_query($db, $sql) or die("Bad SQL: $sql");

$opt = "<select class='form-control' name='costcenter_id' required>
        <option value=''>Select Cost Center</option>";

while ($row = mysqli_fetch_assoc($result)) {
    $opt .= "<option value='" . htmlspecialchars($row['COSTCENTER_ID']) . "'>" . htmlspecialchars($row['DEPARTMENT']) . "</option>";
}

$opt .= "</select>";
?>

<center>
    <div class="card shadow mb-4 col-xs-12 col-md-8 border-bottom-primary">
        <div class="card-header py-3">
            <h4 class="m-2 font-weight-bold text-primary">Add Employee</h4>
        </div>
        <a href="employee.php?action=add" type="button" class="btn btn-primary bg-gradient-primary">Back</a>
        <div class="card-body">
            <div class="table-responsive">
                <form role="form" method="post" action="emp_transac.php?action=add">
                    <div class="form-group">
                        <input class="form-control" placeholder="Employee ID" name="employee_id" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control" placeholder="First Name" name="firstname" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control" placeholder="Last Name" name="lastname" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control" placeholder="Email" name="email" type="email" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control" placeholder="Phone Number" name="phonenumber" required>
                    </div>
                    <div class="form-group">
                        <?php echo $opt; ?>
                    </div>
                    <div class="form-group">
                        <input type="date" id="FromDate" name="hireddate" class="form-control" required />
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
