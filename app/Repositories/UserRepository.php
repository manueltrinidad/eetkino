<?php


namespace App\Repositories;


use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserRepository
{
    public function getUserByChatId($chatId)
    {
        try {
            return User::where('chat_id', $chatId)->firstorFail();
        } catch (ModelNotFoundException $e) {
            return False;
        }
    }
}
