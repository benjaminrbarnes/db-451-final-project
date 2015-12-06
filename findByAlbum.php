
<?php

include('connectionData.txt');

$conn = mysqli_connect($server, $user, $pass, $dbname, $port)
or die('Error connecting to MySQL server.');

?>
<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">-->
<html>
    <head>
        <title>Search By Album</title>
    </head>

    <body bgcolor="white">

        <div align="center">
            <table cellpadding="8">
                <tr>
                    <td><a href="home.php">Home</a></td>
                    <td><a href="searchByAlbum.html">Search By Album</a></td>
                    <td><a href="searchByGenre.html">Search By Genre</a></td>
                    <td><a href="searchByCity.html">Search By City</a></td>
                    <td><a href="searchByArtist.html">Search By Artist</a></td>
                </tr>
            </table>
        </div>
        <hr width="30%">
        <div align="center">
            <?php
            /* we first check to see if there is a get in the url
            and if not, see if there is a post. */
            if($_GET['album'] == ""){
                $album = $_POST['album'];
            } else {
                $album = $_GET['album'];
            }

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
                echo "
                    <h2 align='center'>$album_name</h2>
                    <h3 align='center'>$artist</h3>
                    <h4 align='center'>From City: $city</h4>
                    <h4 align='center'>Album Released: $release_year</h4>
                    <img align='center' src='albums/$artwork_link' style='width: 300px; height: 300px;'></img>

                    <h3>Track List</h3>
                    <table cellpadding='4'>";
                do{
                    echo "<tr>
                            <td>$track_name</td>
                            <td>$length</td>
                            <td><a href='findByGenre.php?genre=$genre'>$genre</a></td>
                          </tr>";
                } while($stmt->fetch());
                $stmt->close();
                echo "</table>";
            }

            mysqli_free_result($result);

            mysqli_close($conn);

            ?>
        </div>
    </body>
</html>

