<?php

namespace App\Filament\Resources\Notices\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class NoticeInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Notícia')
                    ->columns(2)
                    ->collapsible()
                    ->collapsed(false)
                    ->schema([
                        TextEntry::make('title')
                            ->label('Título')
                            ->columnSpanFull(),
                        TextEntry::make('slug')
                            ->label('Slug'),
                        TextEntry::make('noticeable_type')
                            ->label('Vinculado a')
                            ->formatStateUsing(fn (?string $state): string => match ($state) {
                                'App\\Models\\Construction' => 'Construtora',
                                'App\\Models\\Broker' => 'Corretor',
                                'App\\Models\\Property' => 'Imóvel',
                                'App\\Models\\Bank' => 'Banco',
                                default => '-',
                            }),
                        TextEntry::make('excerpt')
                            ->label('Resumo')
                            ->placeholder('-')
                            ->columnSpanFull(),
                        TextEntry::make('content')
                            ->label('Conteúdo')
                            ->html()
                            ->columnSpanFull(),
                        ImageEntry::make('image_path')
                            ->label('Imagem de capa')
                            ->disk('public')
                            ->columnSpanFull(),
                        TextEntry::make('media_url')
                            ->label('Link de imagem ou vídeo')
                            ->placeholder('-')
                            ->url(fn (?string $state): ?string => $state)
                            ->openUrlInNewTab()
                            ->columnSpanFull(),
                    ]),

                Section::make('Publicação')
                    ->columns(2)
                    ->collapsible()
                    ->collapsed(false)
                    ->schema([
                        TextEntry::make('is_published')
                            ->label('Publicada')
                            ->formatStateUsing(fn (bool $state): string => $state ? 'Sim' : 'Não'),
                        TextEntry::make('published_at')
                            ->label('Publicada em')
                            ->dateTime('d/m/Y H:i')
                            ->placeholder('-'),
                        TextEntry::make('created_at')
                            ->label('Criado em')
                            ->dateTime('d/m/Y H:i'),
                        TextEntry::make('updated_at')
                            ->label('Atualizado em')
                            ->dateTime('d/m/Y H:i'),
                    ]),
            ]);
    }
}
