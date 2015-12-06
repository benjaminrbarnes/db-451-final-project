
<?php

include('connectionData.txt');

$conn = mysqli_connect($server, $user, $pass, $dbname, $port)
or die('Error connecting to MySQL server.');

?>
<html>
    <head>
        <title>Search By City</title>
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
            if($_GET['city'] == ""){
                $city = $_POST['city'];
            } else {
                $city = $_GET['city'];
            }

            $query =
                "SELECT
                    a.Artist_name,
                    a.City
                FROM
                    Artist a
                WHERE
                    a.City =? ;";

            if(!($stmt = mysqli_prepare($conn, $query))){
                echo "Failed preparation";
            };
            if(!$stmt->bind_param("s", $city)){
                echo "Failed to bind params";
            };
            if(!$stmt->execute()){
                echo "Execution failed";
            }

            $stmt->bind_result($artist_name, $artist_city);
            $stmt->store_result();
            if($stmt->num_rows == 0){
                echo "<h2>Sorry, We don't have any artists from that city</h2>";
            }else{
                $stmt->fetch();
                echo "<h2 align='center'>Artists from $artist_city</h2>";
                echo "<table cellpadding='4'>";
                do{
                    echo "<tr>
                            <td><a href='findByArtist.php?artist=$artist_name'>$artist_name</a></td>
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

