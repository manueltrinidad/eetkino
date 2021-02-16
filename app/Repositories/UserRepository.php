<?php


namespace App\Repositories;


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
     * @param mixed ...$properties
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
     */
    public function getUserProperties(string $key, string $value, ...$properties): ?array
    {
        try {
            $user = User::where($key, '=', $value)->firstOrFail();
            return $this->getProperties($user, $properties);
        } catch (ModelNotFoundException) {
            return null;
        }
    }

    /**
     * Tests the API key against the User providing a key and value to query it. Returns
     * true / false if it is authenticated and null if the User wasn't found.
     * @param string $api_key
     * @param string $key id, username, email, api_key (last one beats the purpose tho)
     * @param string $value value of the key.
     * @return bool|null
     */
    public function isApiKeyFromUser(string $api_key, string $key, string $value): ?bool
    {
        try {
            $user = User::where($key, '=', $value)->firstOrFail();
            return $user->api_key === $api_key;
        } catch (ModelNotFoundException) {
            return null;
        }
    }
}
