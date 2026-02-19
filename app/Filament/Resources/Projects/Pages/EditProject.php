<?php

namespace App\Filament\Resources\Projects\Pages;

use App\Filament\Resources\Projects\ProjectResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Filament\Actions\Action;

class EditProject extends EditRecord
{
    protected static string $resource = ProjectResource::class;

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


        // HERO
        if (!empty($data['hero_upload'])) {
            $heroPath = collect($data['hero_upload'])->first();
            $record
                ->clearMediaCollection('hero')
                ->addMedia(Storage::disk('public')->path($heroPath))
                ->toMediaCollection('hero');

            Storage::disk('public')->delete($data['hero_upload']);
        }

        // GALERIA
        if (!empty($data['gallery_upload'])) {
            foreach ($data['gallery_upload'] as  $key => $file) {
                $record
                    ->addMedia(Storage::disk('public')->path($file))
                    ->toMediaCollection('gallery');

                Storage::disk('public')->delete($file);
            }
        }
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
