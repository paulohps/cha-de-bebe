<?php

namespace App\Http\Livewire\Numbers;

use App\Models\Number;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Contracts\View\View;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TextInput\Mask;
use Illuminate\Validation\ValidationException;
use Filament\Forms\Concerns\InteractsWithForms;
use Throwable;

class SelectItem extends Component implements HasForms
{
    use InteractsWithForms;

    public Number $number;

    public string $name = '';
    public string $phone = '';
    public bool $captcha = false;

    public bool $showModal = false;
    public bool $isSuccess = false;

    public function render(): View
    {
        return view('livewire.numbers.select-item');
    }

    public function toggleModal(bool $newValue = null): void
    {
        if (!$this->isSuccess && $this->number->isReserved()) {
            return;
        }

        $this->showModal = $newValue ?? !$this->showModal;
    }

    /**
     * @throws Throwable|ValidationException
     */
    public function save(): void
    {
        $this->validate(messages: ['phone' => 'Telefone inválido, formatos válidos: (00) 0000-00000, 00000000000']);

        $phone = unmask($this->phone, ['(', ')', '-', ' ', '+']);

        throw_if(strlen($phone) < 10 || strlen($phone) > 11, ValidationException::withMessages([
            'phone' => 'Telefone inválido, informe seu número com DDD.'
        ]));

        $this->number->update([
            'name' => Str::title($this->name),
            'phone' => unmask($this->phone, ['(', ')', '-', ' ', '+'])
        ]);

        $this->isSuccess = true;
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('name')
                ->autofocus()
                ->maxLength(120)
                ->label('Qual o seu nome?')
                ->required(),
            TextInput::make('phone')
                ->mask(static fn(Mask $mask) => $mask
                    ->pattern('(00) 0000-00000'))
                ->label('Qual o seu whatsapp?')
                ->required()
        ];
    }
}
