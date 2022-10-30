<?php

namespace App\Filament\Pages;

use App\Models\User;
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

    public function mount(): void
    {
        $this->form->fill([
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
        ]);
    }

    public function submit(): void
    {
        $validated = $this->form->validate();

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email']
        ];

        if ($validated['new_password']) {
            $data['password'] = bcrypt($validated['new_password']);
        }

        /** @var User $user */
        $user = auth()->user();

        $user->update($data);

        if ($validated['new_password']) {
            session()->invalidate();
            session()->regenerateToken();
            $this->redirectRoute('filament.auth.login');
            return;
        }

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
                    TextInput::make('current_password')
                        ->label('Senha Atual')
                        ->password()
                        ->requiredWith('newPassword')
                        ->currentPassword()
                        ->autocomplete('off')
                        ->columnSpan(1),
                    Grid::make()
                        ->schema([
                            TextInput::make('new_password')
                                ->label('Nova Senha')
                                ->password()
                                ->confirmed()
                                ->autocomplete('new-password'),
                            TextInput::make('new_password_confirmation')
                                ->label('Confirme a nova senha')
                                ->password()
                                ->requiredWith('new_password')
                                ->autocomplete('new-password'),
                        ]),
                ]),
        ];
    }
}
