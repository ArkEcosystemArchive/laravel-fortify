<?php

declare(strict_types=1);

namespace ARKEcosystem\Fortify\Components\Concerns;

use ARKEcosystem\UserInterface\Http\Livewire\Concerns\HasModal;
use Exception;
use Illuminate\Support\Facades\Hash;

trait ConfirmsPassword
{
    use InteractsWithUser;
    use HasModal;

    public bool $confirmPasswordShown = false;

    public string $confirmedPassword = '';

    public string $confirmPasswordTitle = '';

    public string $confirmPasswordDescription = '';

    public ?string $confirmPasswordOnConfirm = null;

    private function showConfirmPassword(
        string $title = '',
        string $description = '',
        ?string $onConfirm = null,
    ): void {
        $this->confirmPasswordTitle = $title;

        $this->confirmPasswordDescription = $description;

        $this->confirmPasswordOnConfirm = $onConfirm;

        $this->confirmPasswordShown = true;
    }

    public function resetConfirmModal(): void
    {
        $this->confirmPasswordShown = false;

        $this->confirmedPassword = '';

        $this->confirmPasswordTitle = '';

        $this->confirmPasswordDescription = '';

        $this->confirmPasswordOnConfirm = null;

        $this->modalClosed();
    }

    public function cancelConfirmPassword(): void
    {
        $this->resetConfirmModal();
    }

    public function submitConfirmPassword(): void
    {
        if (! $this->hasConfirmedPassword()) {
            // the only way to get here is if the user faked the ajax request
            throw new Exception();
        }

        if ($this->confirmPasswordOnConfirm && method_exists($this, $this->confirmPasswordOnConfirm)) {
            $this->{$this->confirmPasswordOnConfirm}();
        }

        $this->resetConfirmModal();
    }

    public function hasConfirmedPassword(): bool
    {
        return Hash::check($this->confirmedPassword, $this->user->password);
    }
}
