<?php

namespace App\Domains\Auth\Http\Controllers\User;

use App\Domains\Auth\Http\Requests\User\UpdateUserPasswordRequest;
use App\Domains\Auth\Models\User;
use App\Domains\Auth\Services\UserService;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Log;

class ProfileController extends Controller
{
    protected UserService $userService;

    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function show(Request $request): RedirectResponse
    {
        $user = $this->userService->getAuthUser();

        return redirect()->route('profile.edit', $user?->getId());
    }

    public function edit(Request $request): View
    {
        $user = $this->userService->getAuthUser();

        return view('backend.auth.profile.edit')
            ->withUser($user);
    }

    public function update(Request $request, $userId): RedirectResponse
    {
        $user = $this->userService->getAuthUser();
        if ($user?->getId() !== $userId) {
            Log::critical('User ' . $user?->getId() . ' tried to save data on behalf of ' . $userId);

            return redirect()->route('profile.edit', $userId)->with('error', 'Error during update');
        }

        $userDTO = new User();
        $userDTO->setName($request['name']);
        $userDTO->setEmail($request['email']);

        $this->userService->update($userDTO, $userId);

        return redirect()->route('profile.edit', $userId)->with('success', '');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function editPassword(Request $request): View
    {
        $user = $this->userService->getAuthUser();

        return view('backend.auth.users.edit_password')
            ->withUser($user);
    }

    public function updatePassword(UpdateUserPasswordRequest $request, string $userId): RedirectResponse
    {
        $user = $this->userService->getAuthUser();
        if ($user?->getId() !== $userId) {
            Log::critical('User ' . $user?->getId() . ' tried ' . $userId);

            return redirect()->route('profile.edit', $userId)->with('error', 'Υπήρξε κάποιο πρόβλημα κατά την αποθήκευση.');
        }

        $userDTO = new User();
        $userDTO->setPassword($request['password']);

        $this->userService->updatePassword($userDTO, $userId);

        return redirect()->route('profile.edit', $userId)->with('success', 'Ο κωδικός του χρήστη ενημερώθηκε με επιτυχία');
    }
}
