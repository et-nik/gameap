<?php

namespace Gameap\Http\Controllers\Admin;

use Gameap\Http\Controllers\AuthController;
use Gameap\Models\User;
use Gameap\Repositories\UserRepository;
use Gameap\Http\Requests\UserRequest;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UsersController extends AuthController
{
    /**
     * The UserRepository instance.
     *
     * @var \Gameap\Repositories\UserRepository
     */
    protected $repository;

    /**
     * Create a new UserRepository instance.
     *
     * @param  \Gameap\Repositories\UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        parent::__construct();
        $this->repository = $repository;
    }

    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.users.list',[
            'users' => $this->repository->getAll()
        ]);
    }

    /**
     * Display new create user page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $roles = Role::get();
        
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created user in storage.
     *
     * @param UserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRequest $request)
    {
        $this->repository->store($request->all());

        return redirect()->route('admin.users.index')
            ->with('success','User created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $user)
    {
        return view('admin.users.view', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(User $user)
    {
        $roles = Role::get();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Gameap\Http\Requests\UserRequest  $request
     * @param  \Gameap\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserRequest $request, User $user)
    {
        if ($this->repository->update($user, $request->all())) {
            return redirect()->route('admin.users.index')
                ->with('success', 'User updated successfully');
        } else {
            return redirect()->route('admin.users.index')
                ->with($user->getValidationErrors()->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Gameap\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')
            ->with('success','User deleted successfully');
    }
}