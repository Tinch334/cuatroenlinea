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

        //A new board should be empty, therefore no piece should be returned.
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

        //We create "$countStart + 4" horizontal consecutive pieces starting at "$countStart".
        for ($x = $countStart; $x < $countStart + 4; $x++) { 
            $board->throwPiece($piece, $x);
        }

        //Since there's a winning move a piece should be returned, not "NULL".
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

        //Since there's a winning move a piece should be returned, not "NULL".
        $this->assertNotNull($detectWin->detectWin($board));
    }

    /**
     * Checks if there is a win on a board with diagonal lines of the same colour.
     *
     * @return void
     */
    public function test_diagonal_win() {
        $width = rand(10, 50);
        $height = rand(10, 50);
        $board = new Board($width, $height);
        $detectWin = new DetectWin();

        //We fill the board with a diagonal pattern.
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

        //Since there's a winning move a piece should be returned, not "NULL".
        $this->assertNotNull($detectWin->detectWin($board));
    }


    /**
     * Checks if there is a horizontal win on a specific board.
     *
     * @return void
     */
    public function test_horizontal_specific_success() {
        $array = array(
            array(1,    NULL, NULL, NULL, NULL, NULL, NULL),
            array(0,    NULL, NULL, NULL, NULL, NULL, NULL),
            array(1,    1,    1,    NULL, NULL, 0,    NULL),
            array(0,    0,    0,    NULL, NULL, 1,    NULL),
            array(0,    0,    1,    0,    0,    0,    0   ),
            array(0,    1,    1,    1,    0,    0,    1   )
        );

        $board = $this->_makeBoard($array);
        $detectWin = new DetectWin();

        //Since there's a winning move a piece should be returned, not "NULL".
        $this->assertNotNull($detectWin->detectWin($board));
    }

    /**
     * Checks if there is a not a horizontal win on a specific board.
     *
     * @return void
     */
    public function test_horizontal_specific_failure() {
        $array = array(
            array(1,    NULL, NULL, NULL, NULL, NULL, NULL),
            array(0,    NULL, NULL, NULL, NULL, NULL, NULL),
            array(1,    1,    1,    NULL, NULL, 0,    NULL),
            array(0,    0,    0,    NULL, 1,    1,    NULL),
            array(0,    0,    1,    0,    1,    0,    0   ),
            array(0,    1,    1,    1,    0,    0,    1   )
        );

        $board = $this->_makeBoard($array);
        $detectWin = new DetectWin();

        //There are no winning moves on the board, therefore no piece should be returned.
        $this->assertNull($detectWin->detectWin($board));
    }

    /**
     * Checks if there is a vertical win on a specific board.
     *
     * @return void
     */
    public function test_vertical_specific_success() {
        $array = array(
            array(NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            array(NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            array(NULL, NULL, 1,    NULL, NULL, 0,    NULL),
            array(0,    0,    0,    NULL, NULL, 0,    NULL),
            array(0,    1,    1,    NULL, NULL, 0,    NULL),
            array(0,    1,    0,    1,    0,    0,    NULL)
        );

        $board = $this->_makeBoard($array);
        $detectWin = new DetectWin();

        //Since there's a winning move a piece should be returned, not "NULL".
        $this->assertNotNull($detectWin->detectWin($board));
    }

    /**
     * Checks if there is not a vertical win on a specific board.
     *
     * @return void
     */
    public function test_vertical_specific_failure() {
        $array = array(
            array(NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            array(NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            array(NULL, NULL, 1,    NULL, NULL, 1,    NULL),
            array(0,    NULL, 0,    0,    NULL, 0,    NULL),
            array(0,    1,    1,    0,    NULL, 1,    NULL),
            array(0,    1,    0,    1,    0,    0,    NULL)
        );

        $board = $this->_makeBoard($array);
        $detectWin = new DetectWin();

        //There are no winning moves on the board, therefore no piece should be returned.
        $this->assertNull($detectWin->detectWin($board));
    }

    /**
     * Checks if there is a diagonal win on a specific board.
     *
     * @return void
     */
    public function test_diagonal_specific_success() {
        $array = array(
            array(NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            array(1,    NULL, NULL, NULL, NULL, NULL, NULL),
            array(0,    1,    1,    NULL, NULL, 1,    NULL),
            array(1,    0,    1,    0,    NULL, 0,    NULL),
            array(0,    1,    1,    1,    NULL, 1,    NULL),
            array(0,    1,    0,    1,    0,    0,    NULL)
        );

        $board = $this->_makeBoard($array);
        $detectWin = new DetectWin();

        echo "Diagonal check\n";
        //Since there's a winning move a piece should be returned, not "NULL".
        $this->assertNotNull($detectWin->detectWin($board));
    }

    /**
     * Checks if there is not a diagonal win on a specific board.
     *
     * @return void
     */
    public function test_diagonal_specific_failure() {
        $array = array(
            array(NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            array(1,    NULL, NULL, NULL, NULL, NULL, NULL),
            array(0,    1,    1,    NULL, NULL, 1,    NULL),
            array(1,    1,    0,    0,    NULL, 0,    NULL),
            array(0,    0,    1,    1,    0,    1,    NULL),
            array(0,    1,    0,    1,    1,    0,    NULL)
        );

        $board = $this->_makeBoard($array);
        $detectWin = new DetectWin();

        //There are no winning moves on the board, therefore no piece should be returned.
        $this->assertNull($detectWin->detectWin($board));
    }

    //Allows for the easy creation of a board with a specific piece arrangement.
    protected function _makeBoard($array): Board {
        $width = count($array[0]);
        $height = count($array);

        $board = new Board($width, $height);

        for ($x = $width - 1; $x >= 0; $x--) { 
            for ($y = $height - 1; $y >= 0; $y--) {
                //We can't use "$array[$y][$x] != NULL" because PHP interprets zero as NULL.
                if (!is_null($array[$y][$x]))
                    $board->throwPiece(new Piece($array[$y][$x], -1, -1), $x);
            }
        }

        return $board;
    }
}
