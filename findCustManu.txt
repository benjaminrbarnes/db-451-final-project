<?php

include('connectionData.txt');

$conn = mysqli_connect($server, $user, $pass, $dbname, $port)
or die('Error connecting to MySQL server.');

?>

<html>
<head>
  <title>Another COMPLEX PHP-MySQL Program</title>
  </head>
  
  <body bgcolor="white">
  
  
  <hr>
  
  
<?php
  
$state = $_POST['state'];

$query = 
"SELECT s.stock_num, s.description, IFNULL(i.total, 0) as total
FROM stock s
LEFT OUTER JOIN 
    (SELECT i.stock_num, sum(i.total_price) as total
     FROM items i 
     WHERE i.manu_code = (SELECT manu_code FROM manufact WHERE manu_name =? LIMIT 1)
     GROUP BY i.stock_num) i 
 ON s.stock_num = i.stock_num 
 INNER JOIN manufact m on s.manu_code = m.manu_code 
 WHERE m.manu_name =? ";

$formattedQuery = 
"SELECT s.stock_num, s.description, IFNULL(i.total, 0) as total
FROM stock s
LEFT OUTER JOIN 
    (SELECT i.stock_num, sum(i.total_price) as total
     FROM items i 
     WHERE i.manu_code = (SELECT manu_code FROM manufact WHERE manu_name ="."'".$state."'"." LIMIT 1)
     GROUP BY i.stock_num) i 
 ON s.stock_num = i.stock_num 
 INNER JOIN manufact m on s.manu_code = m.manu_code 
 WHERE m.manu_name ="."'".$state."';";
?>

<p>
The query:
<p>
<?php
print $formattedQuery;
?>

<hr>
<p>
Result of query:
<p>

<?php
if(!($stmt = mysqli_prepare($conn, $query))){
	echo "it has failed preparation";
};
if(!$stmt->bind_param("ss", $state, $state)){
	echo "failed to bind params";
};
if(!$stmt->execute()){
	echo "execution failed";
}

$stmt->bind_result($col1, $col2, $col3);
print "<pre>";
while($stmt->fetch()){
	printf("%s %s %s\n", $col1, $col2, $col3);
}
$stmt->close();
print "</pre>";
mysqli_free_result($result);

mysqli_close($conn);

?>

<p>
<hr>

<p>
<a href="findCustManu.txt" >Contents</a>
of the PHP program that created this page. 	 
 
</body>
</html>
	  
