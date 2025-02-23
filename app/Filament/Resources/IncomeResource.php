<?php

namespace App\Filament\Resources;

use App\Filament\Pages\Widgets\PaymentOverview;
use App\Filament\Resources\IncomeResource\Pages;
use App\Models\Income;
use App\Models\IncomeCategory;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Gate;

class IncomeResource extends Resource
{
    protected static ?string $model = Income::class;
    protected static ?string $label = 'Payments';
    protected static ?string $recordTitleAttribute = 'Payments';
    protected static ?string $navigationLabel = 'Payments';
    protected static ?string $navigationIcon = 'heroicon-o-arrow-left-end-on-rectangle';
    protected static ?int $navigationSort = 2;

    public static function canViewAny(): bool
    {
        return Gate::allows('viewPayments');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('entry_date')
                    ->label('Date')
                    ->native(true)
                    ->reactive()
                    ->date('d/m/Y')
                    ->required(),
                Forms\Components\Select::make('user_id')
                    ->searchable()
                    ->label('User')
                    ->preload()
                    ->native(true)
                    ->relationship('user', 'name'),
                Forms\Components\Select::make('income_category_id')
                    ->label('Category')
                    ->relationship('income_category', 'name')
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->label('Name')
                            ->maxLength(255)
                            ->required(),
                        Forms\Components\Radio::make('deposit')
                            ->label('Deposit type')
                            ->inline()
                            ->options(IncomeCategory::DEPOSIT_RADIO)
                            ->required(),
                    ])
                    ->editOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->label('Name')
                            ->maxLength(255)
                            ->required(),
                        Forms\Components\Radio::make('deposit')
                            ->label('Deposit type')
                            ->inline()
                            ->options(IncomeCategory::DEPOSIT_RADIO)
                            ->required(),
                    ])
                    ->required(),
                Forms\Components\TextInput::make('amount')
                    ->label('Amount')
                    ->numeric(2, ',', '.')
                    ->suffix('€')
                    ->required(),
                Forms\Components\TextInput::make('description')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->paginationPageOptions(['10', '25', '50'])
            ->columns([
                Tables\Columns\TextColumn::make('entry_date')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->searchable(),
                Tables\Columns\TextColumn::make('income_category.name')
                    ->label('Payment type')
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Amount')
                    ->numeric(2, ',', '.')
                    ->alignEnd()
                    ->suffix(' €'),
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
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->visible(fn() => auth()->user()->is_admin),
            ])
            ->defaultSort('entry_date', 'desc')
            ->persistSortInSession()
            ->filters([
                Tables\Filters\Filter::make('entry_date')
                    ->form([
                        Forms\Components\DatePicker::make('entry_date_from')
                            ->native(true)
                            ->reactive(),
                        Forms\Components\DatePicker::make('entry_date_until')
                            ->native(true)
                            ->reactive(),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['entry_date_from'] ?? null,
                                fn(Builder $query, $date): Builder => $query->whereDate('entry_date', '>=', $date),
                            )
                            ->when(
                                $data['entry_date_until'] ?? null,
                                fn(Builder $query, $date): Builder => $query->whereDate('entry_date', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['entry_date_from'] ?? null) {
                            $indicators['event_from'] = 'Event from ' . \Illuminate\Support\Carbon::parse($data['entry_date_from'])->toFormattedDateString();
                        }
                        if ($data['entry_date_until'] ?? null) {
                            $indicators['entry_date_until'] = 'Event until ' . Carbon::parse($data['entry_date_until'])->toFormattedDateString();
                        }

                        return $indicators;
                    }),
                Tables\Filters\SelectFilter::make('user.name')
                    ->label('Name')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->visible(fn() => auth()->user()->is_admin),
                Tables\Filters\TrashedFilter::make()
                    ->query(function ($query) {
                        if (!auth()->user()->is_admin) {
                            // Remove trashed data
                            $query->withoutTrashed();
                        } else {
                            $query->withTrashed();
                        }
                    })
                    ->visible(fn() => auth()->user()->is_admin),
            ])
            ->persistFiltersInSession(false)
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->groups([]);
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
            'index' => Pages\ListIncomes::route('/'),
            'create' => Pages\CreateIncome::route('/create'),
            'edit' => Pages\EditIncome::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()->OfDefaultDepositCategory();

        if (auth()->user()->is_admin) {
            return $query->withoutGlobalScopes();
        }

        return $query;
    }
}
