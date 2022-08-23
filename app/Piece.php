<?php
namespace App;


interface PieceInterface {
    public function getColourInt(): int;
    public function getColourHex(): number;
}


class Piece implements PieceInterface {
    protected int $colour; //A 0 means red, a 1 means blue.
    protected number $redColour;
    protected number $blueColour;

    function __construct(int $pieceColour, number $redColour = 0xdb0909, number $blueColour = 0x132af2) {
        if ($pieceColour < 0 && $pieceColour > 1) {
            throw new \Exception("Invalid colour used when initializing piece, with value: ".$pieceColour);
            $this->colour = 0 //In case of an exception we default to red.

            return;
        }

        $this->colour = $pieceColour;
        $this->redColour = $redColour;
        $this->blueColour = $blueColour;
    }

    public function getColourInt(): int {
        return $this->colour;
    }

    public function getColourHex(): number {
        if ($this->colour == 0) {
            return $this->redColour; //Red colour
        }
        //We don't need to check with an "else if" because the constructor only allows for red or blue.
        else {
            return $this->blueColour; //Blue colour
        }
    }
}

?>