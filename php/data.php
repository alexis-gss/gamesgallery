<?php
  //Caractères utilisés pour le remplacement
  $characterDollar = '$';
  $characterLivre = '£';

  //Chemin d'origine pour trouver tous les dossiers/images
  $pathOrigin = 'img/';

  //Définition des tableaux
  $pathGames = array();
  $nameGames = array();
  $img = array();
  $allSrcImg = array();
  $tabSrc = array();

  //récupération de tous les dossiers
  foreach (new DirectoryIterator($pathOrigin) as $name) {
    if($name->isDot()) continue;
    array_push($nameGames, $name->getFilename());
    $srcFile = array('src'=> $pathOrigin . $name->getFilename() . '/');
    array_push($pathGames, $srcFile['src']);
  }

  //récupération de toutes les images de tous les dossiers
  foreach ($pathGames as $value) {
    $img = array();
    foreach (new DirectoryIterator($value) as $file) {
      if($file->isDot()) continue;
      $srcFile = array("src"=> $value . $file->getFilename());
      array_push($img, $srcFile['src']);
    }
    array_push($allSrcImg, $img);
  }

  //trie toutes les images en fonction de leur nom
  for ($i = 0 ; $i < count($allSrcImg) ; $i ++) { 
    asort($allSrcImg[$i]);
  }

  for ($i = 0 ; $i < count($nameGames) ; $i ++) {
    //détecte si un dossier doit être créer et à quel nom
    if (strpos($nameGames[$i], $characterLivre)) {
      $folder = explode($characterLivre, $nameGames[$i])[0];
      $folder = replacement($folder, $characterDollar);
    }
    else{
      $folder = false;
    }
    $name = replacement($nameGames[$i], $characterDollar);
    
    //création d'un tableau json
    $temp = array(
      "name" => $name,
      "folder" => $folder,
      "src" => implode(";", $allSrcImg[$i])
    );
    array_push($tabSrc, $temp);
  }

  array_multisort(array_column($tabSrc, 'name'), SORT_ASC, $tabSrc);
  $tabSrc = json_encode($tabSrc);

  function replacement($target, $characterDollar){
    return str_replace($characterDollar, ':', str_replace($characterDollar, ':', $target));
  }

  include 'js/main.php';
?>