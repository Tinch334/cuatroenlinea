<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PiecesTest extends TestCase
{
    /**
     * Checks the amount of pieces given 4 pieces in the first column. Succeeds
     *
     * @return void
     */
    public function test_piece_count() {
        $response = $this->get('/jugar/1111');
        $response->assertStatus(200);

        $bluePieces = preg_match_all('/<div class="bg-sky-500/', $response->getContent());
        $redPieces = preg_match_all('/<div class="bg-red-500/', $response->getContent());

        $this->assertTrue($bluePieces == 2 && $redPieces == 2);
    }

    /**
     * Checks the amount of empty spaces given 7 pieces, one in each column. Succeeds
     *
     * @return void
     */
    public function test_empty_spaces_count() {
        $response = $this->get('/jugar/1234567');
        $response->assertStatus(200);

        $emptySpaces = preg_match_all('/<div class="bg-gray-200/', $response->getContent());

        $this->assertTrue($emptySpaces == 35);
    }
}
