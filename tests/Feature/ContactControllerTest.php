<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Contact;
use App\Models\User;

class ContactControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    /** @test */
    public function it_should_return_200_on_index()
    {
        $response = $this->get(route('contact.index'));
        $response->assertStatus(200);
    }

    /** @test */
    public function it_should_return_200_on_create()
    {
        $response = $this->get(route('contact.create'));
        $response->assertStatus(200);
    }
}
