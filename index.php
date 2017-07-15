<?php
$exists = false;
if (isset($_GET['user'])) {
  require_once 'includes/php/settings.php'; // Contains osu! token
  require_once 'includes/php/countries.php'; // Contains ISO3166-1 alpha-2 -> full name conversions

  ini_set("allow_url_fopen", 1); // Required for file_get_contents

  function getCountry($code) { // Returns the full country name given the $code

    if (isset($code)) {

      global $countries; // Allows us to access $countries from includes/php/countries.php
      return $countries[$code]; // Gets the name from the $code listed in includes/php/countries.php
    } else {
      return null;
    }
  }

  function getStats($urlUsername) { // Returns the $urlUsername 's osu! stats
    global $osu_token; // Allows us to access $osu_token from includes/php/settings.php
    $contents = file_get_contents('https://osu.ppy.sh/api/get_user?k=' . $osu_token . '&u=' . $urlUsername); // Gets the JSON contents of the url (osu!api)
    $decoded = json_decode($contents); // Decodes (HTML -> JSON) the above url.

    if (array_key_exists(0, $decoded)) {
      return (Array) $decoded[0];
    } else {
      return null;
    }
  }

  ini_set("allow_url_fopen", 0); // Stops allowing URL-aware fopen wrappers (always good to keep off unless being used)

  $stats = getStats($_GET['user']); // Retreieves the stats for user using the above function

  $exists = true;

  if ($stats == null) {
    $exists = false;
  }

  if ($exists == true) {
    $userid = $stats['user_id']; // Gets the user id
    $username = $stats['username']; // Gets the username
    $count300 = $stats['count300']; // Count of 300 hits
    $count100 = $stats['count100']; // Count of 100 hits
    $count50 = $stats['count50']; // Count of 50 hits
    $playcount = $stats['playcount']; // Total plays
    $rankedScore = $stats['ranked_score']; // Ranked score (only best on only ranked maps)
    $totalScore = $stats['total_score']; // Total score
    $rank = $stats['pp_rank']; // Rank
    $level = $stats['level']; // Level
    $pp = $stats['pp_raw']; // Their amt of pp
    $acc = $stats['accuracy']; // Accuracy
    $ss = $stats['count_rank_ss']; // SS (X) rank count
    $s = $stats['count_rank_s']; // S rank count
    $a = $stats['count_rank_a']; // A rank count
    $country = getCountry($stats['country']); // Gets the *full* country name
    $countryRank = $stats['pp_country_rank']; // Rank in their country
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Landon | osu!stats</title>

  <!-- Google fonts and CSS -->
  <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
  <link rel="stylesheet" href="includes/css/style.css" type="text/css">

  <!-- JS and libraries -->
  <script type="text/javascript" src="includes/js/main.js"></script>
</head>
<body>
  <header>
    <div class="container">
      <div id="branding">
        <h1>DUPLICATION</h1>
      </div>
      <nav>
        <ul>
        </ul>
      </nav>
    </div>
  </header>
  <br />
  <div class="container">
    <form method="POST">
      <input type="text" name="token" placeholder="osu!API token" />
      <input type="submit" value="Update token" />
    </form>
    <br />
    <form method="GET">
      <input type="text" name="user" placeholder="Search users..." />
      <input type="submit" value="Search" />
    </form>
    <br />
    <div class="user">
      <?php
      if ($exists) {
      ?>
        <h1>osu! stats:</h1>
        <p><b>User ID:</b> <?php echo $userid ?></p>
        <p><b>Username:</b> <?php echo $username ?></p>
        <p><b>Country:</b> <?php echo $country ?></p>

        <p><b>PP:</b> <?php echo $pp ?></p>
        <p><b>Rank:</b> #<?php echo $rank ?></p>
        <p><b>Accuracy:</b> <?php echo $acc . "%" ?></p>
        <p><b>Country rank:</b> #<?php echo $countryRank ?></p>
        <p><b>Level:</b> <?php echo $level ?></p>
        <p><b>SS count:</b> <?php echo $ss ?></p>
        <p><b>S count:</b> <?php echo $s ?></p>
        <p><b>A count:</b> <?php echo $a ?></p>
        <p><b>Score:</b> <?php echo $totalScore ?></p>
        <p><b>300 count:</b> <?php echo $count300 ?></p>
        <p><b>100 count:</b> <?php echo $count100 ?></p>
        <p><b>50 count:</b> <?php echo $count50 ?></p>
      <?php
      } else {
      ?>
      <p>User does not exist. Please try again!</p>
      <?php
      }
      ?>
    </div>
  </div>
</body>
</html>
