<?php require ('test.php'); ?>

<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Render Results</title>

</head>

<body>
    <h1>Echo Messages for Chat ID = 3 Here as HTML</h1>
    <div><?php /* Call Your Class Here using echo() */
    $a = getChatFromId('3');
    echo "<table>";
    foreach($a as $key=>$row) {
        echo "<tr>";
        foreach($row as $key2=>$row2){
            echo "<td>" . $key2 . ": " . $row2 . "</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
    
    ?></div>

    <h1>Render Messages for Chat ID = 8 Here as JSON</h1>
    <div><?php /* Call Your Class Here using json_encode() */ echo json_encode(getChatFromId('8')); ?></div>

    <h1>Render User ID = 100 Here as JSON</h1>
    <div><?php /* Call Your Class Here using json_encode() */ echo json_encode(getUserFromId('100')); ?></div>
    
    <h1>Echo Message ID = 459 Here as HTML</h1>
    <div><?php /* Call Your Class Here using echo() */ ;
    $a = getMsgFromId('459');
    echo "<table>";
    foreach($a as $key=>$row) {
        echo "<tr>";
         echo "<td>" . $key . ": " . $row . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    ?></div>
</body>
</html>