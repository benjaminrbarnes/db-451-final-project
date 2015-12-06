
<?php

include('connectionData.txt');

$conn = mysqli_connect($server, $user, $pass, $dbname, $port)
or die('Error connecting to MySQL server.');

?>
<html>
    <head>
        <title>Search By Artist</title>
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
                    <td><a href="searchByUser.html">Search By User</a></td>
                    <td><a href="searchByRecordLabel.html">Search By Record Label</a></td>
                </tr>
            </table>
        </div>
        <hr width="30%">
        <div align="center">
            <?php
            /* we first check to see if there is a get in the url
            and if not, see if there is a post. */
            if($_GET['artist'] == ""){
                $artist = $_POST['artist'];
            } else {
                $artist = $_GET['artist'];
            }

            $query =
                "SELECT
                    t.Track_name,
                    t.Length,
                    t.Genre,
                    a.Album_name,
                    a.Album_artwork_link,
                    a.Album_release_year,
                    art.Artist_name,
                    art.City
                FROM
                    Track t
                JOIN
                    Album a
                    ON t.Album_fk_id = a.Album_id
                JOIN
                    Artist art
                    ON a.Artist_artist_id = art.Artist_id
                WHERE
                    art.Artist_name =? ;";

            if(!($stmt = mysqli_prepare($conn, $query))){
                echo "Failed preparation";
            };
            if(!$stmt->bind_param("s", $artist)){
                echo "Failed to bind params";
            };
            if(!$stmt->execute()){
                echo "Execution failed";
            }

            $stmt->bind_result($track_name, $length, $genre, $album_name, $album_link, $release_year, $artist_name, $city);
            $stmt->store_result();
            if($stmt->num_rows == 0){
                echo "<h2>Sorry, We don't have any Artists with that name</h2>";
            }else{
                $stmt->fetch();
                echo    "<h2 align='center'>Artist: $artist_name</h2>
                        <h3 align='center'>From: $city</h3>";

                /* Header for table */
                echo "<table cellpadding='4'>
                          <tr>
                            <td><b>Track Name</b></td>
                            <td><b>Length</b></td>
                            <td><b>Genre</b></td>
                            <td><b>Album</b></td>
                            <td><b>Release Year</b></td>
                          </tr>";
                do{
                    echo "<tr>
                            <td>$track_name</td>
                            <td>$length</td>
                            <td><a href='findByGenre.php?genre=$genre'>$genre</a></td>
                            <td><a href='findByAlbum.php?album=$album_name'>$album_name</a></td>
                            <td>$release_year</td>
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

