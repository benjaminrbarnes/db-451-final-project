<?php

include('connectionData.txt');

$conn = mysqli_connect($server, $user, $pass, $dbname, $port)
or die('Error connecting to MySQL server.');

?>

<html>
    <head>
        <title>Another COMPLEX PHP-MySQL Program</title>
    </head>

    <body bgcolor="white">
        <hr>


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
                    ON r.Artist_artist_id = art.Artist_id;"
        ?>
        <p>
            Result of query:
        <p>

            <?php
            if(!($stmt = mysqli_prepare($conn, $query))){
                echo "Failed preparation";
            };
            if(!$stmt->bind_param("s", $album)){
                echo "Failed to bind params";
            };
            if(!$stmt->execute()){
                echo "execution failed";
            }

            $stmt->bind_result($album_name, $track_name, $length, $genre, $artwork_link, $release_year, $artist, $city);
            $stmt->store_result();
            echo"<p>num of rows: $stmt->num_rows</p>";
//            if($stmt->num_rows == 0){
//                echo "<h2>Sorry, We don't have that album</h2>";
//            }else{
                print "<pre>";
                while($stmt->fetch()){
                    printf("%s %s %s %s %s %s %s %s\n", $album_name, $track_name, $length, $genre, $artwork_link, $release_year, $artist, $city);
                }
                $stmt->close();
                print "</pre>";
//            }

            mysqli_free_result($result);

            mysqli_close($conn);

            ?>

        <p>
        <hr>

        <p>
            <a href="findCustManu.txt" >Contents</a>
            of the PHP program that created this page.

    </body>
</html>

