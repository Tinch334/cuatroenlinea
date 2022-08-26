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

$redPiece = new Piece(0, -1, -1);
$bluePiece = new Piece(1, -1, -1);


//Create a diagonal line of red pieces starting at the bottom left.
for ($x = 0; $x < 3; $x++) {
    for ($i = 0; $i <= $x; $i++) {
        $board->throwPiece($redPiece, $x);
    }
}

$board->throwPiece($bluePiece, 3);
$board->throwPiece($bluePiece, 3);
$board->throwPiece($bluePiece, 3);
$board->throwPiece($redPiece, 3);

if ($detectWin->detectWin($board) == NULL)
    echo "No win";
else
    echo "Win";

echo "\n\n";

?>