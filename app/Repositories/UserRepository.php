<?php


namespace App\Repositories;


use App\Exceptions\User\UserNotDeletedException;
use App\Exceptions\User\UserNotFoundException;
use App\Exceptions\User\UserNotRegisteredException;
use App\Models\User;
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
     * @throws UserNotRegisteredException
     */
    public function registerUser(array $userData): ?array
    {
        try {
            return User::create($userData)->makeVisible('api_key')->toArray();
        } catch (QueryException) {
            throw new UserNotRegisteredException();
        }
    }

    /**
     * Deletes a User identified by a key. Authentication must be done beforehand!
     * @param string $key
     * @param string $value
     * @return bool|null
     * @throws UserNotFoundException
     * @throws UserNotDeletedException
     */
    public function deleteByKeyValue(string $key, string $value): ?bool
    {
        try {
            if(User::where($key, '=', $value)->firstOrFail()->delete()) {
                return true;
            } else {
                throw new UserNotDeletedException();
            }
        } catch (ModelNotFoundException) {
            throw new UserNotFoundException();
        }
    }

    /**
     * Gets a User using any method (key) of Authentication. Returns Null upon failure.
     * @param string $key id or api_key
     * @param string $value Value of the Key.
     * @param bool $withApiKey
     * @return array|null
     * @throws UserNotFoundException
     */
    public function getUser(string $key, string $value, bool $withApiKey = false): ?array
    {
        try {
            if($withApiKey) {
                return User::where($key, '=', $value)->firstOrFail()->makeVisible('api_key')->toArray();
            }
            return User::where($key, '=', $value)->firstOrFail()->toArray();
        } catch (ModelNotFoundException) {
            throw new UserNotFoundException('The User was not found');
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

    /**
     * Updates an array of properties on a User given a key and value to query it.
     * @param string $key
     * @param string $value
     * @param array $properties
     * @throws UserNotFoundException
     */
    public function update(string $key, string $value, array $properties)
    {
        try {
            User::where($key, '=', $value)->firstOrFail()->update($properties);
        } catch (ModelNotFoundException) {
            throw new UserNotFoundException("The provided id for {$key} was not found.");
        }
    }
}
