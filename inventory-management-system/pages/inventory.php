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
    alert("Re  stricted Page! You will be redirected to POS");
    window.location = "pos.php";
  </script>
<?php
  }           
}

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
<div class="card shadow mb-4">
    <div class="card-header py-3">
    <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h4 class="m-2 font-weight-bold text-primary">Stock Movement&nbsp;<a href="#" data-toggle="modal" data-target="#aModal" type="button" class="btn btn-primary bg-gradient-primary" style="border-radius: 0px;"><i class="fas fa-fw fa-plus"></i></a></h4>

                <a href="generate_stockmove.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mr-2"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
            </div>

            <div style="display: flex; align-items: center;">
                
                    <form action="import_stockmove.php" method="post" enctype="multipart/form-data">
                        <div style="border: 1px solid #cac9c9; padding: 5px; border-radius: 4px;"><input type="file" name="file" accept=".csv" required></div>
                        <button type="submit" name="import_asset" class="btn btn-sm btn-primary mt-2 d-block" style="margin-left: auto;">Import File</button>
                    </form>
            </div>
            
        </div>
        <!-- <div style="display: flex; justify-content: space-between; align-items: center;">
            <h4 class="m-2 font-weight-bold text-primary">Stock Movement&nbsp;<a href="#" data-toggle="modal" data-target="#aModal" type="button" class="btn btn-primary bg-gradient-primary" style="border-radius: 0px;"><i class="fas fa-fw fa-plus"></i></a> </h4>
            <a href="generate_file.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
        </div>
        <form action="import_file.php" method="post" enctype="multipart/form-data">
        <div style="border: 1px solid #cac9c9; padding: 5px; border-radius: 4px;"><input type="file" name="file" accept=".csv" required></div>
          <button type="submit" name="import_asset" class="btn btn-sm btn-primary mt-2 d-block" style="margin-left: auto;">Import File</button>
            </form>
    </div>
    
    <div style="display: flex; align-items: center;"> -->
                
    <!-- <div style="display: flex; justify-content: space-between; align-items: center;">
        <a href="generate_file.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
        <form action="import_file.php" method="post" enctype="multipart/form-data">
            <input type="file" name="file" accept=".csv" required>
            <button type="submit" name="import" class="btn btn-success">Import File</button>
        </form>
    </div> -->
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Stock ID</th>
                        <th>Asset ID</th>
                        <th>Quantity</th>
                        <th>Move</th>
                        <th>Location</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

<?php                  
    $query = 'SELECT STOCK_ID, a.ASSET_ID, QUANTITY, o.MOVE_TYPE, START_DATE, END_DATE, e.EMPLOYEE_ID, LOCATION, REMARKS, TIMESTAMP
          FROM stock_movement m
          JOIN asset a ON m.ASSET_ID = a.ASSET_ID
          JOIN move_type o ON m.MOVE_ID = o.MOVE_ID
          JOIN employee e ON m.EMPLOYEE_ID = e.EMPLOYEE_ID
          GROUP BY STOCK_ID, a.ASSET_ID, QUANTITY, o.MOVE_TYPE, START_DATE, END_DATE, e.EMPLOYEE_ID, LOCATION, REMARKS, TIMESTAMP';

        $result = mysqli_query($db, $query) or die (mysqli_error($db));
      
            while ($row = mysqli_fetch_assoc($result)) {
                                 
                echo '<tr>'; 
                echo '<td>'. $row['STOCK_ID'].'</td>';
                echo '<td>'. $row['ASSET_ID'].'</td>';
                echo '<td>'. $row['QUANTITY'].'</td>';
                echo '<td>'. 
                $row['MOVE_TYPE'].'</td>';
                echo '<td>'. 
                $row['LOCATION'].'</td>';
                echo '<td align="right">
                      <div class="btn-group">
                            <a type="button" class="btn btn-primary bg-gradient-primary" href="inv_searchfrm.php?action=edit & id='.$row['STOCK_ID'] . '"><i class="fas fa-fw fa-list-alt"></i> Details</a>
                            <div class="btn-group">
                                <a type="button" class="btn btn-primary bg-gradient-primary dropdown no-arrow" data-toggle="dropdown" style="color:white;">
                                    ... <span class="caret"></span></a>
                                <ul class="dropdown-menu text-center" role="menu">
                                    <li>
                                        <a type="button" class="btn btn-warning bg-gradient-warning btn-block" style="border-radius: 0px;" href="inv_edit.php?action=edit & id='.$row['STOCK_ID']. '">
                                            <i class="fas fa-fw fa-edit"></i> Edit
                                        </a>
                                    </li>
                                    <li>
                                        <a type="button" class="btn btn-danger bg-gradient-danger btn-block" style="border-radius: 0px;" href="inv_del.php?type=stock_movement&id=' . $row['STOCK_ID'] . '" onclick="return confirm(\'Are you sure you want to delete this stock?\');">
                                            <i class="fas fa-fw fa-trash"></i> Delete
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </td>';
                    echo '</tr> ';
                }
?> 
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                  </div>

<?php
include'../includes/footer.php';
?>


<!-- Stock Movement Modal-->
  <div class="modal fade" id="aModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Stock Movement</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <form role="form" method="post" action="inv_transac.php?action=add">
           <div class="form-group">
             <input class="form-control" placeholder="Stock ID" name="stockid" required>
           </div>
           <div class="form-group">
             <?php
               echo $ast;
             ?>
           </div>
             <div class="form-group">
             <input class="form-control" placeholder="Quantity" name="quantity" required>
           </div>
            <div class="form-group">
             <?php
               echo $mov;
             ?>
           </div>
            <div class="form-group">
             <input type="text" onfocus="(this.type='date')" onblur="(this.type='text')" class="form-control" placeholder="Start Date" name="startdate" required>
           </div>
            <div class="form-group">
             <input type="text" onfocus="(this.type='date')" onblur="(this.type='text')" class="form-control" placeholder="End Date" name="enddate" required>
           </div>
             <div class="form-group">
             <?php
               echo $emp;
             ?>
           </div>
             <div class="form-group">
             <input class="form-control" placeholder="Location" name="location" required>
           </div>
             <div class="form-group">
             <input class="form-control" placeholder="Remarks" name="remarks" required>
           </div>
            <hr>
            <button type="submit" class="btn btn-success"><i class="fa fa-check fa-fw"></i>Save</button>
            <button type="reset" class="btn btn-danger"><i class="fa fa-times fa-fw"></i>Reset</button>
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>      
          </form>  
        </div>
      </div>
    </div>
  </div>