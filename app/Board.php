<?php
namespace App;


//Note that all positions start counting at zero.
interface BoardInterface {
    public function throwPiece(Piece $piece, int $xPos): bool; //Returns true if piece was inserted successfully.
    public function getSpace(int $xPos, int $yPos): ?Piece; //Allows for returning either a "Piece" or NULL.
    public function clearBoard();
    public function getSize(): array; //First index is x size, second index is y size.
}


class Board implements BoardInterface {
    //The x and y size of the board in "spaces".
    protected int $xSize;
    protected int $ySize;
    protected array $board;

    function __construct(int $xSize, int $ySize) {
        if ($xSize < 0) {
            //Exception

            return;
        }
        if ($ySize < 0) {
            //Exception

            return;
        }

        $this->xSize = $xSize;
        $this->ySize = $ySize;

        $this->clearBoard();
    }

    public function throwPiece(Piece $piece, int $xPos): bool{
        if ($xPos > $this->xSize)
            return; //Exception

        //We've reached the top of this column.
        if (count($this->board[$xPos]) >= $this->ySize) {
            return false;
        }

        //Add piece to the end of the corresponding column.
        $this->board[$xpos][] = $piece;
        return true;

        return false;
    }

    public function getSpace(int $xPos, int $yPos): ?Piece {
        if ($xPos > $this->xSize || $xPos < 0 || $yPos > $this->ySize || $ypos < 0)
            return; //Exception

        //Since the board is cleared on the constructor we won't have uninitialized indexes, therefore we can return safely. 
        return $this->board[$xPos][$yPos];
    }

    public function clearBoard() {
        //Sets all board spaces to "NULL".
        for ($x=0; $x < $this->xSize; $x++) { 
            for ($y=0; $y < $this->ySize; $y++) { 
                $this->board[$x][$y] = NULL;
            }
        }
    }

    public function getSize(): array {
        return array($this->xSize, $this->ySize);
    }
}

?>