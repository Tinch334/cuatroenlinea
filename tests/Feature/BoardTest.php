<?php
namespace Tests\Feature;
namespace App;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BoardTest extends TestCase
{
    /**
     * Checks if new boards are empty.
     *
     * @return void
     */
    public function test_empty_board() {
        $width = rand(5, 10);
        $height = rand(5, 10);
        $board = new Board($width, $height);

        //We will count how many non empty spaces there are on the board.
        $nonEmptyCount = 0;

        for ($x = 0; $x < $width; $x++) { 
            for ($y = 0; $y < $height; $y++) { 
                if ($board->getSpace($x, $y) != NULL)
                    $nonEmptyCount++;
            }
        }

        //There should be zero empty spaces.
        $this->assertEquals($nonEmptyCount, 0);
    }

    /**
     * Checks the size of random boards.
     *
     * @return void
     */
    public function test_correct_size() {
        for ($i = 0; $i < 5; $i++) {
            $width = rand(1, 50);
            $height = rand(1, 50);
            $board = new Board($width, $height);

            $this->assertEquals($board->getSizeX(), $width);
            $this->assertEquals($board->getSizeY(), $height);
        }
    }

    /**
     * Checks that boards with an invalid size throw an exception.
     *
     * @return void
     */
    public function test_invalid_board() {
        //We generate five random invalid boards.
        for ($i = 0; $i < 5; $i++) {
            $width = rand(-10, 0);
            $height = rand(-10, 0);

            //All these boards should throw an exception since they have invalid dimensions
            try {
                $board = new Board($width, $height);
            }
            catch (\Exception $e) {
                //When we catch an exception we continue, avoiding the "fail" call.
                continue;
            }

            $this->fail("Allowed creation of invalid board with dimensions X: ".$width." - Y: ".$height);
        }
    }

    /**
     * Checks if a board gets successfully filled.
     *
     * @return void
     */
    public function test_fill_board() {
        $emptyCount = 0;
        $width = rand(5, 10);
        $height = rand(5, 10);
        $board = new Board($width, $height);

        //Fills the board with pieces.
        for ($x = 0; $x < $width; $x++) { 
            for ($y = 0; $y < $height; $y++) { 
                $board->throwPiece(new Piece(rand(1, 2), -1, -1), $x);
            }
        }

        //We count the empty spaces.
        for ($x = 0; $x < $width; $x++) { 
            for ($y = 0; $y < $height; $y++) { 
                if ($board->getSpace($x, $y) == NULL)
                    $emptyCount++;
            }
        }

        //There should be zero empty spaces.
        $this->assertEquals($emptyCount, 0);
    }
}
