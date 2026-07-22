<?php

namespace App\Repositories;

use App\Models\Template;
use Illuminate\Database\Eloquent\Collection;

class TemplateRepository
{
    public function getAll(): Collection
    {
        return Template::latest()->get();
    }

    public function getById(int $id): ?Template
    {
        return Template::findOrFail($id);
    }

    public function create(array $data): Template
    {
        return Template::create($data);
    }

    public function update(Template $template, array $data): bool
    {
        return $template->update($data);
    }

    public function delete(Template $template): bool
    {
        return $template->delete();
    }
}
