<?php
namespace App;

use App\Board;
use App\Piece;


interface DetectWinInterface {
    public function detectWin(Board $board): ?Piece; //Handles the logic and function calling.
}


class DetectWin implements DetectWinInterface {
    protected Board $board;
    protected int $boardX;
    protected int $boardY;

    public function detectWin(Board $board): ?Piece {
        $this->board = $board;
        $boardX = $board->getSizeX();
        $boardY = $board->getSizeY();

        //Horizontal win detection.
        for ($y = 0; $y < $boardY; $y++) { 
            $result = $this->lineCheck($board, false, $boardX, $y);
            if ($result !== NULL) {
                echo "Return time\n\n";
                return $result;
            }
        }

        //Vertical win detection.
        for ($x = 0; $x < $boardX; $x++) { 
            $result = $this->lineCheck($board, true, $boardY, $x);
            if ($result !== NULL)
                return $result;
        }

        //If no winning piece was found we return false.
        return NULL;
    }

    
    //Checks for a win in a line either horizontal or vertical. If "axis" is false checks horizontally otherwise vertically.
    protected function lineCheck(Board $board, bool $axis, int $limit, int $fixedAxis, int $count = 4): ?Piece {
        $currentColour = NULL;
        $colourCount = 0;

        for ($i = 0; $i < $limit; $i++) {
            //We use the counter to get a horizontal or vertical piece depending on "axis".
            $piece = ($axis == false) ? $board->getSpace($i, $fixedAxis) : $board->getSpace($fixedAxis, $i);

            //If we reach an empty space we reset the current colour and the colour count.
            if ($piece === NULL) {
                $currentColour = NULL;
                $colourCount = 0;
            }
            else {
                //If we have no "currentColour" we set it to the current piece.
                if ($currentColour === NULL) {
                    $currentColour = $piece->getColourInt();
                    $colourCount++;
                }
                else {
                    if ($currentColour == $piece->getColourInt()) {
                        $colourCount++;
                    }
                    //If the pieces have a different colour reset the counter.
                    else {
                        $colourCount = 0;
                    }
                }
                
            }

            //If we reach the win count we return the wining piece
            if ($count == $colourCount)
                return $piece;
        }

        return NULL;
    }

    protected function diagonalCheck(Board $board, bool $direction, int $count) {

    }
}

?>