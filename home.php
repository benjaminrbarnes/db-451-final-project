<?php

include('connectionData.txt');

$conn = mysqli_connect($server, $user, $pass, $dbname, $port)
or die('Error connecting to MySQL server.');

?>
<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">-->

<html>
    <head>
           <title>Music Finder</title>
    </head>

    <body bgcolor="white">
        <h1 align="center">Music Finder</h1>
        <h3 align="center">Your favorite music source</h3>

        <div align="center">
            <table cellpadding="10" >
                <tr>
                    <td align="center"><a href="test.html">Search By Artist</a></td>
                    <td align="center"><a href="test.html">Search By Track</a></td>
                    <td align="center"><a href="test.html">Search By Genre</a></td>
                </tr>
                <tr>
                    <td align="center"><a href="searchByAlbum.html">Search By Album</a></td>
                    <td align="center"><a href="test.html">Find New Playlists</a></td>
                    <td align="center"><a href="test.html">Find Random Artist</a></td>
                </tr>
            </table>
        </div>

        <hr width="10%">
        <div align="center">

            <h2>New Releases</h2>
            <table cellpadding="10" >
                <?php
                $query = "SELECT Album_artwork_link FROM Album limit 6;";
                if(!($stmt = mysqli_prepare($conn, $query))){
                    echo "it has failed preparation";
                };
                if(!$stmt->execute()){
                    echo "execution failed";
                }

                $stmt->bind_result($col1);
                $row = 0;
                echo "<tr>";
                while($stmt->fetch()){
                    if($row % 3 == 0){
                        echo "</tr>";
                        echo "<tr>";
                    }
                    echo "<td><img src='albums/$col1' style='width: 300px; height: 300px;'></img></td>";
                    $row++;
                }
                echo "</tr>";
                $stmt->close();
                mysqli_free_result($result);
                mysqli_close($conn);
                ?>
            </table>
        </div>
        <hr width="70%">
        <div align="center">
            <p><a href="findCust.txt" >Contents</a> of this page.<p>
            <p><a href="findCustManu.txt" >Contents</a> of the PHP page that gets called. (And the
            <a href="connectionData.txt" >connection data</a>, kept separately for security reasons.)</p>
        </div>

    </body>
</html>
