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

$aaa = "<select class='form-control' name='category' required>
        <option disabled selected hidden>Select Category</option>";
  while ($row = mysqli_fetch_assoc($result)) {
    $aaa .= "<option value='".$row['CATEGORY_ID']."'>".$row['CNAME']."</option>";
  }

$aaa .= "</select>";

$sql2 = "SELECT DISTINCT SUPPLIER_ID, COMPANY_NAME FROM supplier order by COMPANY_NAME asc";
$result2 = mysqli_query($db, $sql2) or die ("Bad SQL: $sql2");

$sup = "<select class='form-control' name='supplier' required>
        <option disabled selected hidden>Select Supplier</option>";
  while ($row = mysqli_fetch_assoc($result2)) {
    $sup .= "<option value='".$row['SUPPLIER_ID']."'>".$row['COMPANY_NAME']."</option>";
  }

$sup .= "</select>";

$sql3 = "SELECT DISTINCT COSTCENTER_ID, COST_CENTER,   DEPARTMENT, LOCATION FROM cost_center order by DEPARTMENT asc";
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
   
   <div class="card shadow mb-4">
    <div class="card-header py-3">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h4 class="m-2 font-weight-bold text-primary">Asset&nbsp;<a href="#" data-toggle="modal" data-target="#aModal" type="button" class="btn btn-primary bg-gradient-primary" style="border-radius: 0px;"><i class="fas fa-fw fa-plus"></i></a></h4>

                <a href="generate_file.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mr-2"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
            </div>

            <div style="display: flex; align-items: center;">
                
                    <form action="import_file.php" method="post" enctype="multipart/form-data">
                        <div style="border: 1px solid #cac9c9; padding: 5px; border-radius: 4px;"><input type="file" name="file" accept=".csv" required></div>
                        <button type="submit" name="import_asset" class="btn btn-sm btn-primary mt-2 d-block" style="margin-left: auto;">Import File</button>
                    </form>
            </div>
            
        </div>
        
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Asset ID</th>
                        <th>Category Name</th>
                        <th>Asset Tag</th>
                        <th>Hostname</th>
                        <th>Serial Number</th>
                        <th>Custodian</th>
                        <th>Cost Center</th>
                        <th>Action</th>
                    </tr>
                </thead> 
                <tbody>
<?php                  
   $query = "SELECT a.ASSET_ID, t.CNAME, a.ASSET_TAG, a.HOSTNAME, a.SERIAL_NUMBER, a.MODEL, 
                 a.CUSTODIAN, c.DEPARTMENT, a.DATE_STOCK_IN, s.COMPANY_NAME, e.EMPLOYEE_ID
          FROM asset a
          JOIN category t ON a.CATEGORY_ID = t.CATEGORY_ID
          JOIN cost_center c ON a.COSTCENTER_ID = c.COSTCENTER_ID
          JOIN supplier s ON a.SUPPLIER_ID = s.SUPPLIER_ID
          JOIN employee e ON a.EMPLOYEE_ID = e.EMPLOYEE_ID
 	  GROUP BY a.ASSET_ID";
 
        $result = mysqli_query($db, $query) or die (mysqli_error($db));
      
            while ($row = mysqli_fetch_assoc($result)) {
                                 
                echo '<tr>';
                    echo '<td>'. $row['ASSET_ID'].'</td>';
                    echo '<td>'. $row['CNAME'].'</td>';
                    echo '<td>'. $row['ASSET_TAG'].'</td>';
                    echo '<td>'. $row['HOSTNAME'].'</td>';
                    echo '<td>'. $row['SERIAL_NUMBER'].'</td>';
                    echo '<td>'. $row['CUSTODIAN'].'</td>';
                    echo '<td>'. $row['DEPARTMENT'].'</td>';
                    echo '<td align="right">
                        <div class="btn-group">
                            <a type="button" class="btn btn-primary bg-gradient-primary" href="pro_searchfrm.php?action=edit & id='.$row['ASSET_ID'] . '"><i class="fas fa-fw fa-list-alt"></i> Details</a>
                            <div class="btn-group">
                                <a type="button" class="btn btn-primary bg-gradient-primary dropdown no-arrow" data-toggle="dropdown" style="color:white;">
                                    ... <span class="caret"></span></a>
                                <ul class="dropdown-menu text-center" role="menu">
                                    <li>
                                        <a type="button" class="btn btn-warning bg-gradient-warning btn-block" style="border-radius: 0px;" href="pro_edit.php?action=edit & id='.$row['ASSET_ID']. '">
                                            <i class="fas fa-fw fa-edit"></i> Edit
                                        </a>
                                    </li>
                                    <li>
                                        <a type="button" class="btn btn-danger bg-gradient-danger btn-block" style="border-radius: 0px;" href="pro_del.php?type=asset&id=' . $row['ASSET_ID'] . '" onclick="return confirm(\'Are you sure you want to delete this employee?\');">
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

  <!-- Asset Modal-->
  <div class="modal fade" id="aModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Asset</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <form role="form" method="post" action="pro_transac.php?action=add">
           <div class="form-group">
             <input class="form-control" placeholder="Asset ID" name="assetid" required>
           </div>
           <div class="form-group">
             <?php
               echo $aaa;
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
             <input type="text" onfocus="(this.type='date')" onblur="(this.type='text')" class="form-control" placeholder="Date Stock In" name="datestock" required>
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