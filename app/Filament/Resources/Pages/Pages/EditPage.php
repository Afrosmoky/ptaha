<?php

namespace App\Filament\Resources\Pages\Pages;

use App\Filament\Resources\Pages\PageResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Filament\Actions\Action;

class EditPage extends EditRecord
{
    protected static string $resource = PageResource::class;

    public bool $isReorderModalOpen = false;

    public array $mediaOrder = [];

    protected function getHeaderActions(): array
    {
        return [
            Action::make('reorderMedia')
                ->label('Zmień kolejność zdjęć')
                ->action(fn () => $this->openReorderModal()),
            DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $record = $this->record;
        $data = $this->data;

        if (!empty($data['gallery_upload'])) {
            foreach ($data['gallery_upload'] as $path) {
                $record
                    ->addMedia(Storage::disk('public')->path($path))
                    ->toMediaCollection('gallery');

                Storage::disk('public')->delete($path);
            }
        }
        $this->record->refresh();
    }

    public function deleteMedia(int $mediaId): void
    {
        $media = Media::find($mediaId);

        if (! $media) {
            return;
        }

        if ($media->model_id !== $this->record->id) {
            return;
        }

        $media->delete();

        $this->record->refresh();
    }

    public function reorderMedia(array $ids): void
    {
        foreach ($ids as $index => $id) {
            \Spatie\MediaLibrary\MediaCollections\Models\Media::where('id', $id)
                ->update(['order_column' => $index]);
        }

        $this->record->refresh();
    }

    public function openReorderModal(): void
    {
        $this->mediaOrder = $this->record
            ->getMedia('gallery')
            ->sortBy('order_column')
            ->pluck('id')
            ->toArray();

        $this->isReorderModalOpen = true;
    }

    public function saveMediaOrder(): void
    {
        foreach ($this->mediaOrder as $index => $mediaId) {
            Media::where('id', $mediaId)
                ->update(['order_column' => $index]);
        }

        $this->record->refresh();
        $this->isReorderModalOpen = false;
    }
}
