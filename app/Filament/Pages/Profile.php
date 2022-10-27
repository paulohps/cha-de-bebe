<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Components\{Grid, Section, TextInput};

class Profile extends Page
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationGroup = 'Conta';
    protected static ?string $navigationLabel = 'Perfil';
    protected static string $view = 'filament.pages.profile';
    protected static ?string $slug = 'perfil';

    public string $name;
    public string $email;
    public ?string $currentPassword = null;
    public ?string $newPassword = null;
    public ?string $newPasswordConfirmation = null;

    public function mount(): void
    {
        $this->form->fill([
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
        ]);
    }

    public function submit(): void
    {
        $user = auth()->user()->update($this->form->validate());

        if ($this->newPassword) {
            session()->put(['password_hash_' . auth()->getDefaultDriver() => $user->getAuthPassword()]);
        }

        $this->reset(['currentPassword', 'newPassword', 'newPasswordConfirmation']);
        $this->notify('success', 'Perfil atualizado com sucesso!');
    }

    protected function getFormSchema(): array
    {
        return [
            Section::make('Geral')
                ->columns(2)
                ->schema([
                    TextInput::make('name')
                        ->required(),
                    TextInput::make('email')
                        ->label('Email Address')
                        ->required()
                        ->email()
                        ->unique(ignoreRecord: true),
                ]),
            Section::make('Atualizar Senha')
                ->columns(2)
                ->schema([
                    TextInput::make('currentPassword')
                        ->label('Senha Atual')
                        ->password()
                        ->requiredWith('newPassword')
                        ->currentPassword()
                        ->autocomplete('off')
                        ->columnSpan(1),
                    Grid::make()
                        ->schema([
                            TextInput::make('newPassword')
                                ->label('Nova Senha')
                                ->password()
                                ->confirmed()
                                ->autocomplete('new-password'),
                            TextInput::make('newPasswordConfirmation')
                                ->label('Confirme a nova senha')
                                ->password()
                                ->requiredWith('newPassword')
                                ->autocomplete('new-password'),
                        ]),
                ]),
        ];
    }
}
