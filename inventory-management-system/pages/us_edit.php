<?php
include '../includes/connection.php';
include '../includes/sidebar.php';

// Restrict access for User type
$query = 'SELECT ID, t.TYPE FROM users u 
          JOIN type t ON t.TYPE_ID = u.TYPE_ID 
          WHERE ID = ' . $_SESSION['MEMBER_ID'];
$result = mysqli_query($db, $query) or die(mysqli_error($db));

while ($row = mysqli_fetch_assoc($result)) {
    if ($row['TYPE'] == 'User') {
        echo '<script type="text/javascript">
                alert("Restricted Page! You will be redirected to POS");
                window.location = "pos.php";
              </script>';
        exit();
    }
}

// Fetch user data to edit
$id = $_GET['id'];
$query = "SELECT u.ID, u.EMPLOYEE_ID, u.USERNAME, e.FIRST_NAME, e.LAST_NAME, 
                 e.GENDER, e.EMAIL, e.PHONE_NUMBER, c.DEPARTMENT, c.COSTCENTER_ID, 
                 t.TYPE, u.TYPE_ID
          FROM users u
          JOIN employee e ON u.EMPLOYEE_ID = e.EMPLOYEE_ID
          JOIN cost_center c ON u.COSTCENTER_ID = c.COSTCENTER_ID
          JOIN type t ON u.TYPE_ID = t.TYPE_ID
          WHERE u.ID = $id";
$result = mysqli_query($db, $query) or die(mysqli_error($db));

$user = mysqli_fetch_assoc($result);
?>

<!-- Form starts -->
<center>
<div class="card shadow mb-4 col-xs-12 col-md-8 border-bottom-primary">
    <div class="card-header py-3">
        <h4 class="m-2 font-weight-bold text-primary">Edit User Account</h4>
    </div>
    <a type="button" class="btn btn-primary bg-gradient-primary btn-block" href="user.php"> 
        <i class="fas fa-flip-horizontal fa-fw fa-share"></i> Back 
    </a>
    <div class="card-body">
        <form role="form" method="post" action="us_edit1.php">
            <input type="hidden" name="id" value="<?php echo $user['ID']; ?>" />
            
            <!-- Employee ID -->
            <div class="form-group">
                <label>Employee ID:</label>
                <input class="form-control" name="empid" value="<?php echo $user['EMPLOYEE_ID']; ?>" readonly>
            </div>

            <!-- Username -->
            <div class="form-group">
                <label>Username:</label>
                <input class="form-control" name="username" value="<?php echo $user['USERNAME']; ?>" required>
            </div>

            <!-- Password -->
            <div class="form-group">
                <label>Password:</label>
                <input type="password" class="form-control" name="password" placeholder="Enter new password" required>
            </div>
            
            <button type="submit" class="btn btn-warning btn-block"><i class="fa fa-edit fa-fw"></i>Update</button>
        </form>
    </div>
</div>
</center>

<?php
include '../includes/footer.php';
?>
