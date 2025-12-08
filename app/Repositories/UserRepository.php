<?php
namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function find($id)
    {
        return User::find($id);
    }

    public function update($id, array $data)
    {
        $user = $this->find($id);
        if($user){
            $user->update($data);
        }
        return $user;
    }
}
