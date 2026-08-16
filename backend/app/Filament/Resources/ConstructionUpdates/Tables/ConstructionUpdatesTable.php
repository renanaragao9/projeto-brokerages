<?php

namespace App\Filament\Resources\ConstructionUpdates\Tables;

use App\Filament\Filters\Common\CreatedAtFilter;
use App\Filament\Resources\ConstructionUpdates\Schemas\ConstructionUpdateForm;
use App\Models\ConstructionUpdate;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ConstructionUpdatesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Imagem')
                    ->disk('public')
                    ->width(100)
                    ->height(70)
                    ->checkFileExistence(false),

                TextColumn::make('property.name')
                    ->label('Imóvel')
                    ->searchable()
                    ->limit(40),

                TextColumn::make('author_name')
                    ->label('Enviado por')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('message')
                    ->label('Mensagem')
                    ->limit(40)
                    ->placeholder('-'),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (?string $state): string => ConstructionUpdateForm::STATUS_LABELS[$state] ?? $state ?? '-'),

                TextColumn::make('created_at')
                    ->label('Enviado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options(ConstructionUpdateForm::STATUS_LABELS),

                CreatedAtFilter::make(),
            ])
            ->recordActions([
                Action::make('approve')
                    ->label('Aprovar')
                    ->icon(Heroicon::OutlinedCheckCircle)
                    ->color('success')
                    ->visible(fn (ConstructionUpdate $record): bool => $record->status !== 'approved')
                    ->requiresConfirmation()
                    ->action(function (ConstructionUpdate $record): void {
                        $record->update(['status' => 'approved', 'rejection_reason' => null]);

                        Notification::make()
                            ->title('Atualização aprovada')
                            ->success()
                            ->send();
                    }),

                Action::make('reject')
                    ->label('Recusar')
                    ->icon(Heroicon::OutlinedXCircle)
                    ->color('danger')
                    ->visible(fn (ConstructionUpdate $record): bool => $record->status !== 'rejected')
                    ->requiresConfirmation()
                    ->form([
                        Textarea::make('rejection_reason')
                            ->label('Motivo da recusa')
                            ->rows(3),
                    ])
                    ->action(function (ConstructionUpdate $record, array $data): void {
                        $record->update([
                            'status' => 'rejected',
                            'rejection_reason' => $data['rejection_reason'] ?? null,
                        ]);

                        Notification::make()
                            ->title('Atualização recusada')
                            ->danger()
                            ->send();
                    }),

                ViewAction::make()
                    ->icon(Heroicon::OutlinedEye),
                EditAction::make()
                    ->icon(Heroicon::OutlinedPencil),
                DeleteAction::make()
                    ->icon(Heroicon::OutlinedTrash),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
