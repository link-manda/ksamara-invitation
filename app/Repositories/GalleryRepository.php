<?php

namespace App\Repositories;

use App\Models\Gallery;

class GalleryRepository
{
    public function create(array $data): Gallery
    {
        return Gallery::create($data);
    }
}
