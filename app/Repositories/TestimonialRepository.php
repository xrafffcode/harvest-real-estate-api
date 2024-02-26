<?php

namespace App\Repositories;

use App\Interfaces\TestimonialRepositoryInterface;
use App\Models\Testimonial;

class TestimonialRepository implements TestimonialRepositoryInterface
{
    public function getAllTestimonials()
    {
        return Testimonial::all();
    }

    public function getTestimonialById($id)
    {
        return Testimonial::find($id);
    }

    public function createTestimonial($data)
    {
        return Testimonial::create($data);
    }

    public function updateTestimonial($data, $id)
    {
        return Testimonial::find($id)->update($data);
    }

    public function deleteTestimonial($id)
    {
        return Testimonial::destroy($id);
    }
}
