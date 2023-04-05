<?php

namespace Tests\Unit;

use App\Events\UserSaved;
use App\Models\Detail;
use App\Models\User;
use App\Listeners\SaveUserBackgroundInformation;
use Illuminate\Foundation\Testing\WithFaker;
use DB;
use Tests\TestCase;

class SaveUserBackgroundInformationTest extends TestCase
{
    use WithFaker;

    /**
     * @var Detail
     */
    private Detail $detail;

    /**
     * @var SaveUserBackgroundInformation
     */
    private SaveUserBackgroundInformation $saveUserBackgroundInformation;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->detail = $this->mock(Detail::class);
        $this->saveUserBackgroundInformation = new SaveUserBackgroundInformation($this->detail);
    }

    /**
     * @test
     * 
     * @return void
     */
    public function testHandle(): void
    {
        $user = new User([
            'photo' => '/img/no-image.jpg',
            'username' => $this->faker->word(),
            'email' => $this->faker->email(),
            'password' => bcrypt($this->faker->word()),
            'prefixname' => 'Mr.',
            'firstname' => $this->faker->word(),
            'middlename' => $this->faker->word(),
            'lastname' => $this->faker->word(),
            'suffixname' => 'Jr'
        ]);

        $event = new UserSaved($user);

        DB::shouldReceive('beginTransaction')->once();

        $this->detail
            ->shouldReceive('create')
            ->once()
            ->with([
                'key' => 'Full name',
                'value' => $user->fullName,
                'type' => 'bio',
                'user_id' => $user->id,
            ])
            ->andReturn(
                new Detail([
                    'key' => 'Full name',
                    'value' => $user->fullName,
                    'type' => 'bio',
                    'user_id' => $user->id,
                ])
            );

        $this->detail
            ->shouldReceive('create')
            ->once()
            ->with([
                'key' => 'Middle initial',
                'value' => $user->middleInitial,
                'type' => 'bio',
                'user_id' => $user->id,
            ])
            ->andReturn(
                new Detail([
                    'key' => 'Middle initial',
                    'value' => $user->middleInitial,
                    'type' => 'bio',
                    'user_id' => $user->id,
                ])
            );

        $this->detail
            ->shouldReceive('create')
            ->once()
            ->with([
                'key' => 'Avatar',
                'value' => asset($user->avatar),
                'type' => 'bio',
                'user_id' => $user->id,
            ])
            ->andReturn(
                new Detail([
                    'key' => 'Avatar',
                    'value' => asset($user->avatar),
                    'type' => 'bio',
                    'user_id' => $user->id,
                ])
            );

        $this->detail
            ->shouldReceive('create')
            ->once()
            ->with([
                'key' => 'Gender',
                'value' => $user->gender,
                'type' => 'bio',
                'user_id' => $user->id,
            ])
            ->andReturn(
                new Detail([
                    'key' => 'Gender',
                    'value' => $user->gender,
                    'type' => 'bio',
                    'user_id' => $user->id,
                ])
            );

        DB::shouldReceive('commit')->once();

        $this->saveUserBackgroundInformation->handle($event);
    }
}
