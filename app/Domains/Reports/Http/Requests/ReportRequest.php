<?php

declare(strict_types = 1);

namespace App\Domains\Reports\Http\Requests;

use App\Domains\Auth\Repositories\Eloquent\Models\User;
use App\Domains\Reports\Http\Dtos\ReportForm;
use App\Domains\UserResponse\Http\Dtos\SubmittedUserResponseForm;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ReportRequest extends FormRequest
{
    private const USER_ID = 'userId';
    private const FLOW_ID = 'flowId';

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (Auth::check()) {
            /** @var User|null $user */
            $user = User::query()->find(Auth::id());

            return $user?->isPractitioner() || $user?->isRegainUser() || $user?->isAdmin();
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            self::USER_ID => 'required|integer',
            self::FLOW_ID => 'required|integer',
        ];
    }

    public function getUserId(): int
    {
        return (int)$this->input(self::USER_ID);
    }

    public function getFlowId(): int
    {
        return (int)$this->input(self::FLOW_ID);
    }

    public function getReportForm(): ReportForm
    {
        return (new ReportForm())
            ->setUserId($this->getUserId())
            ->setFlowId($this->getFlowId());
    }
}
