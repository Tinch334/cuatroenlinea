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
        $this->boardX = $board->getSizeX();
        $this->boardY = $board->getSizeY();
        $winCount = 4;

        echo "CAlled func\n";

        //Horizontal win detection.
        for ($y = 0; $y < $this->boardY; $y++) { 
            $result = $this->lineCheck($board, false, $this->boardX, $y, $winCount);
            if ($result !== NULL) {
                return $result;
            }
        }

        //Vertical win detection.
        for ($x = 0; $x < $this->boardX; $x++) { 
            $result = $this->lineCheck($board, true, $this->boardY, $x, $winCount);
            if ($result !== NULL)
                return $result;
        }

        //Diagonal win detection
        for ($x = 0; $x < $this->boardX - $winCount; $x++) {
            for ($y = $winCount - 1; $y < $this->boardY; $y++) {
                //We check both diagonals, going from top to bottom and from bottom to top.
                $resultUp = $this->diagonalCheck($board, false, $x, $y, $winCount);
                $resultDown = $this->diagonalCheck($board, true, $x, $y, $winCount);

                if ($resultUp !== NULL)
                    return $resultUp;
                else if ($resultDown !== NULL)
                    return $resultDown;
            }
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
    protected function diagonalCheck(Board $board, bool $direction, int $initialX, int $initialY, int $winCount = 4) {
        $lineCounter = new LineCounter($winCount);

        //The ternary operator is used to determine whether "y" should be incremented or decremented, both depending on the direction. The conditions checked in the "for" loop are the upper and lower y bounds of the board as well as the right x bound.
        for ($y = $initialY, $x = $initialX; $y >= 0 && $y < $this->boardY && $x < $this->boardX; ($direction == false) ? $y++ : $y--, $x++) {
            //Get corresponding piece.
            $piece = $board->getSpace($x, $y);

            //We send the current piece to the line counter.
            $result = $lineCounter->LineCount($piece);

            if ($result !== NULL)
                return $result;
        }

        echo "Left\n";

        return NULL;
    }
}


//The reason for creating a class to house the "LineCount" function is to deal with the need to preserve variables between function calls. Particularly "currentColour" and "colourCount", and to avoid passing arguments by reference or doing other hacks/workarounds.
class LineCounter {
    protected ?int $currentColour = NULL;
    protected int $colourCount = 0;
    protected int $winCount;

    public function __construct(int $winCount) {
        $this->winCount = $winCount;
    }

    //This function is to be called with every piece to be checked as argument. It checks that there are "winCount" pieces in a line passed to it.
    public function LineCount(?Piece $piece): ?Piece {
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