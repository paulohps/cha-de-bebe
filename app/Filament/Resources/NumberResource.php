<?php

namespace App\Filament\Resources;

use App\Models\Number;
use Filament\{Forms, Tables};
use Illuminate\Database\Eloquent\Collection;
use Filament\Resources\{Form, Resource, Table};
use App\Filament\Resources\NumberResource\Pages;

class NumberResource extends Resource
{
    protected static ?string $model = Number::class;

    protected static ?string $navigationIcon = 'heroicon-o-calculator';

    protected static ?string $modelLabel = 'Número';
    protected static ?string $pluralModelLabel = 'Números';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('value')
                    ->integer()
                    ->minValue(1)
                    ->unique(ignoreRecord: true)
                    ->disabled(static fn(Number $record = null) => $record?->id !== null)
                    ->label('Número')
                    ->required()
                    ->columnSpan(static fn(Number $record = null) => $record?->id ? 2 : 1),
                Forms\Components\Select::make('diaper_id')
                    ->relationship('diaper', 'name')
                    ->label('Fralda')
                    ->required(),
                Forms\Components\Select::make('approved_id')
                    ->relationship('approvedBy', 'name')
                    ->label('Aprovado por')
                    ->visibleOn('edit')
                    ->disabled(),
                Forms\Components\TextInput::make('name')
                    ->maxLength(120)
                    ->label('Nome'),
                Forms\Components\TextInput::make('phone')
                    ->mask(static fn(Forms\Components\TextInput\Mask $mask) => $mask
                        ->pattern('(00) 0000-00000'))
                    ->tel()
                    ->label('Telefone'),
                Forms\Components\Textarea::make('observations')
                    ->maxLength(500)
                    ->columnSpan(2)
                    ->label('Observações')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('value')
                    ->label('número')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('diaper.name')
                    ->label('fralda')
                    ->default('---')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('approvedBy.name')
                    ->label('aprovado por')
                    ->default('---')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('nome')
                    ->default('---')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('telefone')
                    ->url(static fn(Number $record): string => $record->phone ? "https://wa.me/+55$record->phone" : false, true)
                    ->formatStateUsing(static fn(string $state) => mask($state, '(##) ####-#####'))
                    ->default('---')
                    ->searchable(),
                Tables\Columns\TextColumn::make('approved_at')
                    ->dateTime()
                    ->label('aprovado em')
                    ->sortable()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\Action::make('approve')
                        ->mountUsing(fn(Forms\ComponentContainer $form, Number $record) => $form->fill([
                            'name' => $record->name,
                            'phone' => $record->phone
                        ]))
                        ->action(static fn(Number $record, array $data) => $record->approve(...$data))
                        ->visible(fn(Number $record) => !$record->isExpired() && !$record->isApproved())
                        ->requiresConfirmation()
                        ->label('Aprovar')
                        ->color('success')
                        ->icon('heroicon-o-check')
                        ->form([
                            Forms\Components\TextInput::make('name')
                                ->maxLength(120)
                                ->label('Nome')
                                ->required(),
                            Forms\Components\TextInput::make('phone')
                                ->mask(static fn(Forms\Components\TextInput\Mask $mask) => $mask
                                    ->pattern('(00) 0000-00000'))
                                ->tel()
                                ->label('Telefone')
                                ->required()
                        ]),
                    Tables\Actions\Action::make('disapprove')
                        ->action(static fn(Number $record) => $record->disapprove())
                        ->visible(fn(Number $record) => $record->isApproved())
                        ->requiresConfirmation()
                        ->label('Desaprovar')
                        ->color('danger')
                        ->icon('heroicon-o-x')
                        ->tooltip('Volta para o status de não aprovado!'),
                    Tables\Actions\Action::make('remove')
                        ->action(static fn(Number $record) => $record->reset())
                        ->visible(fn(Number $record) => $record->itHasAnOwner())
                        ->requiresConfirmation()
                        ->label('Remover')
                        ->color('danger')
                        ->icon('heroicon-o-trash')
                        ->tooltip('Remove nome e telefone!')
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('multiple-disapprove')
                    ->action(static fn(Collection $records) => $records->each->disapprove())
                    ->requiresConfirmation()
                    ->label('Desaprovar')
                    ->color('danger')
                    ->icon('heroicon-o-x')
                    ->deselectRecordsAfterCompletion(),
                Tables\Actions\BulkAction::make('multi-remove')
                    ->action(static fn(Collection $records) => $records->each->reset())
                    ->requiresConfirmation()
                    ->label('Remover')
                    ->color('danger')
                    ->icon('heroicon-o-trash')
                    ->deselectRecordsAfterCompletion()
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageNumbers::route('/')
        ];
    }
}
