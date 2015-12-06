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
                    <td align="center"><a href="searchByArtist.html">Search By Artist</a></td>
                    <td align="center"><a href="searchByUser.html">Search By User</a></td>
                    <td align="center"><a href="searchByGenre.html">Search By Genre</a></td>
                </tr>
                <tr>
                    <td align="center"><a href="searchByAlbum.html">Search By Album</a></td>
                    <td align="center"><a href="searchByCity.html">Search By City</a></td>
                    <td align="center"><a href="home.php">Find Random Artist</a></td>
                </tr>
            </table>
        </div>

        <hr width="10%">
        <div align="center">

            <h2>New Releases</h2>
            <table cellpadding="10" >
                <?php
                $query = "SELECT Album_artwork_link, Album_name FROM Album limit 9;";
                if(!($stmt = mysqli_prepare($conn, $query))){
                    echo "it has failed preparation";
                };
                if(!$stmt->execute()){
                    echo "execution failed";
                }

                $stmt->bind_result($album, $album_name);
                $row = 0;
                echo "<tr>";
                while($stmt->fetch()){
                    if($row % 3 == 0){
                        echo "</tr>";
                        echo "<tr>";
                    }
                    echo "<td><a href='findByAlbum.php?album=$album_name'><img hre src='albums/$album' style='width: 300px; height: 300px;'></img></a></td>";
                    $row++;
                }
                echo "</tr>";
                $stmt->close();
                mysqli_free_result($result);
                mysqli_close($conn);
                ?>
            </table>
        </div>
<!--        <hr width="70%">-->
<!--        <div align="center">-->
<!--            <p><a href="findCust.txt" >Contents</a> of this page.<p>-->
<!--            <p><a href="findCustManu.txt" >Contents</a> of the PHP page that gets called. (And the-->
<!--            <a href="connectionData.txt" >connection data</a>, kept separately for security reasons.)</p>-->
<!--        </div>-->

    </body>
</html>
