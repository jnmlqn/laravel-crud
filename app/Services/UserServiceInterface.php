<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

interface UserServiceInterface
{
    /**
     * @return LengthAwarePaginator
     */
    public function index(): LengthAwarePaginator;

    /**
     * @return LengthAwarePaginator
     */
    public function trashed(): LengthAwarePaginator;

    /**
     * @param  array  $data
     * 
     * @return User
     */
    public function store(array $data): User;

    /**
     * @param  int   $id
     * @param  array $data
     * 
     * @return bool
     */
    public function update(int $id, array $data): bool;

    /**
     * @param  int  $id
     * @param  bool $isSoftDeleted
     * 
     * @return User
     */
    public function findOrFail(int $id, bool $isSoftDeleted = false): User;

    /**
     * @param string $password
     */
    public function hash(string $password): string;
}
