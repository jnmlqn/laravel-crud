<?php

namespace Tests\Unit;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Mockery;
use Str;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use WithFaker;

    /**
     * @var User
     */
    private User $user;

    /**
     * @var UserService
     */
    private UserService $userService;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->user = $this->mock(User::class);
        $this->userService = new UserService($this->user);
    }

    /**
     * @test
     * 
     * @return void
     */
    public function it_can_return_a_paginated_list_of_users(): void
    {
        $items = [
            new User([
                'id' => 1
            ]),
            new User([
                'id' => 2
            ]),
            new User([
                'id' => 3
            ]),
            new User([
                'id' => 4
            ]),
        ];
        $perPage = 10;
        $results = new LengthAwarePaginator($items, count($items), $perPage);

        $this->user
            ->shouldReceive('paginate')
            ->once()
            ->with($perPage)
            ->andReturn($results);

        $response = $this->userService->index();
        $this->assertInstanceOf(LengthAwarePaginator::class, $response);
    }

    /**
     * @test
     * 
     * @return void
     */
    public function it_can_store_a_user_to_database(): void
    {
        $photo = UploadedFile::fake()->image($this->faker->word() . '.png');
        $data = [
            'photo' => $photo,
            'username' => $this->faker->userName(),
            'email' => $this->faker->email(),
            'password' => $this->faker->word(),
            'prefixname' => 'Mr.',
            'firstname' => $this->faker->word(),
            'middlename' => $this->faker->word(),
            'lastname' => $this->faker->word(),
            'suffixname' => 'Jr'
        ];
        $storeData = $data;
        $fileName = date('YmdHis') . '.' . $storeData['photo']->extension();
        $storeData['photo']->storeAs('public/user_images', $fileName);
        $storeData['photo'] = UserService::IMAGE_PATH . $fileName;
        $storeData['password'] = $this->userService->hash($storeData['password']);

        $user = new User($storeData);

        $this->user
            ->shouldReceive('create')
            ->once()
            ->andReturn($user);

        $response = $this->userService->store($data);
        $this->assertInstanceOf(User::class, $response);
    }

    /**
     * @test
     * 
     * @return void
     */
    public function it_can_find_and_return_an_existing_user(): void
    {
        $userId = $this->faker->randomDigitNotNull();
        $user = new User([
            'id' => $userId
        ]);

        $this->user
            ->shouldReceive('findOrFail')
            ->once()
            ->with($userId)
            ->andReturn($user);

        $response = $this->userService->findOrFail($userId);
        $this->assertInstanceOf(User::class, $response);
    }

    /**
     * @test
     * 
     * @return void
     */
    public function it_can_update_an_existing_user(): void
    {
        $userId = $this->faker->randomDigitNotNull();
        $photo = UploadedFile::fake()->image($this->faker->word() . '.png');
        $data = [
            'photo' => $photo,
            'username' => $this->faker->userName(),
            'email' => $this->faker->email(),
            'password' => $this->faker->word(),
            'prefixname' => 'Mr.',
            'firstname' => $this->faker->word(),
            'middlename' => $this->faker->word(),
            'lastname' => $this->faker->word(),
            'suffixname' => 'Jr'
        ];

        $user = $this->mock(User::class);

        $this->user
            ->shouldReceive('findOrFail')
            ->once()
            ->with($userId)
            ->andReturn($user);

        $user->shouldReceive('update')
            ->once()
            ->andReturn(true);

        $response = $this->userService->update($userId, $data);
        $this->assertTrue($response);
    }

    /**
     * @test
     * 
     * @return void
     */
    public function it_can_soft_delete_an_existing_user(): void
    {
        $userId = $this->faker->randomDigitNotNull();
        $user = $this->mock(User::class);

        $this->user
            ->shouldReceive('findOrFail')
            ->once()
            ->with($userId)
            ->andReturn($user);

        $user->shouldReceive('delete')
            ->once()
            ->andReturn(true);

        $response = $this->userService->destroy($userId);
        $this->assertTrue($response);
    }

    /**
     * @test
     * 
     * @return void
     */
    public function it_can_return_a_paginated_list_of_trashed_users(): void
    {
        $items = [
            new User([
                'id' => 1,
                'deleted_at' => date('Y-m-d H:i:s')
            ]),
            new User([
                'id' => 2,
                'deleted_at' => date('Y-m-d H:i:s')
            ]),
            new User([
                'id' => 3,
                'deleted_at' => date('Y-m-d H:i:s')
            ]),
            new User([
                'id' => 4,
                'deleted_at' => date('Y-m-d H:i:s')
            ]),
        ];
        $perPage = 10;
        $results = new LengthAwarePaginator($items, count($items), $perPage);

        $this->user
            ->shouldReceive('onlyTrashed')
            ->once()
            ->andReturnSelf()
            ->shouldReceive('paginate')
            ->once()
            ->with($perPage)
            ->andReturn($results);

        $response = $this->userService->trashed();
        $this->assertInstanceOf(LengthAwarePaginator::class, $response);
    }

    /**
     * @test
     * 
     * @return void
     */
    public function it_can_restore_a_soft_deleted_user(): void
    {
        $userId = $this->faker->randomDigitNotNull();
        $user = $this->mock(User::class);

        $this->user
            ->shouldReceive('onlyTrashed')
            ->once()
            ->andReturnSelf()
            ->shouldReceive('findOrFail')
            ->once()
            ->with($userId)
            ->andReturn($user);

        $user->shouldReceive('restore')
            ->once()
            ->andReturn(true);

        $response = $this->userService->restore($userId);
        $this->assertTrue($response);
    }

    /**
     * @test
     * 
     * @return void
     */
    public function it_can_permanently_delete_a_soft_deleted_user(): void
    {        
        $userId = $this->faker->randomDigitNotNull();
        $user = $this->mock(User::class);

        $this->user
            ->shouldReceive('onlyTrashed')
            ->once()
            ->andReturnSelf()
            ->shouldReceive('findOrFail')
            ->once()
            ->with($userId)
            ->andReturn($user);

        $user->shouldReceive('forceDelete')
            ->once()
            ->andReturn(true);

        $response = $this->userService->delete($userId);
        $this->assertTrue($response);
    }

    /**
     * @test
     * 
     * @return void
     */
    public function it_can_upload_photo(): void
    {
        $file = UploadedFile::fake()->image($this->faker->word() . '.png');
        $fileName = date('YmdHis') . '.' . $file->extension();
        $file->storeAs('public/user_images', $fileName);
        $expected = UserService::IMAGE_PATH . $fileName;
        $response = $this->userService->upload($file);
        $this->assertEquals($expected, $response);
    }
}
