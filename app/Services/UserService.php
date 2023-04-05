<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Pagination\LengthAwarePaginator;
use Str;

class UserService implements UserServiceInterface
{
    /**
     * @var string
     */
    public const IMAGE_PATH = 'storage/user_images/';

    /**
     * @var User
     */
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return LengthAwarePaginator
     */
    public function index(): LengthAwarePaginator
    {
        return $this->user->paginate(10);
    }

    /**
     * @return LengthAwarePaginator
     */
    public function trashed(): LengthAwarePaginator
    {
        return $this->user->onlyTrashed()->paginate(10);
    }

    /**
     * @param  array  $data
     * 
     * @return User
     */
    public function store(array $data): User
    {
        if (is_null($data['photo'])) {
            unset($data['photo']);
        } else {
            $data['photo'] = $this->upload($data['photo']);
        }

        $data['password'] = $this->hash($data['password']);

        return $this->user->create($data);
    }

    /**
     * @param  int  $id
     * 
     * @return bool
     */
    public function destroy(int $id): bool
    {
        $user = $this->findOrFail($id);
        $user->delete();

        return true;
    }

    /**
     * @param  int  $id
     * 
     * @return bool
     */
    public function restore(int $id): bool
    {
        $user = $this->findOrFail($id, true);
        $user->restore();

        return true;
    }

    /**
     * @param  int  $id
     * 
     * @return bool
     */
    public function delete(int $id): bool
    {
        $user = $this->findOrFail($id, true);
        $user->forceDelete();

        return true;
    }

    /**
     * @param  int   $id
     * @param  array $data
     * 
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        $user = $this->findOrFail($id);

        if (is_null($data['photo'])) {
            unset($data['photo']);
        } else {
            $data['photo'] = $this->upload($data['photo']);
        }

        return $user->update($data);
    }

    /**
     * @param  int  $id
     * @param  bool $isSoftDeleted
     * 
     * @return User
     */
    public function findOrFail(int $id, bool $isSoftDeleted = false): User
    {
        $user = $this->user;

        if ($isSoftDeleted) {
            $user = $user->onlyTrashed();
        }

        return $user->findOrFail($id);
    }

    /**
     * @param  int|null  $id
     * @return array
     */
    public function rules(?int $id): array
    {
        if (is_null($id)) {
            $rules = [
                'username' => ['required', 'unique:users', 'max:255'],
                'email' => ['required', 'unique:users', 'max:255'],
                'password' => ['required', 'min:8', 'max:255'],
                'prefixname' => ['required', 'in:' . implode(',', config('constants.PREFIXES'))],
                'firstname' => ['required', 'max:255'],
                'middlename' => ['max:255'],
                'lastname' => ['required', 'max:255'],
                'suffixname' => ['max:255'],
            ];
        } else {
            $rules = [
                'username' => ['required', 'unique:users,username,' . $id, 'max:255'],
                'email' => ['required', 'unique:users,email,' . $id, 'max:255'],
                'prefixname' => ['required', 'in:' . implode(',', config('constants.PREFIXES'))],
                'firstname' => ['required', 'max:255'],
                'middlename' => ['max:255'],
                'lastname' => ['required', 'max:255'],
                'suffixname' => ['max:255'],
            ];
        }

        return $rules;
    }

    /**
     * @param string $password
     */
    public function hash(string $password): string
    {
        return Hash::make($password);
    }

    /**
     * @param UploadedFile $file
     * 
     * @return string
     */
    public function upload(UploadedFile $file): string
    {
        $fileName = date('YmdHis') . '.' . $file->extension();
        $file->storeAs('public/user_images', $fileName);

        return self::IMAGE_PATH . $fileName;
    }
}
