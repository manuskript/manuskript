<?php

namespace Manuskript\Fields;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class File extends Field
{
    protected string $type = 'file';

    protected string $disk = 'local';

    public function disk(string $disk): self
    {
        $this->disk = $disk;

        return $this;
    }

    protected function booting(): void
    {
        $this->public = array_unique([...$this->public, 'disk']);

        if (! array_key_exists('upload', $this->decorators ?? [])) {
            $this->decorate('upload', route('manuskript.file-upload'));
        }
    }

    protected function hydrated(array|Model $values): void
    {
        parent::hydrated($values);

        if (! array_key_exists('url', $this->decorators ?? [])) {
            $this->decorate('url', Storage::disk($this->disk)->url($this->value));
        }
    }
}
