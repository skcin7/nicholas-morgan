<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class WritingsTest extends TestCase
{
//    use DatabaseMigrations;
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * Test that the writings page loads successfully for guests.
     *
     * @return void
     */
    public function testTheWritingsPageLoadsSuccessfullyForGuests()
    {
        $response = $this->get('writings');
        $response->assertStatus(200);
    }

    /**
     * Test that the writings page loads successfully for regular users.
     *
     * @return void
     */
    public function testTheWritingsPageLoadsSuccessfullyForRegularUsers()
    {
        $regularUser = factory(\App\User::class)->states('regularUser')->create();
        $this->actingAs($regularUser);

        $response = $this->get('writings');
        $response->assertStatus(200);
    }

    /**
     * Test that the writings page loads successfully for admins.
     *
     * @return void
     */
    public function testTheWritingsPageLoadsSuccessfullyForAdmins()
    {
        $admin = factory(\App\User::class)->states('admin')->create();
        $this->actingAs($admin);

        $response = $this->get('writings');
        $response->assertStatus(200);
    }
}
