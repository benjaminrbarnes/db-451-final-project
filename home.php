
<?php

include('connectionData.txt');

$conn = mysqli_connect($server, $user, $pass, $dbname, $port)
or die('Error connecting to MySQL server.');

?>

<html>
    <head>
           <title>Music Finder</title>
    </head>

    <body bgcolor="white">
        <h1 align="center">Music Finder</h1>
        <h3 align="center">Your favorite music source</h3>

        <!--<hr width="70%">-->

        <div align="center">
            <table cellpadding="10" >
                <tr>
                    <td align="center"><a href="test.html">Search By Artist</a></td>
                    <td align="center"><a href="test.html">Search By Track</a></td>
                    <td align="center"><a href="test.html">Search By Genre</a></td>
                </tr>
                <tr>
                    <td align="center"><a href="test.html">Search By Album</a></td>
                    <td align="center"><a href="test.html">Find New Playlists</a></td>
                    <td align="center"><a href="test.html">Find Random Artist</a></td>
                </tr>
            </table>
            <!--<p> Please enter a manufacturer ("Anza", "Hero", etc). <p>-->
            <!--<form action="findCustManu.php" method="POST">-->
                <!--<input type="text" name="state"> <br>-->
                <!--<input type="submit" value="submit">-->
                <!--<input type="reset" value="erase">-->
            <!--</form>-->
        </div>

        <hr width="10%">
        <div align="center">

            <h2>New Releases</h2>
            <table cellpadding="10" >
                <?php
                $query = "SELECT location FROM album_art limit 6;";
                if(!($stmt = mysqli_prepare($conn, $query))){
                    echo "it has failed preparation";
                };
                //            if(!$stmt->bind_param("ss", $state, $state)){
                //                echo "failed to bind params";
                //            };
                if(!$stmt->execute()){
                    echo "execution failed";
                }

                $stmt->bind_result($col1);
                //            print "<pre>";
                $row = 1;
                echo "<tr>";
                while($stmt->fetch()){
                    if($row % 3 == 0 && $row != $stmt->num_rows){
                        echo "</tr>";
                        echo "<tr>";
                    } else if($row == $stmt->num_rows){
                        echo "<td><img src='$col1' style='width: 300px; height: 300px;'></img></td>";
                        echo "</tr>";
                        break;
                    }
//                    printf("%s\n", $col1);
                    echo "<td><img src='$col1' style='width: 300px; height: 300px;'></img></td>";
                    $row++;

                }
                $stmt->close();
                //            print "</pre>";
                mysqli_free_result($result);
                mysqli_close($conn);
                ?>
<!--                <tr>-->
<!--                    <td><img src="https://s3.amazonaws.com/rapgenius/kanye-west-graduation-album-cover.jpeg" style="width: 300px; height: 300px;"></img></td>-->
<!--                    <td><img src="https://upload.wikimedia.org/wikipedia/en/4/48/Snoop_Dogg_-_Snoopified._The_Best_Of.jpg" style="width: 300px; height: 300px;"></img></td>-->
<!--                    <td><img src="http://pitchfork-cdn.s3.amazonaws.com/content/OXYMORON_FRONT_DELUXE.jpg?wmode=transparent" style="width: 300px; height: 300px;"></img></td>-->
<!--                </tr>-->
<!--                <tr>-->
<!--                    <td><img src="https://upload.wikimedia.org/wikipedia/commons/7/72/Nirvana_album_cover.jpg" style="width: 300px; height: 300px;"></img></td>-->
<!--                    <td><img src="https://theindiegirlsguideto.files.wordpress.com/2009/02/foals-antidotes-cover.jpg" style="width: 300px; height: 300px;"></img></td>-->
<!--                    <td><img src="https://upload.wikimedia.org/wikipedia/en/3/3b/Dark_Side_of_the_Moon.png" style="width: 300px; height: 300px;"></img></td>-->
<!--                </tr>-->
            </table>
        </div>
        <hr width="70%">
        <div align="center">
            <p><a href="findCust.txt" >Contents</a> of this page.<p>
            <p><a href="findCustManu.txt" >Contents</a> of the PHP page that gets called. (And the
            <a href="connectionData.txt" >connection data</a>, kept separately for security reasons.)</p>
        </div>

    </body>
</html>
