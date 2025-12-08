<?php
namespace App\Services;

use App\Repositories\UserRepository;

class UserService
{
    public function __construct(private UserRepository $repo){}

    public function getProfile($id)
    {
        return $this->repo->find($id);
    }

    public function updateProfile($id, array $data)
    {
        return $this->repo->update($id, $data);
    }
}
