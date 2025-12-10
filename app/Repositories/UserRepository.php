<?php
namespace App\Repositories;

use App\Models\User;

class UserRepository
{
     /**
     * Find user by id
     */
    public function find($id)
    {
        return User::find($id);
    }

    /**
     * Create a new user
     */
    public function create(array $data): User
    {
        return User::create($data);
    }

    /**
     * Update user by id
     */
    public function update($id, array $data)
    {
        $user = $this->find($id);
        if ($user) {
            $user->update($data);
        }
        return $user;
    }

    /**
     * Save a User model instance
     */
    public function save(User $user)
    {
        $user->save();
        return $user;
    }

    /**
     * Find user by phone
     */
    public function findByPhone(string $phone)
    {
        return User::where('phone', $phone)->first();
    }

    /**
     * Find user by email OR phone.
     *
     * Accepts:
     * - string identifier (email or phone)
     * - array with keys: 'email' or 'phone' (works with the $data array you pass from AuthService)
     *
     * Returns first matching User or null.
     */
    public function findByEmailOrPhone($identifier)
    {
        // Normalize input: accept array or string
        if (is_array($identifier)) {
            // try common keys
            $identifier = $identifier['email'] ?? $identifier['phone'] ?? $identifier['identifier'] ?? null;
        }

        if (!$identifier) {
            return null;
        }

        return User::where('email', $identifier)
                    ->orWhere('phone', $identifier)
                    ->first();
    }
}
