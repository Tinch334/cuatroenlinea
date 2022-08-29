<?php
namespace App;

use App\Piece;
use App\DetectWin;


//Note that all positions start counting at zero.
interface BoardInterface {
    public function throwPiece(Piece $piece, int $xPos): bool; //Returns true if piece was inserted successfully.
    public function getSpace(int $xPos, int $yPos): ?Piece; //Allows for returning either a "Piece" or NULL.
    public function clearBoard();
    public function getSizeX(): int;
    public function getSizeY(): int;
}


class Board implements BoardInterface {
    //The x and y size of the board in "spaces".
    protected int $xSize;
    protected int $ySize;
    protected array $board;

    //The constructor uses the predetermined board size by default.
    function __construct(int $xSize = 7, int $ySize = 6) {
        if ($xSize < 1) {
            throw new \Exception("Invalid size used for board width, with value: ".$xSize);
            $this->xSize = 7; //In case of an exception we default to the predetermined board size.
        }
        if ($ySize < 1) {
            throw new \Exception("Invalid size used for board height, with value: ".$ySize);
            $this->xSize = 6; //In case of an exception we default to the predetermined board size.
        }

        $this->xSize = $xSize;
        $this->ySize = $ySize;

        //Initializes all board spaces with "NULL".
        $this->clearBoard();
    }

    public function throwPiece(Piece $piece, int $xPos): bool{
        if ($xPos < 0 || $xPos > $this->xSize)
            throw new \Exception("Invalid column position, with value: ".$xPos);

        //Add piece to the end of the corresponding column, by checking upwards until we find an empty space.
        for ($y = 0; $y < $this->ySize; $y++) {
            if ($this->board[$xPos][$y] == NULL) {
                $this->board[$xPos][$y] = $piece;

                return true;
            }
        }

        //If no empty space was found that means we have reached the top of the column.
        return false;
    }

    public function getSpace(int $xPos, int $yPos): ?Piece {
        //Make sure position is within board bounds.
        if ($xPos > $this->xSize || $xPos < 0 || $yPos > $this->ySize || $yPos < 0)
            throw new \Exception("Invalid row and column position, with values. X: ".$xPos." - Y: ".$yPos);

        //Since the board is cleared on the constructor we won't have uninitialized indexes, therefore we can return safely. 
        return $this->board[$xPos][$yPos];
    }

    public function clearBoard() {
        //Sets all board spaces to "NULL".
        for ($x = 0; $x < $this->xSize; $x++) { 
            for ($y = 0; $y < $this->ySize; $y++) { 
                $this->board[$x][$y] = NULL;
            }
        }
    }

    public function getSizeX(): int {
        return $this->xSize;
    }

    public function getSizeY(): int {
        return $this->ySize;
    }

    /*public function printBoard() {
        for ($y = --$this->ySize; $y >= 0; $y--) { 
            for ($x = 0; $x < $this->xSize; $x++) { 
                if ($this->board[$x][$y] == NULL) {
                    echo "NUL";
                }
                else if ($this->board[$x][$y]->getColourInt() == 0) {
                    echo "RED";
                }
                else {
                    echo "BLU";
                }

                echo "  ";
            }
            echo "\n";
        }
    }*/
}
?>