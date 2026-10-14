<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HandlesSoftDeletes;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    use HandlesSoftDeletes;

    /**
     * Display a listing of all users with soft-delete filter support.
     */
    public function index(Request $request): View
    {
        $query = $this->filterTrashedRecords(User::query(), $request, includeWithTrashed: false);

        $users = $query->latest()->paginate(10)->withQueryString();

        return view('user.index', compact('users'));
    }

    /**
     * Show the form for editing any specified user.
     */
    public function show(User $user): View
    {
        return view('user.show', compact('user'));
    }

    public function edit(User $user): View
    {
        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $user->update($request->validated());

        return redirect()->route('user.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Soft delete the specified user.
     */
    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return redirect()->route('user.index')
            ->with('success', 'User moved to trash successfully.');
    }

    /**
     * Restore a soft-deleted user.
     */
    public function restore(string $id): RedirectResponse
    {
        $this->restoreTrashedRecord(User::class, $id);

        return redirect()->route('user.index')
            ->with('success', 'User restored successfully.');
    }

    /**
     * Permanently delete a user from storage.
     */
    public function forceDelete(string $id): RedirectResponse
    {
        $this->permanentlyDeleteTrashedRecord(User::class, $id);

        return redirect()->route('user.index')
            ->with('success', 'User permanently deleted.');
    }
}
