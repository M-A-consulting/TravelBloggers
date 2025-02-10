<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Filament\Resources\SettingResource\RelationManagers;
use App\Models\Setting;
use App\Models\Settings;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SettingResource extends Resource
{
    protected static ?string $model = Settings::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog';

    protected static ?string $navigationLabel = 'Company Details';

    protected static ?string $navigationGroup = 'Settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    TextInput::make('company_name')
                        ->required()
                        ->maxLength(255),

                    TextInput::make('logo')
                        ->required()
                        ->maxLength(255),

                    RichEditor::make('about')
                        ->nullable(),

                    DatePicker::make('founded_date')
                        ->nullable(),

                    TextInput::make('email')
                        ->nullable()
                        ->email()
                        ->maxLength(255),

                    TextInput::make('phone')
                        ->nullable()
                        ->maxLength(255),

                    RichEditor::make('address')
                        ->nullable(),

                    TextInput::make('founder')
                        ->nullable()
                        ->maxLength(255),

                    RichEditor::make('services_offered')
                        ->nullable(),

                    RichEditor::make('social_links')
                        ->nullable()
                        ->helperText('Enter a social link'),


                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('company_name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->sortable(),

                TextColumn::make('phone')
                    ->sortable(),

                TextColumn::make('founder')
                    ->sortable(),

                TextColumn::make('founded_date')
                    ->sortable()
                    ->date(),

                TextColumn::make('created_at')
                    ->sortable()
                    ->date(),

                TextColumn::make('updated_at')
                    ->sortable()
                    ->date(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSettings::route('/'),
            'create' => Pages\CreateSetting::route('/create'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}
