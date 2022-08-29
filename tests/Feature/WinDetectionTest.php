<?php
namespace Tests\Feature;
namespace App;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class WinDetectionTest extends TestCase
{
    /**
     * Checks if there is a win on an empty board.
     *
     * @return void
     */
    public function test_empty_board() {
        //We create a random board.
        $width = rand(10, 50);
        $height = rand(10, 50);
        $board = new Board($width, $height);
        $detectWin = new DetectWin();

        //A new board should be empty.
        $this->assertNull($detectWin->detectWin($board));
    }

    /**
     * Checks for a win on a row of pieces.
     *
     * @return void
     */
    public function test_win_row() {
        //We create a random board.
        $width = rand(10, 50);
        $height = rand(10, 50);
        $board = new Board($width, $height);
        $detectWin = new DetectWin();

        $countStart = rand(0, $width - 3);
        $piece = new Piece(1, -1, -1);

        //We create "$width - 1 - $x" horizontal consecutive pieces starting at "$countStart".
        for ($x = $countStart; $x < $width; $x++) { 
            $board->throwPiece($piece, $x);
        }

        //Since there's a winning move a piece should be returned, no "NULL".
        $this->assertNotNull($detectWin->detectWin($board));
    }


    /**
     * Checks for a win on a column of pieces.
     *
     * @return void
     */
    public function test_win_column() {
        //We create a random board.
        $width = rand(10, 50);
        $height = rand(10, 50);
        $board = new Board($width, $height);
        $detectWin = new DetectWin();

        $xPos = rand(0, $width - 1);
        $pieceCount = rand(4, $height);
        $piece = new Piece(1, -1, -1);

        //We create at least four consecutive vertical pieces, in row "$xPos".
        for ($i = 0; $i < $pieceCount; $i++) { 
            $board->throwPiece($piece, $xPos);
        }

        //Since there's a winning move a piece should be returned, no "NULL".
        $this->assertNotNull($detectWin->detectWin($board));
    }

    /**
     * Checks if there is a win on a checkered board.
     *
     * @return void
     */
    public function test_diagonal_win() {
        $width = rand(10, 50);
        $height = rand(10, 50);
        $board = new Board($width, $height);
        $detectWin = new DetectWin();

        //We fill the board with a checkered pattern, this in diagonals of the same colour.
        for ($x = 0; $x < $width; $x++) { 
            for ($y = 0; $y < $height; $y++) {
                //We alternate the colours of the pieces. The check with "$x" is done to prevent equal rows.
                if ($x % 2 == 0)
                    $piece = new Piece(($y % 2 == 0) ? 0 : 1, -1, -1);
                else
                    $piece = new Piece(($y % 2 == 0) ? 1 : 0, -1, -1);
                $board->throwPiece($piece, $x);
            }
        }

        //Since there's a winning move a piece should be returned, no "NULL".
        $this->assertNotNull($detectWin->detectWin($board));
    }
}
