<?php

namespace App\Rules;

use App\Http\Livewire\JournalIndex as ForgotPassword;
use Carbon\Carbon;
use App\Models\Presence;
use App\Http\Middleware\TrustHosts;
use Illuminate\Support\Facades\Hash;
use Barryvdh\Debugbar\ServiceProvider;
use Illuminate\Contracts\Validation\Rule;

class MatchOldPassword implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return Hash::check($value, auth()->user()->password);
    }
    /**
     * remake
     *
     * @param  mixed $id
     * @return void
     */
    public function remake($id)
    {
        (new ForgotPassword())->remake($id);
    }
    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute is match with old password.';
    }
}
