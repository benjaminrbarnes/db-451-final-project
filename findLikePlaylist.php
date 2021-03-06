
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
            if($_GET['username'] == ""){
                $username = $_POST['username'];
            } else {
                $username = $_GET['username'];
            }

            $query =
                "SELECT
                    track.Track_name,
                    album.Album_name,
                    artist.Artist_name,
                    track.Length,
                    track.Genre,
                    lp.name AS playlist_name,
                    u.name AS user
                FROM
                    Track track
                JOIN
                    Album album
                    ON album.Album_id = track.Album_fk_id
                JOIN
                    Artist artist
                    ON artist.Artist_id = album.Artist_artist_id
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

            $stmt->bind_result($track_name, $album_name, $artist_name, $length, $genre, $playlist_name, $user);
            $stmt->store_result();
            if($stmt->num_rows == 0){
                echo "<h2>Sorry, this user either doesn't exist or hasn't liked any songs and has no playlists.</h2>";
            }else{
                $stmt->fetch();
                echo    "<h2 align='center'>$user's liked songs and playlists</h2>";
                /* Header for table */
                echo "<table cellpadding='4'>
                          <tr>
                            <td><b>Track Name</b></td>
                            <td><b>Album Name</b></td>
                            <td><b>Artist Name</b></td>
                            <td><b>Length</b></td>
                            <td><b>Genre</b></td>
                            <td><b>Playlist Name</b></td>
                          </tr>";
                do{
                    echo "<tr>
                            <td>$track_name</td>
                            <td><a href='findByAlbum.php?album=$album_name'>$album_name</a></td>
                            <td><a href='findByArtist.php?artist=$artist_name'>$artist_name</a></td>
                            <td>$length</td>
                            <td><a href='findByGenre.php?genre=$genre'>$genre</a></td>
                            <td>$playlist_name</td>
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

