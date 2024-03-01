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

    public function create($data)
    {
        $testimonial = new Testimonial;
        $testimonial->name = $data['name'];
        $testimonial->avatar = $data['avatar']->store('assets/testimonials', 'public');
        $testimonial->testimonial = $data['testimonial'];
        $testimonial->save();

        return $testimonial;
    }

    public function update($data, $id)
    {
        $testimonial = Testimonial::find($id);
        $testimonial->name = $data['name'];
        $testimonial->avatar = $data['avatar']->store('assets/testimonials', 'public');
        $testimonial->testimonial = $data['testimonial'];
        $testimonial->save();

        return $testimonial;
    }

    public function delete($id)
    {
        return Testimonial::destroy($id);
    }
}
