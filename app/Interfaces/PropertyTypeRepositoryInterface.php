<?php

namespace App\Interfaces;

interface PropertyTypeRepositoryInterface
{
    public function getAllPropertyTypes();

    public function create(array $data);

    public function getPropertyTypeById(string $id);

    public function update(array $data, string $id);

    public function delete(string $id);

    public function generateSlug(string $name, int $tryCount): string;

    public function isUniqueSlug(string $slug, string $exceptId = null): bool;
}
