<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BoardTest extends TestCase
{
    /**
     * Checks if you can start with an empty board.
     *
     * @return void
     */
    public function test_empty_board() {
        $response = $this->get('/jugar/');

        $content = $response->getContent();
        $this->assertEquals(41, substr_count($content, 'bg-gray-200 text-center'));
    }
}
