<?php

namespace App\Services;

use App\Models\Template;
use App\Repositories\TemplateRepository;
use Illuminate\Database\Eloquent\Collection;

class TemplateService
{
    public function __construct(private readonly TemplateRepository $repository) {}

    public function getAllTemplates(): Collection
    {
        return $this->repository->getAll();
    }

    public function getTemplateById(int $id): ?Template
    {
        return $this->repository->getById($id);
    }

    public function createTemplate(array $data): Template
    {
        $data['is_active'] = isset($data['is_active']) ? (bool) $data['is_active'] : false;

        return $this->repository->create($data);
    }

    public function updateTemplate(Template $template, array $data): bool
    {
        $data['is_active'] = isset($data['is_active']) ? (bool) $data['is_active'] : false;

        return $this->repository->update($template, $data);
    }

    public function deleteTemplate(Template $template): bool
    {
        return $this->repository->delete($template);
    }
}
