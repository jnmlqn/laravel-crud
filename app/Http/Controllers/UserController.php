<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * @var UserService
     */
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @return View
     */
    public function index(): View
    {
        $users = $this->userService->index();

        return view('users.index', compact('users'));
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('users.create');
    }

    /**
     * @param  Request  $request
     * 
     * @return RedirectResponse
     */
    public function store(UserRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $user = $this->userService->store([
            'photo' => $request->file('photo'),
            'username' => $request->get('username'),
            'email' => $request->get('email'),
            'password' => $request->get('password'),
            'prefixname' => $request->get('prefixname'),
            'firstname' => $request->get('firstname'),
            'middlename' => $request->get('middlename'),
            'lastname' => $request->get('lastname'),
            'suffixname' => $request->get('suffixname')
        ]);

        return redirect('/users');
    }

    /**
     * @param  int  $id
     * 
     * @return View
     */
    public function show(int $id): View
    {
        $user = $this->userService->findOrFail($id);

        return view('users.show', compact('user'));
    }

    /**
     * @param  int  $id
     * 
     * @return View
     */
    public function edit($id): View
    {
        $user = $this->userService->findOrFail($id);

        return view('users.edit', compact('user'));
    }

    /**
     * @param  Request  $request
     * @param  int  $id
     * 
     * @return RedirectResponse
     */
    public function update(UserRequest $request, $id): RedirectResponse
    {
        $validated = $request->validated();

        $user = $this->userService->update(
            $id,
            [
                'photo' => $request->file('photo'),
                'username' => $request->get('username'),
                'email' => $request->get('email'),
                'prefixname' => $request->get('prefixname'),
                'firstname' => $request->get('firstname'),
                'middlename' => $request->get('middlename'),
                'lastname' => $request->get('lastname'),
                'suffixname' => $request->get('suffixname')
            ]
        );

        return redirect('/users');
    }

    /**
     * @param  int  $id
     * @return Response
     */
    public function destroy(int $id): Response
    {
        $user = $this->userService->destroy($id);

        return response([
            'message' => 'User was successfully sof-deleted',
            'status' => Response::HTTP_OK
        ], Response::HTTP_OK);
    }

    /**
     * @return View
     */
    public function trashed(): View
    {
        $users = $this->userService->trashed();

        return view('users.trashed', compact('users'));
    }

    /**
     * @param  int  $id
     * @return Response
     */
    public function restore(int $id): Response
    {
        $user = $this->userService->restore($id);

        return response([
            'message' => 'User was successfully restored',
            'status' => Response::HTTP_OK
        ], Response::HTTP_OK);
    }

    /**
     * @param  int  $id
     * @return Response
     */
    public function delete(int $id): Response
    {
        $user = $this->userService->delete($id);

        return response([
            'message' => 'User was successfully deleted permanently',
            'status' => Response::HTTP_OK
        ], Response::HTTP_OK);
    }
}
