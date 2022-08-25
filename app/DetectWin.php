<?php
namespace App;


interface DetectWinInterface {
    public function detectWin(Board $board): ?Piece; //Handles the logic and function calling.
    private function detectWinFromPiece(Board $board, int $x, int $y, int $winCount): bool; //Check for winning with a "base" piece. The "winCount" variable is to allow to easily change the amount of pieces in a row required to win. 
}


class DetectWin implements DetectWinInterface {
    protected int $xSize;
    protected int $ySize;

    public function detectWin(Board $board): ?Piece {
        $this->xSize = $board->getSizeX();
        $this->ySize = $board->getSizeY();

        for ($x = 0; $x < $xSize; $x++) { 
            for ($y = 0; $y < $ySize; $y++) { 
                //We check to see if the space is not empty.
                if (board->getSpace($x, $y) != NULL) {
                    //If there's been a win we return true, otherwise we keep checking.
                    if (detectWinFromPiece($board, $x, $y, 4)) {
                        //If we win we return the winning piece to be able to get the colour that won.
                        return board->getSpace($x, $y);
                    }
                }
            }
        }

        //If no winning piece was found we return false.
        return NULL;
    }

    private function detectWinFromPiece(Board $board, int $x, int $y, int $winCount): bool {
        return false
    }
}

?>