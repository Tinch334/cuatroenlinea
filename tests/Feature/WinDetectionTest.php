<?php
namespace Tests\Feature;
namespace App;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class WinDetectionTest extends TestCase
{
    /**
     * Checks if you can start with an empty board. Fails
     *
     * @return void
     */
    public function test_empty_board() {
        
    }

    /**
     * Checks what happens when you add a piece to a non existent column. Fails
     *
     * @return void
     */
    public function test_invalid_column() {
        
    }
}
