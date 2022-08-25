<?php
namespace App;

use App\Board;
use App\Piece;


interface DetectWinInterface {
    public function detectWin(Board $board): ?Piece; //Handles the logic and function calling.
    public function detectWinFromPiece(Board $board, int $x, int $y, int $winCount): bool; //Check for winning with a "base" piece. The "winCount" variable is to allow to easily change the amount of pieces in a row required to win. 
}


class DetectWin implements DetectWinInterface {
    protected int $xSize;
    protected int $ySize;

    public function detectWin(Board $board): ?Piece {
        $this->xSize = $board->getSizeX();
        $this->ySize = $board->getSizeY();

        for ($x = 0; $x < $this->xSize; $x++) { 
            for ($y = 0; $y < $this->ySize; $y++) { 
                //We check to see if the space is not empty.
                if ($board->getSpace($x, $y) != NULL) {
                    //If there's been a win we return true, otherwise we keep checking.
                    if ($this->detectWinFromPiece($board, $x, $y, 4)) {
                        //If we win we return the winning piece to be able to get the colour that won.
                        return $board->getSpace($x, $y);
                    }
                }
            }
        }

        //If no winning piece was found we return false.
        return NULL;
    }

    public function detectWinFromPiece(Board $board, int $x, int $y, int $winCount): bool {
        $matchCount = 0;
        $pieceColour = $board->getSpace($x, $y)->getColourInt();

        //Horizontal check. The min check is done to prevent going outside of the boards bounds.
        //The "break" is in place to avoid a situation where we count disconnected pieces. For example without the break, the line "BBRB" would count 3 pieces, when there are only to connected.
        for ($xCount = $x; $xCount < min($x + 3, $this->xSize); $xCount++) { 
            //We check if the current piece has the same colour as the base piece.
            if ($board->getSpace($xCount, $y)->getColourInt() == $pieceColour)
                $matchCount++;
            else
                break;
        }

        if ($matchCount >= $winCount)
            return true;
        
        //If we didn't find a match to the right we try to the left.
        for ($xCount = $x; $xCount > max($x - 3, 0); $xCount--) { 
            //We check if the current piece has the same colour as the base piece.
            if ($board->getSpace($xCount, $y)->getColourInt() == $pieceColour)
                $matchCount++;
            else
                break;
        }

        if ($matchCount >= $winCount)
            return true;

        return false;
    }
}

?>