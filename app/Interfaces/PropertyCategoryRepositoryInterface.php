<?php

namespace App\Interfaces;

interface PropertyCategoryRepositoryInterface
{
    public function getAllPropertyCategories();

    public function create(array $data);

    public function getPropertyCategoryById(string $id);

    public function update(array $data, string $id);

    public function delete(string $id);

    public function generateSlug(string $name, int $tryCount): string;

    public function isUniqueSlug(string $slug, string $exceptId = null): bool;
}
