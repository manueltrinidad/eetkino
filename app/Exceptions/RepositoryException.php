<?php


namespace App\Exceptions;


use Exception;

class RepositoryException extends Exception
{
    protected array $errors;

    /**
     * ServiceException constructor.
     * @param array $errors
     */
    public function __construct(array $errors)
    {
        parent::__construct();
        $this->errors = $errors;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
