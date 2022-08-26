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

$board->throwPiece($bluePiece, 0);
$board->throwPiece($bluePiece, 0);
$board->throwPiece($bluePiece, 0);
$board->throwPiece($redPiece, 0);

for ($x = 1; $x < 4; $x++) {
    for ($i = 0; $i < 4 - $x; $i++) {
        $board->throwPiece($redPiece, $x);
    }
}

$board->printBoard();

if ($detectWin->detectWin($board) == NULL)
    echo "\nNo win";
else
    echo "\nWin";

echo "\n\n";

?>