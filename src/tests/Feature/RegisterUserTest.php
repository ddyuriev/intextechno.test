<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Support\Facades\Cache;

class RegisterUserTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');

        $this->clearRedisForTesting();
    }

    protected function tearDown(): void
    {
        $this->clearRedisForTesting();
        parent::tearDown();
    }

    protected function clearRedisForTesting(): void
    {
        try {
            if (class_exists(\Illuminate\Cache\RateLimiting\Limit::class)) {
                $rateLimiterPrefixes = [
                    'rate-limiter:',
                    'laravel:rate-limiter:',
                    config('cache.prefix') . ':rate-limiter:',
                ];

                foreach ($rateLimiterPrefixes as $prefix) {
                    $keys = Redis::keys($prefix . '*');
                    if ($keys) {
                        Redis::del($keys);
                    }
                }
            }

            Cache::store('redis')->clear();

        } catch (\Exception $e) {
        }

        $appPrefix = config('database.redis.options.prefix', 'laravel_database_');
        $keys = Redis::keys($appPrefix . '*');
        if ($keys) {
            Redis::del($keys);
        }

        $cachePrefix = config('cache.prefix') ?: 'laravel_cache';
        $keys = Redis::keys($cachePrefix . '*');
        if ($keys) {
            Redis::del($keys);
        }

        $testKeys = ['users'];
        foreach ($testKeys as $key) {
            Redis::del($key);
        }
    }


    /** @test */
    public function user_can_register_successfully(): void
    {
        $response = $this->postJson('/api/register', [
            'nickname' => 'john',
            'avatar' => UploadedFile::fake()->image('avatar.jpg'),
        ]);

        $response
            ->assertStatus(200)
            ->assertJson(['status' => 'ok']);

        $this->assertTrue(
            Redis::sismember('users', 'john'),
            'Nickname was not saved in Redis set'
        );
    }

    /** @test */
    public function nickname_must_be_unique(): void
    {
        $this->postJson('/api/register', [
            'nickname' => 'john',
            'avatar' => UploadedFile::fake()->image('avatar.jpg'),
        ]);

        $response = $this->postJson('/api/register', [
            'nickname' => 'john',
            'avatar' => UploadedFile::fake()->image('avatar.jpg'),
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['nickname']);
    }

    /** @test */
    public function avatar_must_be_a_valid_image(): void
    {
        $response = $this->postJson('/api/register', [
            'nickname' => 'john',
            'avatar' => UploadedFile::fake()->create('document.pdf', 100),
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['avatar']);
    }

    /** @test */
    public function rate_limit_is_applied(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->postJson('/api/register', [
                'nickname' => 'user' . $i,
                'avatar' => UploadedFile::fake()->image('avatar.jpg'),
            ])->assertStatus(200);
        }

        $response = $this->postJson('/api/register', [
            'nickname' => 'overflow',
            'avatar' => UploadedFile::fake()->image('avatar.jpg'),
        ]);

        $response->assertStatus(429);
    }
}
