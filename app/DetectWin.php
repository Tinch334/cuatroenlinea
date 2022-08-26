<?php
namespace App;

use App\Board;
use App\Piece;


interface DetectWinInterface {
    public function detectWin(Board $board): ?Piece; //Handles the logic and function calling.
}


class DetectWin implements DetectWinInterface {
    protected Board $board;

    public function detectWin(Board $board): ?Piece {
        $this->board = $board;

        for ($x = 0; $x < $this->board->getSizeX(); $x++) { 
            for ($y = 0; $y < $this->board->getSizeY(); $y++) { 
                //We check to see if the space is not empty.
                if ($this->board->getSpace($x, $y) != NULL) {
                    //If there's been a win we return true, otherwise we keep checking.
                    if ($this->detectWinFromPiece($x, $y, 4)) {
                        //If we win we return the winning piece to be able to get the colour that won.
                        return $this->board->getSpace($x, $y);
                    }
                }
            }
        }

        //If no winning piece was found we return false.
        return NULL;
    }

    //Check for winning with a "base" piece. The "winCount" variable is to allow to easily change the amount of pieces in a row required to win. 
    protected function detectWinFromPiece(int $x, int $y, int $winCount): bool {
        $matchCount = 0;
        $pieceColour = $this->board->getSpace($x, $y)->getColourInt();

        //HORIZONTAL WIN CHECK
        //The min check is done to prevent going outside of the boards bounds.
        //The "break" is in place to avoid a situation where we count disconnected pieces. For example without the break, the line "BBRB" would count 3 pieces, when there are only to connected.
        for ($xCount = $x; $xCount < min($x + ($winCount - 1), $this->board->getSizeX()); $xCount++) { 
            if ($this->pieceCheck($this->board->getSpace($xCount, $y), $pieceColour))
                $matchCount++;
            else
                break;
        }

        //If we didn't find a match to the right we try to the left.
        for ($xCount = $x; $xCount > max($x - ($winCount - 1), 0); $xCount--) { 
            if ($this->pieceCheck($this->board->getSpace($xCount, $y), $pieceColour))
                $matchCount++;
            else
                break;
        }

        if ($matchCount >= $winCount)
            return true;

        //VERTICAL WIN CHECK
        //Uses the same logic as the horizontal win check.
        $matchCount = 0; //Reset match count.

        for ($yCount = $y; $yCount < min($y + ($winCount - 1), $this->board->getSizeY()); $yCount++) {
            if ($this->pieceCheck($this->board->getSpace($x, $yCount), $pieceColour))
                $matchCount++;
            else
                break;
        }
        
        //If we didn't find a match to the right we try to the left.
        for ($yCount = $y; $yCount > max($y - ($winCount - 1), 0); $yCount--) { 
            if ($this->pieceCheck($this->board->getSpace($x, $yCount), $pieceColour))
                $matchCount++;
            else
                break;
        }

        if ($matchCount >= $winCount) {
            return true;
        }

        //DIAGONAL WIN CHECK RIGHT
        $matchCount = 0; //Reset match count.

        for ($count = 0; $count < $winCount && $x + $count < $this->board->getSizeX() && $y + $count < $this->board->getSizeY(); $count++) {
            if ($this->pieceCheck($this->board->getSpace($x + $count, $y + $count), $pieceColour)) {
                $matchCount++;
            }
            else
                break;
        }

        for ($count = 0; $count < $winCount && $x - $count >= 0 && $y - $count >= 0; $count++) {
            if ($this->pieceCheck($this->board->getSpace($x - $count, $y - $count), $pieceColour)) {
                $matchCount++;
            }
            else
                break;
        }

        if ($matchCount >= $winCount)
            return true;

        //DIAGONAL WIN CHECK LEFT
        $matchCount = 0; //Reset match count.

        for ($count = 0; $count < $winCount && $x + $count < $this->board->getSizeX() && $y - $count >= 0; $count++) {
            if ($this->pieceCheck($this->board->getSpace($x + $count, $y - $count), $pieceColour)) {
                $matchCount++;
            }
            else
                break;
        }

        for ($count = 0; $count < $winCount && $x - $count >= 0 && $y + $count < $this->board->getSizeY(); $count++) {
            if ($this->pieceCheck($this->board->getSpace($x - $count, $y + $count), $pieceColour)) {
                $matchCount++;
            }
            else
                break;
        }

        return false;
    }

    //Takes a piece and a colour and checks if the colour of the piece matches the colour. Note, the "?Piece" means that the argument can either be an object or "NULL".
    protected function pieceCheck(?Piece $pieceToCheck, int $pieceColour): bool {
        //Make sure we are not checking an empty space.
        if ($pieceToCheck == NULL) {
            return false;
        }

        //We check if the current piece has the same colour as the base piece.
        if ($pieceToCheck->getColourInt() == $pieceColour)
            return true;
        else
            return false;
    }
}

?>