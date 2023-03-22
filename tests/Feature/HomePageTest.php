<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    /** @test */
    function user_can_view_home_page() {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewIs('welcome');
        $response->assertSeeText(
            "Send secure and encrypted notes that self destruct once they've been read", 
            $escaped = false
        );
    }
}
