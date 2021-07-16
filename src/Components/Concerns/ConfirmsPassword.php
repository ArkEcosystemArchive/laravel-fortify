<?php

declare(strict_types=1);

namespace ARKEcosystem\Fortify\Components\Concerns;

use ARKEcosystem\UserInterface\Http\Livewire\Concerns\HasModal;
use Illuminate\Support\Facades\Hash;

trait ConfirmsPassword
{
    use InteractsWithUser;
    use HasModal;

    public bool $confirmPasswordShown = false;

    public string $confirmedPassword = '';

    public string $confirmPasswordTitle = '';

    public string $confirmPasswordDescription = '';

    public ?string $confirmPasswordOnClose = null;

    public ?string $confirmPasswordOnConfirm = null;

    public function showConfirmPassword(
        string $title = '',
        string $description = '',
        ?string $onConfirm = null,
        ?string $onClose = null,
    ): void {
        $this->confirmPasswordTitle = $title;

        $this->confirmPasswordDescription = $description;

        $this->confirmPasswordOnConfirm = $onConfirm;

        $this->confirmPasswordOnClose = $onClose;

        $this->confirmPasswordShown = true;
    }

    public function resetConfirmModal(): void
    {
        $this->confirmPasswordShown = false;

        $this->confirmedPassword = '';

        $this->confirmPasswordTitle = '';

        $this->confirmPasswordDescription = '';

        $this->confirmPasswordOnClose = null;

        $this->confirmPasswordOnConfirm = null;

        $this->modalClosed();
    }

    public function cancelConfirmPassword(): void
    {
        if ($this->confirmPasswordOnClose && method_exists($this, $this->confirmPasswordOnClose)) {
            $this->{$this->confirmPasswordOnClose}();
        }

        $this->resetConfirmModal();
    }

    public function submitConfirmPassword(): void
    {
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
