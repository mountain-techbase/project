<?php
$dsn='mysql:dbname=;host=localhost';
$user = '';
$pass = '';
$pdo = new PDO($dsn, $user, $pass, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));


function parseToXML($htmlStr)
{
    $xmlStr=str_replace('<','&lt;',$htmlStr);
    $xmlStr=str_replace('>','&gt;',$xmlStr);
    $xmlStr=str_replace('"','&quot;',$xmlStr);
    $xmlStr=str_replace("'",'&#39;',$xmlStr);
    $xmlStr=str_replace("&",'&amp;',$xmlStr);
    return $xmlStr;
}

// Select all the rows in the markers table
try{
    $sql = "select * from markers where 1";
    $result = $pdo->query($sql);
    if($result->rowCount() > 0){
        header("Content-type: text/xml");
        // Start XML file, echo parent node
        echo "<?xml version='1.0' ?>";
        echo '<markers>';
        $ind=0;
        while($row = $result->fetch()){
            // Add to XML document node
            echo '<marker ';
            echo 'id="' . $row['id'] . '" ';
            echo 'name="' . parseToXML($row['info']) . '" ';
            echo 'address="' . parseToXML($row['clean']) . '" ';
            echo 'lat="' . $row['lat'] . '" ';
            echo 'lng="' . $row['lng'] . '" ';
            echo 'comment="' . parseToXML($row['comment']) . '" ';
            echo '/>';
            $ind = $ind + 1;
        }
        // End XML file
        echo '</markers>';
    }
}
catch(PDOException $e){
    die("ERROR: Could not able to execute $sql. " . $e->getMessage());
}


?>
