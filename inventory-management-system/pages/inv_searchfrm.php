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
            ?>
          <center><div class="card shadow mb-4 col-xs-12 col-md-8 border-bottom-primary">
            <div class="card-header py-3">
              <h4 class="m-2 font-weight-bold text-primary">Stock Movement's Detail</h4>
            </div>
            <a href="inventory.php" type="button" class="btn btn-primary bg-gradient-primary btn-block"> <i class="fas fa-flip-horizontal fa-fw fa-share"></i> Back</a>
            <div class="card-body">
          <?php 
       $query = 'SELECT STOCK_ID, a.ASSET_ID, QUANTITY, o.MOVE_TYPE, START_DATE, END_DATE, e.EMPLOYEE_ID, e.FIRST_NAME, e.LAST_NAME, LOCATION, REMARKS, TIMESTAMP FROM stock_movement m
  JOIN asset a ON m.ASSET_ID=a.ASSET_ID
  JOIN move_type o ON m.MOVE_ID=o.MOVE_ID
  JOIN employee e ON m.EMPLOYEE_ID=e.EMPLOYEE_ID
  WHERE STOCK_ID ='.$_GET['id'];
            $result = mysqli_query($db, $query) or die(mysqli_error($db));
              while($row = mysqli_fetch_array($result))
              {   
                $zz= $row['STOCK_ID'];
                $zzz= $row['ASSET_ID'];
                $a=$row['QUANTITY'];
                $b= $row['MOVE_TYPE'];
                $c=$row['START_DATE'];
                $d=$row['END_DATE'];
                $e=$row['EMPLOYEE_ID'];
                $f=$row['LOCATION'];
                $g=$row['REMARKS'];
                $h=$row['TIMESTAMP'];
                $employeeName = $row['FIRST_NAME'] . ' ' . $row['LAST_NAME'];

                // Calculate timestamp based on start and end date
                $startTimestamp = strtotime($c);
                $endTimestamp = strtotime($d);
                $timestamp = date('Y-m-d H:i:s'); // Use current date-time, or adjust as needed.
              }
              $id = $_GET['id'];
          ?>

                  <div class="form-group row text-left">
                      <div class="col-sm-3 text-primary">
                        <h5>
                          Stock ID<br>
                        </h5>
                      </div>
                      <div class="col-sm-9">
                        <h5>
                          : <?php echo $zz; ?><br>
                        </h5>
                      </div>
                    </div>
                    <div class="form-group row text-left">
                      <div class="col-sm-3 text-primary">
                        <h5>
                          Asset ID<br>
                        </h5>
                      </div>
                      <div class="col-sm-9">
                        <h5>
                          : <?php echo $zzz; ?> <br>
                        </h5>
                      </div>
                    </div>
                  <div class="form-group row text-left">
                      <div class="col-sm-3 text-primary">
                        <h5>
                          Quantity<br>
                        </h5>
                      </div>
                      <div class="col-sm-9">
                        <h5>
                          : <?php echo $a; ?><br>
                        </h5>
                      </div>
                    </div>
                  <div class="form-group row text-left">
                      <div class="col-sm-3 text-primary">
                        <h5>
                          Move Type<br>
                        </h5>
                      </div>
                      <div class="col-sm-9">
                        <h5>
                          : <?php echo $b; ?><br>
                        </h5>
                      </div>
                    </div>
                  <div class="form-group row text-left">
                      <div class="col-sm-3 text-primary">
                        <h5>
                          Start Date<br>
                        </h5>
                      </div>
                      <div class="col-sm-9">
                        <h5>
                          : <?php echo $c; ?><br>
                        </h5>
                      </div>
                    </div>
                     <div class="form-group row text-left">
                      <div class="col-sm-3 text-primary">
                        <h5>
                          End Date<br>
                        </h5>
                      </div>
                      <div class="col-sm-9">
                        <h5>
                          : <?php echo $d ; ?><br>
                        </h5>
                      </div>
                    </div>
                    <div class="form-group row text-left">
                      <div class="col-sm-3 text-primary">
                        <h5>
                          Employee ID<br>
                        </h5>
                      </div>
                      <div class="col-sm-9">
                        <h5>
                          : <?php echo $e; ?><br>
                        </h5>
                      </div>
                    </div>
                    <div class="form-group row text-left">
                        <div class="col-sm-3 text-primary">
                            <h5>
                                Employee Name<br>
                            </h5>
                        </div>
                        <div class="col-sm-9">
                            <h5>
                                : <?php echo htmlspecialchars($employeeName); ?><br>
                            </h5>
                        </div>
                    </div>
                    <div class="form-group row text-left">
                      <div class="col-sm-3 text-primary">
                        <h5>
                          Location<br>
                        </h5>
                      </div>
                      <div class="col-sm-9">
                        <h5>
                          : <?php echo $f; ?><br>
                        </h5>
                      </div>
                    </div>
                    <div class="form-group row text-left">
                      <div class="col-sm-3 text-primary">
                        <h5>
                          Remarks<br>
                        </h5>
                      </div>
                      <div class="col-sm-9">
                        <h5>
                          : <?php echo $g; ?><br>
                        </h5>
                      </div>
                    </div>
                     <div class="form-group row text-left">
                      <div class="col-sm-3 text-primary">
                        <h5>
                          Timestamp<br>
                        </h5>
                      </div>
                      <div class="col-sm-9">
                        <h5>
                          : <?php echo $timestamp; ?> <br>
                        </h5>
                      </div>
                    </div>
                </div>
          </div></center>

 


<?php
include'../includes/footer.php';
?>
