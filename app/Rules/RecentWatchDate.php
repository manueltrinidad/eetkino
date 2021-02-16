<?php


namespace App\Rules;


use DateTime;
use Illuminate\Contracts\Validation\Rule;

class RecentWatchDate implements Rule
{
    /**
     * Checks if the provided watch date is bigger than the earliest film in TMDb.
     *
     * Fuck you if you watched 'Passage of Venus' in 1874 you skeleton.
     * Seriously tho, what can I do if someone wants to fill in their grand-grand-parent's diary?
     * Maybe the old man actually watched the thing live... lucky bastard >:(
     *
     * @param $attribute
     * @param $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        if(!DateTime::createFromFormat('Y-m-d', $value)) {
            return false;
        }
        $date = strtotime($value);
        return $date >= strtotime('1874-12-09') && $date <= strtotime('today');
    }

    /**
     *
     * @return string
     */
    public function message(): string
    {
        return 'The :attribute is not in the valid range.';
    }
}
