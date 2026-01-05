<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Complaint;

class ComplaintApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_list_complaints()
    {
        $user = User::factory()->create();
        Complaint::create([
            'user_id' => $user->id,
            'subject' => 'My Issue',
            'message' => 'Help me',
            'status' => 'open'
        ]);

        $response = $this->actingAs($user)->getJson('/api/complaints');

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonCount(1, 'data.data')
            ->assertJsonPath('data.data.0.subject', 'My Issue');
    }

    public function test_user_can_create_complaint()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/complaints', [
            'subject' => 'New Problem',
            'message' => 'Details here',
        ]);

        $response->assertStatus(201)
            ->assertJsonPath('success', true);

        $this->assertDatabaseHas('complaints', [
            'user_id' => $user->id,
            'subject' => 'New Problem',
            'message' => 'Details here'
        ]);
    }

    public function test_user_cannot_see_others_complaints()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $complaint = Complaint::create([
            'user_id' => $user1->id,
            'subject' => 'Secret',
            'message' => 'Hidden',
            'status' => 'open'
        ]);

        $response = $this->actingAs($user2)->getJson("/api/complaints/{$complaint->id}");

        $response->assertStatus(404); // Should be not found for user2
    }
}
