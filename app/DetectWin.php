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
        $this->$boardX = $board->getSizeX();
        $this->$boardY = $board->getSizeY();

        //Horizontal win detection.
        for ($y = 0; $y < $this->$boardY; $y++) { 
            $result = $this->lineCheck($board, false, $this->$boardX, $y);
            if ($result !== NULL) {
                return $result;
            }
        }

        //Vertical win detection.
        for ($x = 0; $x < $this->$boardX; $x++) { 
            $result = $this->lineCheck($board, true, $this->$boardY, $x);
            if ($result !== NULL)
                return $result;
        }

        //If no winning piece was found we return false.
        return NULL;
    }

    
    //Checks for a win in a line either horizontal or vertical. If "axis" is false it checks horizontally otherwise vertically.
    protected function lineCheck(Board $board, bool $axis, int $limit, int $fixedAxis, int $winCount = 4): ?Piece {
        $lineCounter = new LineCounter($winCount);

        for ($i = 0; $i < $limit; $i++) {
            //We use the counter to get a horizontal or vertical piece depending on "axis".
            $piece = ($axis == false) ? $board->getSpace($i, $fixedAxis) : $board->getSpace($fixedAxis, $i);
            //We send the current piece to the line counter.
            $result = $lineCounter->LineCount($piece);

            if ($result !== NULL)
                return $result;
        }

        //If no result was found we return NULL.
        return NULL;
    }

    //Checks for a win in a diagonal line either bottom to top or top to bottom. If "direction" is false checks it checks bottom to top otherwise top to bottom.
    protected function diagonalCheck(Board $board, bool $direction, int $xOffest, int $yOffset, int $winCount = 4) {
        //The x condition is checked in the for loops condition, the height condition is checked inside the loop since it depends on the direction
        for ($i = 0; $i < $count + $xOffest > $this->boardX - ($winCount - 1); $i++) { 
            //This checks for the y condition depending on the direction.
            if ($direction === false)
                if ($count + yOffset < $this->boardY - $winCount - 1)
                    break;
            else
                if ($this->boardY - $count - $yOffset > $winCount - 1)
                    break

            //We get the piece using the appropriate offsets.
            $piece = $board->getSpace($i + $xOffest, $i + $yOffset);
            //We send the current piece to the line counter.
            $result = $lineCounter->LineCount($piece);

            if ($result !== NULL)
                return $result;
        }

        //If no result was found we return NULL.
        return NULL;
    }
}


//The reason for creating a class to house the "LineCount" function is to deal with the need to preserve variables between function calls. Particularly "currentColour" and "colourCount", and to avoid passing arguments by reference or doing other "weird" hacks/workarounds.
class LineCounter {
    protected int $currentColour = NULL;
    protected int $colourCount = 0;
    protected int $winCount;

    public function __construct(int $winCount) {
        $this->winCount = $winCount;
    }


    //This function is to be called with every piece to be checked as argument. It checks that there are "winCount" pieces in a line passed to it.
    public function LineCount(Piece $piece): ?Piece {
        //If we reach an empty space we reset the current colour and the colour count.
        if ($piece === NULL) {
            $this->currentColour = NULL;
            $this->colourCount = 0;
        }
        else {
            //If we have no "currentColour" we set it to the current piece.
            if ($this->currentColour === NULL) {
                $this->currentColour = $piece->getColourInt();
                $this->colourCount++;
            }
            else {
                if ($this->currentColour === $piece->getColourInt()) {
                    $this->colourCount++;
                }
                //If the pieces have a different colour reset the counter.
                else {
                    $this->colourCount = 0;
                }
            }
            
        }

        //If we reach the win count we return the wining piece
        if ($this->winCount == $this->colourCount)
            return $piece;
        else
            return NULL;
    }
}
?>