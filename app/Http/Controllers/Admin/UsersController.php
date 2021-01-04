<?php

namespace Gameap\Http\Controllers\Admin;

use Bouncer;
use Gameap\Http\Controllers\AuthController;
use Gameap\Http\Requests\Admin\UserCreateRequest;
use Gameap\Http\Requests\Admin\UserUpdateRequest;
use Gameap\Models\User;
use Gameap\Repositories\UserRepository;

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
            'users' => $this->repository->getAll(),
        ]);
    }

    /**
     * Display new create user page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $roles = Bouncer::role()->all();
        
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created user in storage.
     *
     * @param UserCreateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserCreateRequest $request)
    {
        $this->repository->store($request->all());

        return redirect()->route('admin.users.index')
            ->with('success', __('users.create_success_msg'));
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
        $roles = Bouncer::role()->all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Gameap\Http\Requests\Admin\UserUpdateRequest  $request
     * @param  \Gameap\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        if ($this->repository->update($user, $request->all())) {
            return redirect()->route('admin.users.index')
                ->with('success', __('users.update_success_msg'));
        }  
            return redirect()->route('admin.users.index')
                ->with($user->getValidationErrors()->all());
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Gameap\Models\User $user
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')
            ->with('success', __('users.delete_success_msg'));
    }
}