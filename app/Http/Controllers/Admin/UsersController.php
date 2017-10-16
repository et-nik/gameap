<?php

namespace Gameap\Http\Controllers\Admin;

use Gameap\Http\Controllers\AuthController;
use Gameap\Models\User;
use Gameap\Repositories\UserRepository;
use Gameap\Http\Requests\UserRequest;

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

        $this->repository = $repository;
    }

    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Http\Response
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
        return view('admin.users.create');
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \Gameap\Http\Requests\UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        User::create($request->all());

        return redirect()->route('admin.users.index')
            ->with('success','User created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \Gameap\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('admin.users.view', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Gameap\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Gameap\Http\Requests\UserRequest  $request
     * @param  \Gameap\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        $user->update($request->all());

        return redirect()->route('admin.users.index')
            ->with('success','User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Gameap\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')
            ->with('success','User deleted successfully');
    }
}