
<?php

include('connectionData.txt');

$conn = mysqli_connect($server, $user, $pass, $dbname, $port)
or die('Error connecting to MySQL server.');

?>
<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">-->
<html>
    <head>
        <title>Another COMPLEX PHP-MySQL Program</title>
    </head>

    <body bgcolor="white">

        <div align="center">
            <table  cellpadding="8">
                <tr>
                    <td><a href="home.php">Home</a></td>
                    <td><a href="searchByAlbum.html">Search By Album</a></td>
                </tr>
            </table>
        </div>
        <hr width="30%">
        <div align="center">
            <?php

            $album = $_POST['album'];

            $query = "SELECT
                    r.Album_name,
                    t.Track_name,
                    t.Length,
                    t.Genre,
                    r.Album_artwork_link,
                    r.Album_release_year,
                    art.Artist_name,
                    art.City
                FROM
                    Track t
                JOIN
                    (SELECT *
                    FROM Album a
                    WHERE a.Album_name =?) r
                    ON t.Album_fk_id = r.Album_id
                JOIN
                    Artist art
                    ON r.Artist_artist_id = art.Artist_id;";

            if(!($stmt = mysqli_prepare($conn, $query))){
                echo "Failed preparation";
            };
            if(!$stmt->bind_param("s", $album)){
                echo "Failed to bind params";
            };
            if(!$stmt->execute()){
                echo "Execution failed";
            }

            $stmt->bind_result($album_name, $track_name, $length, $genre, $artwork_link, $release_year, $artist, $city);
            $stmt->store_result();
            if($stmt->num_rows == 0){
                echo "<h2>Sorry, We don't have that album</h2>";
            }else{
                $stmt->fetch();
                echo "<h2 align='center'>$album_name</h2>";
                echo "<h3 align='center'>$artist</h3>";
                echo "<h4 align='center'>From City: $city</h4>";
                echo "<h4 align='center'>Album Released: $release_year</h4>";
                echo "<img align='center' src='albums/$artwork_link' style='width: 300px; height: 300px;'></img>";

                echo "<h3>Track List</h3>";
                echo "<table cellpadding='4'>";
                do{
                    echo "<tr>";
                    echo "<td>$track_name</td>";
                    echo "<td>$length</td>";
                    echo "<td>$genre</td>";
                    echo "</tr>";
                } while($stmt->fetch());
                $stmt->close();
                echo "</table>";
            }

            mysqli_free_result($result);

            mysqli_close($conn);

            ?>

            <p>
<!--            <hr>-->
<!---->
<!--            <p>-->
<!--                <a href="findCustManu.txt" >Contents</a>-->
<!--                of the PHP program that created this page.-->
        </div>
    </body>
</html>

