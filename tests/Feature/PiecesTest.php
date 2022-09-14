<?php
namespace Tests\Feature;
namespace App;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class PiecesTest extends TestCase
{
    /**
     * Generates pieces and checks their colours.
     *
     * @return void
     */
    public function test_piece_colour() {
        $red = 0xdb0909;
        $blue = 0x132af2;

        for ($i = 0; $i < 10; $i++) { 
            $colour = rand(0, 1);
            $piece = new Piece($colour, $red, $blue);

            $this->assertEquals($piece->getColourInt(), $colour);

            if ($colour == 0)
                $this->assertEquals($piece->getColourHex(), $red);
            else
                $this->assertEquals($piece->getColourHex(), $blue);
        }
    }
}
