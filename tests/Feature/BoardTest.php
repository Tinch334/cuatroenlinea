<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BoardTest extends TestCase
{
    /**
     * Checks if you can start with an empty board. Fails
     *
     * @return void
     */
    public function test_empty_board() {
        $response = $this->get('/jugar/');

        $this->assertStatus(200);
    }

    /**
     * Checks what happens when you add a piece to a non existent column. Fails
     *
     * @return void
     */
    public function test_invalid_column() {
        $response = $this->get('/jugar/8');

        $this->assertStatus(200);
    }
}
