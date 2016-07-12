<?php
  // Get Yasp profile ID from URL
  if(!isset($_GET['yID']) || empty($_GET['yID'])) {
    echo 'Erreur: argument yID manquant.';
    header($_SERVER["SERVER_PROTOCOL"]." 400 Bad Request", true, 400);
    die;
  }

  $yaspProfileID = intval($_GET['yID']);

  // Avoid a bug with SSL validation
  $arrContextOptions = array(
    "ssl" => array(
      "verify_peer" => false,
      "verify_peer_name" => false,
    ),
  );

  // Get the Yasp profile of the player
  $file = file_get_contents('https://yasp.co/players/'.$yaspProfileID, false, stream_context_create($arrContextOptions));

  // Search for the MMR on the page
  if (preg_match('/<span class="text-info rating"><span><abbr title="Solo MMR"><i class="fa fa-fw fa-user"><\/i><\/abbr><\/span><small style="margin-left:.5em">([0-9]{4})<\/small><\/span>/i', $file, $matches)) {
    // MMR founded
    // Return a JSON containing the MMR founded
    echo json_encode(array('mmr' => $matches[1]));
    
    header('Content-Type: application/json');
    
    die;
  } else {
    // MMR not founded
    // Returns an error
    echo 'Erreur: Impossible de trouver le MMR';
    
    header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", true, 404);
    
    die;
  }
?>
