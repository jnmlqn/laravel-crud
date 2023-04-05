<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class UserControllerTest extends TestCase
{
    use DatabaseMigrations, RefreshDatabase, WithFaker;

    /**
     * @test
     * @return void
     */
    public function it_can_return_a_paginated_list_of_users()
    {
    // Arrangements

    // Actions

    // Assertions
    }

    /**
     * @test
     * @return void
     */
    public function it_can_store_a_user_to_database()
    {
    // Arrangements

    // Actions

    // Assertions
    }

    /**
     * @test
     * @return void
     */
    public function it_can_find_and_return_an_existing_user()
    {
    // Arrangements

    // Actions

    // Assertions
    }

    /**
     * @test
     * @return void
     */
    public function it_can_update_an_existing_user()
    {
    // Arrangements

    // Actions

    // Assertions
    }

    /**
     * @test
     * @return void
     */
    public function it_can_soft_delete_an_existing_user()
    {
    // Arrangements

    // Actions

    // Assertions
    }

    /**
     * @test
     * @return void
     */
    public function it_can_return_a_paginated_list_of_trashed_users()
    {
    // Arrangements

    // Actions

    // Assertions
    }

    /**
     * @test
     * @return void
     */
    public function it_can_restore_a_soft_deleted_user()
    {
    // Arrangements

    // Actions

    // Assertions
    }

    /**
     * @test
     * @return void
     */
    public function it_can_permanently_delete_a_soft_deleted_user()
    {
    // Arrangements

    // Actions

    // Assertions
    }

    /**
     * @test
     * @return void
     */
    public function it_can_upload_photo()
    {
    // Arrangements

    // Actions

    // Assertions
    }
}
