<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\UserCase;

class PostTest extends TestCase
{
    use RefreshDatabase, UserCase;

    /**
     * @var \Faker\Generator
     */
    protected $faker;

    protected function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();

        $this->faker = Factory::create();

        $this->generateJwtKey();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUserCanEditAnPost()
    {
        $post = factory(Post::class)->create([
            'user_id' => $this->user->id,
        ]);

        $response = $this->withHeader('Authorization', "Bearer {$this->jwtKey}")
            ->json('PUT', route('posts.update', $post->id), [
                'post_title' => $this->faker->text,
                'content' => $this->faker->realText(),
            ]);

        $data = $response->decodeResponseJson();

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message',
            'data' => [
                'id',
                'post_title',
                'post_name',
                'user_id',
                'created_at',
                'updated_at',
                'deleted_at',
                'published_at',
            ],
        ]);

        $this->assertNotEquals($post->post_title, $data['data']['post_title']);
        $this->assertNotEquals($post->content, $data['data']['content']);
        $this->assertEquals($post->post_name, $data['data']['post_name']);
        $this->assertEquals($post->id, $data['data']['id']);
    }

    public function testUserNotCanUpdatePost()
    {
        $post = factory(Post::class)->create();

        $response = $this->withHeader('Authorization', "Bearer {$this->jwtKey}")
            ->json('PUT', route('posts.update', $post->id), [
                'post_title' => $this->faker->title,
                'content' => $this->faker->realText(),
            ]);

        $data = $response->decodeResponseJson();

        $response->assertStatus(403);
        $response->assertJsonStructure([
            'message',
        ]);
        $response->assertJson([
            'message' => 'This action is unauthorized.',
        ]);
    }
}
