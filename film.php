<?php
    require("connection.php");

    $film_id = $_GET['film'];
    // echo($film_id);
	$apiKey = "df1323af";

	function fetch_film_info($api_key, $film_id) {

        $query = array(
            "apikey" => $api_key,
            "i" => $film_id,
            "plot" => "full"
        );
		$url = "http://www.omdbapi.com/?".http_build_query($query);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$response = curl_exec($ch);

		curl_close($ch);
		$data = json_decode($response);
		return $data;
    }
    
    $sql = sprintf("SELECT trailer FROM films WHERE imdb_id='%s'", $film_id);
    $result = $conn->query($sql); 
    if ($result->num_rows > 0) {
            // output data of each row
        while($row = $result->fetch_assoc()) {
            $trailer_video_url = $row["trailer"];
            break;
        }
    }

    $data = fetch_film_info($apiKey, $film_id);
    $trailer_video_url = "trailers/".$trailer_video_url;
    // echo json_encode($data, JSON_PRETTY_PRINT);
?>

<!DOCTYPE html>
<html lang="en">

	<head>
		<title>Harry Potter Movie List</title>
		<!--bootstrap-css-->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		<!--My css style-->
		<link rel="stylesheet" href="css/styles.css">
        <!-- title icon-->
        <link type="image/x-icon" rel="icon" href="images/icon.svg">

	</head>

	<body class="bg">

		<div class="container">
            <div class="col-12">
                    <center><a href="index.php"><img class="subpage-logo" src="images/logo.png" height="150px"></a></center>
                </div>
                <div class="row">
                    <div class="col-12 col-md-12 series-title">
                        <?php
                        echo sprintf("<h1>%s</h1>", $data->Title);
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-3">
                        <?php
                            echo sprintf("<p><img class='sub-series-img' src='%s' width='100%%' ></p>", $data->Poster);
                        ?>
                    </div>
                    <div class="col-12 col-md-9">
                        <p class="plotTitle"><strong>Plot</strong></p>
                        <?php echo sprintf("<p class='plot'>%s</p>", $data->Plot);?>
                        <br>
                        <?php
                            foreach ($data->Ratings as $ratings) {
                                echo sprintf("<p class='ratings'><strong>%s:</strong> %s</p><br>", $ratings->Source, $ratings->Value);
                            }
                        ?>
                    </div>
                    <div class="col-12 col-md-12 trailer">
                    <video width='100%' controls > 
                            <?php 
                                echo sprintf("<source src='%s' type='video/mp4' />", $trailer_video_url);
                            ?>
                    </video>         
                    </div>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    </body>
</html>