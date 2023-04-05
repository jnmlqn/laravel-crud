<?php

namespace App\Listeners;

use App\Events\UserSaved;
use App\Models\Detail;
use DB;

class SaveUserBackgroundInformation
{
    /**
     * @var Detail
     */
    private Detail $detail;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Detail $detail)
    {
        $this->detail = $detail;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(UserSaved $event): void
    {
        $user = $event->user;

        DB::beginTransaction();

        $this->detail->create([
            'key' => 'Full name',
            'value' => $user->fullName,
            'type' => 'bio',
            'user_id' => $user->id,
        ]);

        $this->detail->create([
            'key' => 'Middle initial',
            'value' => $user->middleInitial,
            'type' => 'bio',
            'user_id' => $user->id,
        ]);

        $this->detail->create([
            'key' => 'Avatar',
            'value' => asset($user->avatar),
            'type' => 'bio',
            'user_id' => $user->id,
        ]);

        $this->detail->create([
            'key' => 'Gender',
            'value' => $user->gender,
            'type' => 'bio',
            'user_id' => $user->id,
        ]);

        DB::commit();
    }
}
