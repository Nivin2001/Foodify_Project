<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\Request;
use Carbon\Carbon;


class UserController extends Controller
{

    private UserService $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    /**
     * عرض بيانات الملف الشخصي
     */
    public function profile()
    {
        $user = $this->service->getProfile(auth()->id());
        return new UserResource($user);
    }

    /**
     * تحديث بيانات الملف الشخصي
     */
    public function update(UpdateProfileRequest $request)
    {
        $data = $request->validated();


        if (isset($data['birth_date'])) {

            try {
                $data['birth_date'] = Carbon::parse($data['birth_date'])->format('Y-m-d');
            } catch (\Exception $e) {
                return response()->json(['error' => 'Birth date format is invalid'], 422);
            }
        }
        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user = $this->service->updateProfile(auth()->id(), $data);

        return new UserResource($user);
    }
}
