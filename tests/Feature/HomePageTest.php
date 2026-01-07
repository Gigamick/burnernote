<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    #[Test]
    public function user_can_view_home_page(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewIs('welcome');
        $response->assertSee("Send secure and encrypted notes that self destruct once they");
    }
}
