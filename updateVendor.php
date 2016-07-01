<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "magento_test_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$selSql = "select * from ced_csmarketplace_vendor_products";
$result = $conn->query($selSql);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $selSql2 = "select * from catalog_product_entity_int WHERE entity_id = " . $row['product_id'] . " AND attribute_id = 165 AND entity_type_id = 4";
        $result2 = $conn->query($selSql2);
        if ($result2->num_rows > 0) {
            // output data of each row
            $sql = "UPDATE catalog_product_entity_int SET value= " . $row['vendor_id'] . " WHERE entity_id = " . $row['product_id'] . " AND attribute_id = 165";
            if ($conn->query($sql) === TRUE) {
                echo "Record updated successfully";
            } else {
                echo "Error updating record: " . $conn->error;
            }
        } else {
            $product_ID = $row['product_id'];
            $vendor_id = $row['vendor_id'];
            $insSql = "INSERT into catalog_product_entity_int (entity_type_id,attribute_id,store_id,entity_id,value) values (4,165,0,$product_ID,$vendor_id)";
            $conn->query($insSql);
            echo '<br>'.$insSql;
        }
    }
} else {
    echo "0 results";
}


$conn->close();
?>