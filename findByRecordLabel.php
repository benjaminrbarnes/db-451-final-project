
<?php

include('connectionData.txt');

$conn = mysqli_connect($server, $user, $pass, $dbname, $port)
or die('Error connecting to MySQL server.');

?>
<html>
    <head>
        <title>Search By Record Label</title>
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
            if($_GET['label'] == ""){
                $label = $_POST['label'];
            } else {
                $label = $_GET['label'];
            }

            $query =
                "SELECT
                    art.Artist_name,
                    art.City,
                    rc.Company_name,
                    co.owner_name
                FROM
                    Artist art
                JOIN
                    Record_Company rc
                    ON rc.RC_id = art.Record_Company_RC_id
                JOIN
                    Company_Owner co
                    ON co.owner_id = rc.Company_Owner_owner_id
                WHERE
                    rc.Company_name =? ;";

            if(!($stmt = mysqli_prepare($conn, $query))){
                echo "Failed preparation";
            };
            if(!$stmt->bind_param("s", $label)){
                echo "Failed to bind params";
            };
            if(!$stmt->execute()){
                echo "Execution failed";
            }

            $stmt->bind_result($artist_name, $artist_city, $record_company, $owner_name);
            $stmt->store_result();
            if($stmt->num_rows == 0){
                echo "<h2>Sorry, We don't have any artists under that Record Label</h2>";
            }else{
                $stmt->fetch();
                echo "<h2 align='center'>Artists under $record_company</h2>
                      <h3 align='center'>Record Label owned by $owner_name</h3>";
                echo "<table cellpadding='4'>
                      <tr>
                        <td><b>Artist</b></td>
                        <td><b>City</b></td>
                      </tr>";
                do{
                    echo "<tr>
                            <td><a href='findByArtist.php?artist=$artist_name'>$artist_name</a></td>
                            <td><a href='findByCity.php?city=$artist_city'>$artist_city</a></td>
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

