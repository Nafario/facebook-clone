<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PostToTimelineTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function a_user_can_post_a_text_post()
    {
        $this->withoutExceptionHandling();
        $this->actingAs($user = User::factory()->create(), 'api');
        $response = $this->post('api/posts', [
            'body' => 'Testing body',
        ]); //
        $post = Post::first();
        $this->assertCount(1, Post::all());
        $this->assertEquals($user->id, $post->user_id);
        $this->assertEquals('Testing body', $post->body);
        $response->assertStatus(201)->assertJson([
            'data' => [
                'type' => 'posts',
                'post_id' => $post->id,
                'attributes' => [
                    'posted_by' => [
                        'data' => [
                            'attributes' => [
                                'name' => $user->name,
                            ],
                        ],
                    ],
                    'body' => 'Testing body',
                ],
            ],
            'links' => [
                'self' => url('/posts/' . $post->id),
            ],
        ]);
    }
    /** @test */
    public function a_user_can_post_a_text_and_image()
    {
        $this->withoutExceptionHandling();
        $this->actingAs($user = User::factory()->create(), 'api');
        $file = UploadedFile::fake()->image('user-image.jpg');
        $response = $this->post('api/posts', [
            'body' => 'Testing body',
            'image' => $file,
            'width' => 100,
            'height' => 100,
        ]);
        Storage::disk('public')->exists('post-images/' . $file->hashName());
        $response->assertStatus(201)->assertJson([
            'data' => [
                'attributes' => [
                    'body' => 'Testing body',
                    'image' => url('post-images/' . $file->hashName()),
                ],
            ],
        ]);
    }
}
