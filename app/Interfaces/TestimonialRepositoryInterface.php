<?php

namespace App\Interfaces;

interface TestimonialRepositoryInterface
{
    public function getAllTestimonials();

    public function getTestimonialById(string $id);

    public function createTestimonial(array $data);

    public function updateTestimonial(array $data, string $id);

    public function deleteTestimonial(string $id);
}
