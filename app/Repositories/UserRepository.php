<?php


namespace App\Repositories;


use App\Exceptions\User\UserNotFoundException;
use App\Models\User;
use Exception;
use App\Traits\GetModelPropertiesTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class UserRepository
{
    use GetModelPropertiesTrait;

    /**
     * Creates new user in the database. Returns the User as an array. Includes API Key, which
     * is usually hidden. Returns null upon failure.
     * @param $userData array
     * @return array|null
     */
    public function registerUser(array $userData): ?array
    {
        try {
            return User::create($userData)->makeVisible('api_key')->toArray();
        } catch (QueryException) {
            return null;
        }
    }

    /**
     * Deletes a User provided an email. Authentication must be done beforehand!
     * @param string $email
     * @return bool|null
     */
    public function deleteByEmail(string $email): ?bool
    {
        try {
            return User::where('email', '=', $email)->delete();
        } catch (Exception) {
            return false;
        }
    }

    /**
     * Gets a User using any method (key) of Authentication. Returns Null upon failure.
     * @param string $key id or api_key
     * @param string $value Value of the Key.
     * @return array|null
     */
    public function getUser(string $key, string $value): ?array
    {
        try {
            return User::where($key, '=', $value)->firstOrFail()->toArray();
        } catch (ModelNotFoundException) {
            return null;
        }
    }

    /**
     * Gets a User's properties using any method (key) of Authentication. Returns Null upon failure.
     * @param string $key
     * @param string $value
     * @param mixed ...$properties
     * @return array|null
     * @throws UserNotFoundException
     */
    public function getUserProperties(string $key, string $value, ...$properties): ?array
    {
        try {
            $user = User::where($key, '=', $value)->firstOrFail();
            return $this->getProperties($user, $properties);
        } catch (ModelNotFoundException) {
            throw new UserNotFoundException("The provided id for {$key} was not found.");
        }
    }

}
