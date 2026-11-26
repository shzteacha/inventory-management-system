<?php
include'../includes/connection.php';

	if (!isset($_GET['do']) || $_GET['do'] != 1) {
						
    	switch ($_GET['type']) {
    		case 'asset':
    			$query = 'DELETE FROM asset WHERE ASSET_ID = ' . $_GET['id'];
    			$result = mysqli_query($db, $query) or die(mysqli_error($db));				
            ?>
    			<script type="text/javascript">alert("Asset Successfully Deleted.");window.location = "product.php";</script>					
            <?php
    			//break;
            }
	}
?>