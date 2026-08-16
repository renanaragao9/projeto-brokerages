<?php

namespace App\Filament\Resources\Notices\Tables;

use App\Filament\Filters\Common\CreatedAtFilter;
use App\Models\Notice;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class NoticesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query->with('noticeable'))
            ->columns([
                ImageColumn::make('image_path')
                    ->label('Capa')
                    ->disk('public')
                    ->width(80)
                    ->height(50)
                    ->checkFileExistence(false),

                TextColumn::make('title')
                    ->label('Título')
                    ->searchable()
                    ->sortable()
                    ->limit(40),

                TextColumn::make('noticeable_type')
                    ->label('Vinculado a')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'App\\Models\\Construction' => 'Construtora',
                        'App\\Models\\Broker' => 'Corretor',
                        'App\\Models\\Property' => 'Imóvel',
                        'App\\Models\\Bank' => 'Banco',
                        default => '-',
                    }),

                TextColumn::make('noticeable.name')
                    ->label('Nome')
                    ->placeholder('-'),

                TextColumn::make('is_published')
                    ->label('Publicada')
                    ->badge()
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Sim' : 'Não')
                    ->color(fn (bool $state): string => $state ? 'success' : 'gray'),

                TextColumn::make('published_at')
                    ->label('Publicada em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->placeholder('-'),

                TextColumn::make('media_url')
                    ->label('Link de mídia')
                    ->limit(30)
                    ->placeholder('-')
                    ->url(fn (?string $state): ?string => $state)
                    ->openUrlInNewTab()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                TernaryFilter::make('is_published')
                    ->label('Publicada'),

                SelectFilter::make('noticeable_type')
                    ->label('Vinculado a')
                    ->options(Notice::NOTICEABLE_TYPES),

                CreatedAtFilter::make(),
            ])
            ->recordActions([
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
