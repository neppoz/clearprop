<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActivityResource\Pages;
use App\Filament\Resources\ActivityResource\RelationManagers;
use App\Models\Activity;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ActivityResource extends Resource
{
    protected static ?string $model = Activity::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('event_start'),
                Forms\Components\TextInput::make('event_stop'),
                Forms\Components\Toggle::make('engine_warmup'),
                Forms\Components\TextInput::make('warmup_start')
                    ->numeric(),
                Forms\Components\TextInput::make('counter_start')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('counter_stop')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('warmup_minutes')
                    ->numeric(),
                Forms\Components\TextInput::make('rate')
                    ->numeric(),
                Forms\Components\TextInput::make('minutes')
                    ->numeric(),
                Forms\Components\TextInput::make('amount')
                    ->numeric(),
                Forms\Components\TextInput::make('departure')
                    ->maxLength(255),
                Forms\Components\TextInput::make('arrival')
                    ->maxLength(255),
                Forms\Components\Toggle::make('split_cost')
                    ->required(),
                Forms\Components\DatePicker::make('event')
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Forms\Components\Select::make('plane_id')
                    ->relationship('plane', 'id')
                    ->required(),
                Forms\Components\Select::make('type_id')
                    ->relationship('type', 'name')
                    ->required(),
                Forms\Components\Select::make('copilot_id')
                    ->relationship('copilot', 'name'),
                Forms\Components\Select::make('instructor_id')
                    ->relationship('instructor', 'name'),
                Forms\Components\Select::make('created_by_id')
                    ->relationship('created_by', 'name'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('event')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('plane.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('departure')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('event_start')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('arrival')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('event_stop')
                    ->toggleable(isToggledHiddenByDefault: true),
//                Tables\Columns\IconColumn::make('engine_warmup')
//                    ->boolean()
//                    ->toggleable(isToggledHiddenByDefault: true),

//                Tables\Columns\TextColumn::make('warmup_start')
//                    ->numeric()
//                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('split_cost')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('copilot.name')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('counter_start')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('counter_stop')
                    ->numeric()
                    ->sortable(),
//                Tables\Columns\TextColumn::make('rate')
//                    ->numeric()
//                    ->sortable(),
                Tables\Columns\TextColumn::make('warmup_minutes')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('minutes')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),


                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),


//                Tables\Columns\TextColumn::make('type.name')
//                    ->numeric()
//                    ->sortable(),

//                Tables\Columns\TextColumn::make('instructor.name')
//                    ->numeric()
//                    ->sortable(),
                Tables\Columns\TextColumn::make('created_by.name')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListActivities::route('/'),
            'create' => Pages\CreateActivity::route('/create'),
            'edit' => Pages\EditActivity::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
