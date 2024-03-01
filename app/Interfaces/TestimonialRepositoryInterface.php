<?php

namespace App\Interfaces;

interface TestimonialRepositoryInterface
{
    public function getAllTestimonials();

    public function getTestimonialById(string $id);

    public function create(array $data);

    public function update(array $data, string $id);

    public function delete(string $id);
}
