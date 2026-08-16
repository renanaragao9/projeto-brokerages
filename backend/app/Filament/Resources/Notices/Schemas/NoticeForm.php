<?php

namespace App\Filament\Resources\Notices\Schemas;

use App\Models\Bank;
use App\Models\Broker;
use App\Models\Construction;
use App\Models\Property;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MorphToSelect;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class NoticeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                Section::make('Notícia')
                    ->columnSpanFull()
                    ->columns(2)
                    ->schema([
                        TextInput::make('title')
                            ->label('Título')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, $set) => $set('slug', str($state ?? '')->slug()))
                            ->columnSpanFull(),

                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->live(onBlur: true)
                            ->dehydrateStateUsing(fn (?string $state) => str($state ?? '')->slug())
                            ->afterStateUpdated(fn ($state, $set) => $set('slug', str($state ?? '')->slug()))
                            ->helperText('Usado na URL pública da notícia. Formatado automaticamente (minúsculas, sem espaço/acento).')
                            ->columnSpanFull(),

                        Textarea::make('excerpt')
                            ->label('Resumo')
                            ->rows(2)
                            ->helperText('Texto curto exibido na listagem de notícias.')
                            ->columnSpanFull(),

                        RichEditor::make('content')
                            ->label('Conteúdo')
                            ->required()
                            ->columnSpanFull(),

                        FileUpload::make('image_path')
                            ->label('Imagem de capa')
                            ->image()
                            ->disk('public')
                            ->directory('notices')
                            ->columnSpanFull(),

                        TextInput::make('media_url')
                            ->label('Link de imagem ou vídeo')
                            ->url()
                            ->maxLength(255)
                            ->helperText('URL de uma imagem, vídeo (mp4) ou vídeo do YouTube/Vimeo para exibir na notícia.')
                            ->placeholder('https://...')
                            ->columnSpanFull(),
                    ]),

                Section::make('Vínculo')
                    ->description('A quem esta notícia se refere: uma construtora, um corretor ou um imóvel específico.')
                    ->columnSpanFull()
                    ->schema([
                        MorphToSelect::make('noticeable')
                            ->label('Relacionado a')
                            ->types([
                                MorphToSelect\Type::make(Construction::class)
                                    ->titleAttribute('name')
                                    ->label('Construtora'),
                                MorphToSelect\Type::make(Broker::class)
                                    ->titleAttribute('name')
                                    ->label('Corretor'),
                                MorphToSelect\Type::make(Property::class)
                                    ->titleAttribute('name')
                                    ->label('Imóvel'),
                                MorphToSelect\Type::make(Bank::class)
                                    ->titleAttribute('name')
                                    ->label('Banco'),
                            ])
                            ->searchable()
                            ->columnSpanFull(),
                    ]),

                Section::make('Publicação')
                    ->columnSpanFull()
                    ->columns(2)
                    ->schema([
                        Toggle::make('is_published')
                            ->label('Publicada')
                            ->live()
                            ->default(false),

                        DateTimePicker::make('published_at')
                            ->label('Publicada em')
                            ->seconds(false)
                            ->default(fn () => now()),
                    ]),
            ]);
    }
}
