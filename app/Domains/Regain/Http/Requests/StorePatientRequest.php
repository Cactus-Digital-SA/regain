<?php

namespace App\Domains\Regain\Http\Requests;

use App\Domains\Auth\Repositories\Eloquent\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StorePatientRequest extends FormRequest
{
    private const NAME            = 'name';
    private const EMAIL           = 'email';
    private const BIRTHDAY        = 'birthday';
    private const REGION          = 'region_id';
    private const POSTCODE        = 'post_code';
    private const PHONE           = 'primary_phone';
    private const SECONDARY_PHONE = 'secondary_phone';

    public function authorize(): bool
    {
        if (Auth::check()) {
            /** @var User|null $user */
            $user = User::query()->find(Auth::id());

            return $user?->isRegainUser();
        }

        return false;
    }

    public function rules(): array
    {
        return [
            self::NAME            => ['required', 'string'],
            self::EMAIL           => ['required', 'email', Rule::unique('users', 'email')],
            self::BIRTHDAY        => ['required', 'date'],
            self::REGION          => ['required', 'exists:regions,id'],
            self::POSTCODE        => ['required', 'integer'],
            self::PHONE           => ['required', 'string'],
            self::SECONDARY_PHONE => ['nullable', 'string'],
        ];
    }

    public function getName(): int
    {
        return (int)$this->input(self::NAME);
    }

    public function getEmail(): string
    {
        return $this->input(self::EMAIL);
    }

    public function getBirthday(): string
    {
        return $this->input(self::BIRTHDAY);
    }

    public function getRegion(): int
    {
        return (int)$this->input(self::REGION);
    }

    public function getPostCode(): int
    {
        return (int)$this->input(self::POSTCODE);
    }

    public function getPhone(): string
    {
        return $this->input(self::PHONE);
    }

    public function getSecondaryPhone(): ?string
    {
        return $this->input(self::SECONDARY_PHONE);
    }
}
