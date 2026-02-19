<?php

namespace App\Filament\Resources\Projects\Pages;

use App\Filament\Resources\Projects\ProjectResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;

class CreateProject extends CreateRecord
{
    protected static string $resource = ProjectResource::class;


    protected function afterSave(): void
    {
        $record = $this->record;
        $data = $this->data;

        // HERO
        if (!empty($data['hero_upload'])) {
            $record
                ->clearMediaCollection('hero')
                ->addMedia(Storage::disk('public')->path($data['hero_upload']))
                ->toMediaCollection('hero');

            Storage::disk('public')->delete($data['hero_upload']);
        }

        // GALERIA
        if (!empty($data['gallery_upload'])) {
            foreach ($data['gallery_upload'] as $file) {
                $record
                    ->addMedia(Storage::disk('public')->path($file))
                    ->toMediaCollection('gallery');

                Storage::disk('public')->delete($file);
            }
        }
    }

    public function reorderMedia(array $ids): void
    {
        foreach ($ids as $index => $id) {
            \Spatie\MediaLibrary\MediaCollections\Models\Media::where('id', $id)
                ->update(['order_column' => $index]);
        }

        $this->record->refresh();
    }
}
