<?php
include '../includes/connection.php';
include '../includes/sidebar.php';

$query = 'SELECT ID, t.TYPE
          FROM users u
          JOIN type t ON t.TYPE_ID=u.TYPE_ID 
          WHERE ID = ' . $_SESSION['MEMBER_ID'] . '';
$result = mysqli_query($db, $query) or die(mysqli_error($db));

while ($row = mysqli_fetch_assoc($result)) {
    $Aa = $row['TYPE'];
    if ($Aa == 'User') {
        ?>
        <script type="text/javascript">
            alert("Restricted Page! You will be redirected to POS");
            window.location = "pos.php";
        </script>
        <?php
    }
}

$query = 'SELECT 
            ASSET_ID,
            t.CNAME, 
            ASSET_TAG,
            HOSTNAME,
            SERIAL_NUMBER,
            MODEL,
            CUSTODIAN,
            DATE_STOCK_IN,
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

while ($row = mysqli_fetch_array($result)) {
    $zz = $row['ASSET_ID'];
    $zzz = $row['CNAME'];
    $y = $row['ASSET_TAG'];
    $a = $row['HOSTNAME'];
    $b = $row['SERIAL_NUMBER'];
    $c = $row['MODEL'];
    $d = $row['CUSTODIAN'];
    $e = $row['DATE_STOCK_IN'];
    $f = $row['COMPANY_NAME'];
    $g = $row['DEPARTMENT'];
    $h = $row['EMPLOYEE_ID'];
}
$id = $_GET['id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Asset Detail</title>
    <script src="https://cdn.jsdelivr.net/npm/qr-code-styling@1.5.0/lib/qr-code-styling.js"></script>
    <style>
        #qrcode {
            width: 200px;
            height: 200px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<center>
    <div class="card shadow mb-4 col-xs-12 col-md-8 border-bottom-primary">
        <div class="card-header py-3">
            <h4 class="m-2 font-weight-bold text-primary">Asset's Detail</h4>
        </div>
        <a href="product.php?action=add" type="button" class="btn btn-primary bg-gradient-primary btn-block">
            <i class="fas fa-flip-horizontal fa-fw fa-share"></i> Back
        </a>
        <div class="card-body">
            <!-- Display asset details -->
            <div class="form-group row text-left">
                <div class="col-sm-3 text-primary">
                    <h5>Asset Tag<br></h5>
                </div>
                <div class="col-sm-9">
                    <h5>: <?php echo $y; ?><br></h5>
                </div>
            </div>

            <!-- QR Code Section -->
            <div class="form-group row text-left">
                <div class="col-sm-3 text-primary">
                    <h5>QR Code<br></h5>
                </div>
                <div class="col-sm-9">
                    <div id="qrcode"></div>
                </div>
            </div>

            <!-- Remaining details -->
            <div class="form-group row text-left">
                <div class="col-sm-3 text-primary">
                    <h5>Category Name<br></h5>
                </div>
                <div class="col-sm-9">
                    <h5>: <?php echo $zzz; ?><br></h5>
                </div>
            </div>
            <div class="form-group row text-left">
                <div class="col-sm-3 text-primary">
                    <h5>Hostname<br></h5>
                </div>
                <div class="col-sm-9">
                    <h5>: <?php echo $a; ?><br></h5>
                </div>
            </div>
            <div class="form-group row text-left">
                <div class="col-sm-3 text-primary">
                    <h5>Serial Number<br></h5>
                </div>
                <div class="col-sm-9">
                    <h5>: <?php echo $b; ?><br></h5>
                </div>
            </div>
            <div class="form-group row text-left">
                <div class="col-sm-3 text-primary">
                    <h5>Model<br></h5>
                </div>
                <div class="col-sm-9">
                    <h5>: <?php echo $c; ?><br></h5>
                </div>
            </div>
            <div class="form-group row text-left">
                <div class="col-sm-3 text-primary">
                    <h5>Custodian<br></h5>
                </div>
                <div class="col-sm-9">
                    <h5>: <?php echo $d; ?><br></h5>
                </div>
            </div>
            <div class="form-group row text-left">
                <div class="col-sm-3 text-primary">
                    <h5>Date Stock In<br></h5>
                </div>
                <div class="col-sm-9">
                    <h5>: <?php echo $e; ?><br></h5>
                </div>
            </div>
            <div class="form-group row text-left">
                <div class="col-sm-3 text-primary">
                    <h5>Supplier ID<br></h5>
                </div>
                <div class="col-sm-9">
                    <h5>: <?php echo $f; ?><br></h5>
                </div>
            </div>
            <div class="form-group row text-left">
                <div class="col-sm-3 text-primary">
                    <h5>Department<br></h5>
                </div>
                <div class="col-sm-9">
                    <h5>: <?php echo $g; ?><br></h5>
                </div>
            </div>
            <div class="form-group row text-left">
                <div class="col-sm-3 text-primary">
                    <h5>Employee ID<br></h5>
                </div>
                <div class="col-sm-9">
                    <h5>: <?php echo $h; ?><br></h5>
                </div>
            </div>
        </div>
    </div>
</center>

<script>
    const qrCode = new QRCodeStyling({
        width: 200,
        height: 200,
        data: "<?php echo $y; ?>",
        dotsOptions: {
            color: "#000",
            type: "rounded"
        },
        backgroundOptions: {
            color: "#ffffff",
        }
    });

    qrCode.append(document.getElementById("qrcode"));
</script>
</body>
</html>
<?php
include '../includes/footer.php';
?>
