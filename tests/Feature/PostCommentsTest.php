<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostCommentsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function a_user_can_comment_on_post()
    {
        $this->actingAs($user = User::factory()->create(), 'api');
        $post = Post::factory()->create(['id' => 123]);

        $response = $this->post('/api/posts/' . $post->id . '/comment', [
            'body' => 'a comment',
        ])->assertStatus(200);
        $comment = Comment::first();
        $this->assertCount(1, Comment::all());
        $this->assertEquals($user->id, $comment->user_id);
        $this->assertEquals($post->id, $comment->post_id);
        $this->assertEquals('a comment', $comment->body);
        $response->assertJson([
            'data' => [
                [
                    'data' => [
                        'type' => 'comments',
                        'comment_id' => 1,
                        'attributes' => [
                            'commented_by' => [
                                'data' => [
                                    'user_id' => $user->id,
                                    'attributes' => [
                                        'name' => $user->name,
                                    ],
                                ],
                            ],
                            'body' => 'a comment',
                            'commented_at' => $comment->created_at->diffForHumans(),
                        ],
                    ],
                    'links' => [
                        'self' => url('/posts/123'),
                    ],
                ],
            ],
            'links' => [
                'self' => url('/posts'),
            ],
        ]);
    }
    /** @test */
    public function a_body_is_needed_for_comment()
    {
        // $this->withoutExceptionHandling();
        $this->actingAs(User::factory()->create(), 'api');
        $post = Post::factory()->create(['id' => 123]);

        $response = $this->withHeaders(['Accept' => 'application/json'])
            ->post('/api/posts/' . $post->id . '/comment', [
                'body' => '',
            ])
            ->assertStatus(422);
        $responseString = $response->decodeResponseJson();
        // $this->assertArrayHasKey('body', $responseString);
    }
    /** @test */
    public function post_are_return_with_comments()
    {
        $this->actingAs($user = User::factory()->create(), 'api');
        $post = Post::factory()->create(['id' => 123, 'user_id' => $user->id]);
        $this->post('/api/posts/' . $post->id . '/comment', [
            'body' => 'a comment',
        ]);
        $response = $this->get('/api/posts');
        $comment = Comment::first();
        $response->assertJson([
            'data' => [
                [
                    'data' => [
                        'type' => 'posts',
                        'attributes' => [
                            'comments' => [
                                'data' => [
                                    [
                                        'data' => [
                                            'type' => 'comments',
                                            'comment_id' => 1,
                                            'attributes' => [
                                                'commented_by' => [
                                                    'data' => [
                                                        'user_id' => $user->id,
                                                        'attributes' => [
                                                            'name' =>
                                                                $user->name,
                                                        ],
                                                    ],
                                                ],
                                                'body' => 'a comment',
                                                'commented_at' => $comment->created_at->diffForHumans(),
                                            ],
                                        ],
                                        'links' => [
                                            'self' => url('/posts/123'),
                                        ],
                                    ],
                                ],
                                'comment_count' => 1,
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }
}
