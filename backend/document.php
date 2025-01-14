<?php

require_once("connect.php");



$columns = myQuery("describe document");
//print_r($columns);
echo "<table border='1'>";
echo "<tr>";
foreach ($columns as $colname)
    {
        echo "<th>".$colname['Field']."</th>";
    }
echo "</tr>";


$records = myQuery("SELECT * FROM document");
//print_r($records);
foreach ($records as $row) 
    { 
        echo "<tr>";
        foreach ($row as $field)
            {
                echo "<td>".$field."</td>";
            }
        echo "</tr>";
    }
    
echo "</table>";


?>