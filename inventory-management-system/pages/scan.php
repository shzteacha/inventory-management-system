
<?php

include'../includes/connection.php';

include'../includes/sidebar.php';

?>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>QR Code Scanner</title>

  <!-- Include html5-qrcode Library -->
  <script src="https://unpkg.com/html5-qrcode@2.0.9/dist/html5-qrcode.min.js"></script>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

  <style>
    

    .container {
      text-align: center;
      background: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    }

    #qr-reader {
      width: 100%;
      max-width: 600px;
      margin: 0 auto;
    }

    .scanner-output {
      margin-top: 20px;
      padding: 10px;
      border: 1px solid #ddd;
      background-color: #f9f9f9;
      display: none;
    }

    input[type="file"] {
      margin: 20px auto;
      display: block;
    }
  </style>

<body>
  <div class="container">
    <h2>Scan Asset QR Code</h2>

    <!-- QR Code Reader -->
    <div id="qr-reader"></div>

    <!-- Option to select from gallery -->
    <!-- <div>
      <input type="file" id="qr-image-input" accept="image/*" />
    </div> -->

    <!-- Manual Button to Open Modal -->
    <button type="button" class="btn btn-primary mt-3" id="open-modal-btn">Add New Asset</button>

    <!-- Scanner Output -->
    <div id="scanner-output" class="scanner-output">
      <h4>Asset Information:</h4>
      <div id="asset-details"></div>
    </div>
  </div>
  <!-- Select Option -->
   <?php
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

  <!-- Asset Modal -->
  <div class="modal fade" id="aModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
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
              <label for="assetid">Asset ID</label>
              <input class="form-control" id="assetid" placeholder="Enter Asset ID" name="assetid" required>
            </div>
            <div class="form-group">
            <label for="category">Category</label>
              <?php
                echo $opt;
              ?>
            </div>
            <div class="form-group">
              <label for="assetag">Asset Tag</label>
              <input class="form-control" id="assetag" placeholder="Enter Asset Tag" name="assetag" required>
            </div>
            <div class="form-group">
              <label for="hostname">Hostname</label>
              <input class="form-control" id="hostname" placeholder="Enter Hostname" name="hostname" required>
            </div>
            <div class="form-group">
              <label for="serialnum">Serial Number</label>
              <input class="form-control" id="serialnum" placeholder="Enter Serial Number" name="serialnum" required>
            </div>
            <div class="form-group">
              <label for="model">Model</label>
              <input class="form-control" id="model" placeholder="Enter Model" name="model" required>
            </div>
            <div class="form-group">
              <label for="custodian">Custodian</label>
              <input class="form-control" id="custodian" placeholder="Enter Custodian" name="custodian" required>
            </div>
            <div class="form-group">
            <label for="costcenter">Cost Center</label>
              <?php
                echo $cost;
              ?>
            </div>
            <div class="form-group">
              <label for="datestock">Date Stock In</label>
              <input type="text" id="datestock" onfocus="(this.type='date')" onblur="(this.type='text')"
                class="form-control" placeholder="Enter Date Stock In" name="datestock" required>
            </div>
            <div class="form-group">
            <label for="supplier">Supplier</label>
              <?php
                echo $sup;
              ?>
            </div>
            <div class="form-group">
            <label for="employee">Employee ID</label>
              <?php
                echo $emp;
              ?>
            </div>
            <hr>
            <button type="submit" class="btn btn-success"><i class="fa fa-check fa-fw"></i> Save</button>
            <button type="reset" class="btn btn-danger"><i class="fa fa-times fa-fw"></i> Reset</button>
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          </form>
        </div>

      </div>
    </div>
  </div>

  <script>
    const qrReaderElem = document.getElementById('qr-reader');
    const qrImageInput = document.getElementById('qr-image-input');
    const scannerOutput = document.getElementById('scanner-output');
    const assetDetails = document.getElementById('asset-details');
    const openModalBtn = document.getElementById('open-modal-btn');

    // Function to fetch asset details
    function fetchAssetDetails(assetTag) {
      const formData = new FormData();
      formData.append('asset_tag', assetTag);

      fetch('fetch_asset.php', {
        method: 'POST',
        body: formData
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            // Asset found
            const details = `
              <strong>Asset ID:</strong> ${data.asset.ASSET_ID}<br>
              <strong>Category ID:</strong> ${data.asset.CATEGORY_ID}<br>
              <strong>Asset Tag:</strong> ${data.asset.ASSET_TAG}<br>
              <strong>Hostname:</strong> ${data.asset.HOSTNAME}<br>
              <strong>Serial Number:</strong> ${data.asset.SERIAL_NUMBER}<br>
              <strong>Model:</strong> ${data.asset.MODEL}<br>
              <strong>Custodian:</strong> ${data.asset.CUSTODIAN}<br>
              <strong>Date Stock In:</strong> ${data.asset.DATE_STOCK_IN}`;
            assetDetails.innerHTML = details;
            scannerOutput.style.display = 'block';
          } else {
            // Asset not found, open modal
            $('#aModal').modal('show');
          }
        })
        .catch(error => console.error('Error fetching asset details:', error));
    }

    // Initialize QR Code scanner
    const html5QrCode = new Html5Qrcode("qr-reader");

    html5QrCode.start(
      { facingMode: "environment" }, // Use rear camera
      { fps: 10, qrbox: 250 },
      (decodedText, decodedResult) => {
        fetchAssetDetails(decodedText);
      },
      (errorMessage) => {
        console.warn(`QR Code scan error: ${errorMessage}`);
      }
    ).catch(err => console.error('Error starting QR scanner:', err));

    // Decode QR code from selected image
    qrImageInput.addEventListener('change', async (event) => {
      const file = event.target.files[0];
      if (file) {
        try {
          const result = await html5QrCode.scanFile(file, true);
          fetchAssetDetails(result);
        } catch (err) {
          console.error('Error scanning image:', err);
          alert('Failed to decode QR code from the image. Please try again.');
        }
      }
    });

    // Add event listener to open modal manually
    openModalBtn.addEventListener('click', () => {
      $('#aModal').modal('show');
    });
  </script>
</body>

</html>

<?php
include'../includes/footer-user.php';
?>