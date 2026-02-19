<?php

namespace App\Filament\Resources\Pages\Pages;

use App\Filament\Resources\Pages\PageResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;

class CreatePage extends CreateRecord
{
    protected static string $resource = PageResource::class;

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

    public function reorderMedia(array $ids): void
    {
        foreach ($ids as $index => $id) {
            \Spatie\MediaLibrary\MediaCollections\Models\Media::where('id', $id)
                ->update(['order_column' => $index]);
        }

        $this->record->refresh();
    }
}
