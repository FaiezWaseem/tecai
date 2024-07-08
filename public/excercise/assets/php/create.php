<?php
use App\Models\students;
include_once('./utils/generateblanks.php');
include_once('./utils/generatetruefalse.php');
include_once('./utils/generateParts.php');
include_once('./utils/generateMatch.php');
include_once('./utils/generateQuiz.php');


if (isset($_GET['id'])) {

  $id = $_GET['id'];

  $result = (file_get_contents('./data.json'));



  $result = json_decode($result);


  if ($result) {
    $dt = json_decode($result->data);

    if ($dt->type === 'blanks') {

      $outPath = '../../out';

      deleteDirectory($outPath);
      mkdir($outPath);



      copy('../../grade.js', $outPath . "/grade.js");

      copyDirectory('../../template/Fill_in_the_blanks/', $outPath);

      if ($dt->theme == "1" || $dt->theme == 1) {
        copy('../../assets/images/themes/' . $dt->bg, $outPath . "/" . $dt->bg);
      }

      file_put_contents(
        '../../out/data.js',
        'var drop  =  `' . $dt->drop . '`'
        . '; var drag  = `' . $dt->drag . '`'
        . '; var bg  = `' . $dt->bg . '`'
        . '; var theme  = `' . $dt->theme . '`;'
        . '
      document.querySelector(".paragraphcontainer").innerHTML = drag;
      document.querySelector(".selection").innerHTML = drop;
      document.body.style.backgroundImage = `url("${bg}")`;
      '
      );
      redirectToActivity($outPath.'/index.html');
    }
    if ($dt->type === 'truefalse') {
      $ex = new GenerateTrueFalse();
      $ex->setBg("Background_true_false.svg");
      $ex->setTheme($dt->theme);
      $ex->setQuestions(json_decode($dt->questions));
      header('location: ' . $ex->generate(false));
    }
    if ($dt->type === 'parts') {
      $parts = new GenerateParts();
      $parts->setType($dt->typeTheme);
      $parts->setDropImage($dt->dropImage);
      $parts->setBg($dt->bg);
      $parts->setTheme($dt->theme);
      $parts->setPinpoints(json_decode($dt->pinpoints));
      redirectToActivity($parts->generate(false));
    }
    if ($dt->type === 'match') {



      $outPath = '../../out';

      deleteDirectory($outPath);
      mkdir($outPath);



      copy('../../grade.js', $outPath . "/grade.js");

      copyDirectory('../../template/matchcolumn/', $outPath);

      if ($dt->theme == "1" || $dt->theme == 1) {
        copy('../../assets/images/themes/' . $dt->bg, $outPath . "/" . $dt->bg);
      }

      file_put_contents(
        '../../out/data.js',
        'var bg  = `' . $dt->bg . '`'
        . '; var theme  = `' . $dt->theme . '`;'
        . '
        var columnLeftNamesInSequence = ' .$dt->columnleft  . ',
        columnRightNamesInSequence = ' .$dt->columnright  . '  ;
      document.body.style.backgroundImage = `url("${bg}")`;
      '
      );
  
      redirectToActivity($outPath.'/index.html');

    }
    if ($dt->type === 'crossword') {
      if (isset($dt->wordsjson)) {
        $outPath = '../../out';

        deleteDirectory($outPath);
        mkdir($outPath);

        copyDirectory('../../template/crossword', $outPath);
        copy('../../grade.js', $outPath . "/grade.js");
        file_put_contents('../../out/libs/databank.js', 'var wordsJSON = ' . json_encode(json_decode($dt->wordsjson)));

        // Create Zip of Out Folder
        ziptoFolder($outPath, $outPath . '/crosswords.zip');

        // Make A Copy 
        $backupPath = '../../files/' . date("Y-m-d") . '/';
        $fullpath = $backupPath . date("Y-m-d") . '-' . time() . '-crosswords.zip';
        mkdir($backupPath);
        copy($outPath . '/crosswords.zip', $fullpath);

        header('location: ' . $outPath . '/index.html');
      }
    }
    if ($dt->type === 'clue-game') {
      $outPath = '../../out';

      deleteDirectory($outPath);
      mkdir($outPath);

      copyDirectory('../../template/clue-game', $outPath);
      file_put_contents('../../out/assets/libs/databank.js', 'var dataBank  = ' . json_encode(json_decode($dt->datablank)));

      // Create Zip of Out Folder
      ziptoFolder($outPath, $outPath . '/clue-game.zip');

      // Make A Copy 
      $backupPath = '../../files/' . date("Y-m-d") . '/';
      $fullpath = $backupPath . date("Y-m-d") . '-' . time() . '-clue-game.zip';
      mkdir($backupPath);
      copy($outPath . '/clue-game.zip', $fullpath);

      header('location: ' . $outPath . '/index.html');
    }

  }
}


function redirectToActivity($outPath){
  if(isset($_GET['teacher'])){
    header('location: ' . $outPath."?teacher=true");
  }else if(isset($_GET['student'])){
    header('location: ' . $outPath."?student=true"."&id=".$_GET['id']);
  }else if(isset($_GET['token'])){
    header('location: ' . $outPath."?token=". $_GET["token"] ."&id=".$_GET['id']);
  }else{
    echo json_encode(['message' => 'Invlaid Request, Why are u Here :> ' , 'get' => $_GET['student'] ]);
  }
}

?>