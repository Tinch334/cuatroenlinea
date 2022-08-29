<?php
namespace App;

use App\Board;
use App\DetectWin;


interface PieceInterface {
    public function getColourInt(): int;
    public function getColourHex(): number;
}


class Piece implements PieceInterface {
    protected int $colour; //A 0 means red, a 1 means blue.
    protected int $redColour;
    protected int $blueColour;

    //Recommended red colour: 0xdb0909, recommended blue colour: 0x132af2.
    function __construct(int $pieceColour, int $redColour, int $blueColour) {
        if ($pieceColour < 0 && $pieceColour > 1) {
            throw new \Exception("Invalid colour used when initializing piece, with value: ".$pieceColour);
            $this->colour = 0; //In case of an exception we default to red.
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