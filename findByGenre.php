
<?php

include('connectionData.txt');

$conn = mysqli_connect($server, $user, $pass, $dbname, $port)
or die('Error connecting to MySQL server.');

?>
<html>
    <head>
        <title>Search By Genre</title>
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
            if($_GET['genre'] == ""){
                $genre = $_POST['genre'];
            } else {
                $genre = $_GET['genre'];
            }

            $query =
                "SELECT
                    t.Track_name,
                    t.Length,
                    t.Genre,
                    a.Album_name,
                    a.Album_release_year,
                    art.Artist_name
                FROM
                    Track t
                JOIN
                    Album a
                    ON t.Album_fk_id = a.Album_id
                JOIN
                    Artist art
                    ON a.Artist_artist_id = art.Artist_id
                WHERE
                    t.Genre =? ;";

            if(!($stmt = mysqli_prepare($conn, $query))){
                echo "Failed preparation";
            };
            if(!$stmt->bind_param("s", $genre)){
                echo "Failed to bind params";
            };
            if(!$stmt->execute()){
                echo "Execution failed";
            }

            $stmt->bind_result($track_name, $length, $gen, $album, $release_year, $artist);
            $stmt->store_result();
            if($stmt->num_rows == 0){
                echo "<h2>Sorry, We don't have any songs in that genre</h2>";
            }else{
                $stmt->fetch();
                echo "<h2 align='center'>Genre: $gen</h2>";
                echo "<table cellpadding='4'>";
                /* Header for table */
                echo "<tr>
                        <td><b>Track Name</b></td>
                        <td><b>Artist</b></td>
                        <td><b>Album</b></td>
                        <td><b>Length</b></td>
                        <td><b>Release Year</b></td>
                      </tr>";
                do{
                    echo "<tr>
                            <td>$track_name</td>
                            <td><a href='findByArtist.php?artist=$artist'>$artist</a></td>
                            <td><a href='findByAlbum.php?album=$album'>$album</a></td>
                            <td>$length</td>
                            <td>$release_year</td>
                         </tr>";
                } while($stmt->fetch());
                $stmt->close();
                echo "</table>";
            }
            mysqli_close($conn);
            ?>
        </div>
    </body>
</html>

