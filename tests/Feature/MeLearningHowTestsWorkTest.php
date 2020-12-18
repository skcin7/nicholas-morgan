<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class MeLearningHowTestsWorkTest extends TestCase
{
//    use DatabaseMigrations;
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

//        \Artisan::call('migrate');

        // All these appear to do the same:
        \Artisan::call('db:seed');
        $this->artisan('db:seed');
        $this->seed();
    }

    public function tearDown(): void
    {
//        \Artisan::call('migrate:reset');

        parent::tearDown();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testTheTestCompletesSuccessfully()
    {
        $user = \App\User::factory()->create();
        $this->actingAs($user);

//        $response = $this->actingAs($user)
//            ->withSession(['foo' => 'bar'])
//            ->get('/');

//        $user = \App\User::first();
//        $this->actingAs($user);

//        $response = $this->get('home/my_collection');
        $response = $this->get('home/my_collection');

        $response->assertStatus(200);
    }
}
