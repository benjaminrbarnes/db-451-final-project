
<?php

include('connectionData.txt');

$conn = mysqli_connect($server, $user, $pass, $dbname, $port)
or die('Error connecting to MySQL server.');

?>
<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">-->
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
                </tr>
            </table>
        </div>
        <hr width="30%">
        <div align="center">
            <?php
            /* we first check to see if there is a get in the url
            and if not, see if there is a post. */
            if($_GET['username'] == ""){
                $username = $_POST['username'];
            } else {
                $username = $_GET['username'];
            }

            $query =
                "SELECT
                    track.Track_name,
                    track.Length,
                    track.Genre,
                    lp.name AS playlist_name,
                    u.name AS user
                FROM
                    Track track
                JOIN
                    track_on_Like_Playlist t
                    ON track.Track_id = t.Track_track_id
                JOIN
                    Like_Playlist lp
                    ON t.Like_Playlist_playlist_id = lp.Playlist_id
                JOIN
                    User u
                    ON lp.User_user_id = u.User_id
                WHERE
                    u.name =? ;";

            if(!($stmt = mysqli_prepare($conn, $query))){
                echo "Failed preparation";
            };
            if(!$stmt->bind_param("s", $username)){
                echo "Failed to bind params";
            };
            if(!$stmt->execute()){
                echo "Execution failed";
            }

            $stmt->bind_result($track_name, $length, $genre, $playlist_name, $user);
            $stmt->store_result();
            if($stmt->num_rows == 0){
                echo "<h2>Sorry, This user hasn't liked any songs and has no playlists.</h2>";
            }else{
                $stmt->fetch();
                echo    "<h2 align='center'>$user's liked songs and playlists</h2>";
                /* Header for table */
                echo "<table cellpadding='4'>
                          <tr>
                            <td><b>Track Name</b></td>
                            <td><b>Length</b></td>
                            <td><b>Genre</b></td>
                            <td><b>Playlist Name</b></td>
                          </tr>";
                do{
                    echo "<tr>
                            <td>$track_name</td>
                            <td>$length</td>
                            <td><a href='findByGenre.php?genre=$genre'>$genre</a></td>
                            <td>$playlist_name</td>
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

