<?php
namespace App;

use App\Board;
use App\Piece;
use App\DetectWin;

include "Board.php";
include "Piece.php";
include "DetectWin.php";

$board = new Board();
$detectWin = new DetectWin();

$bluePiece = new Piece(0, -1, -1);

for ($i = 0; $i < 4; $i++) { 
    $board->throwPiece($bluePiece, $i);
}

if ($detectWin->detectWin($board) == NULL)
    echo "No win";
else
    echo "Win";

echo "\n\n";

?>