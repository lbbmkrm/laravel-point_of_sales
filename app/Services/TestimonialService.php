<?php

namespace App\Services;

use App\Models\Testimonial;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class TestimonialService
{
    public function getAllTestimonials(): Collection
    {
        return Testimonial::orderBy('sort_order')->get();
    }

    public function createTestimonial(array $data): Testimonial
    {
        $testimonial = Testimonial::create($data);
        $this->clearCache();
        return $testimonial;
    }

    public function updateTestimonial(int $id, array $data): bool
    {
        $testimonial = Testimonial::findOrFail($id);
        $result = $testimonial->update($data);
        $this->clearCache();
        return $result;
    }

    public function deleteTestimonial(int $id): bool
    {
        $testimonial = Testimonial::findOrFail($id);
        $result = $testimonial->delete();
        $this->clearCache();
        return $result;
    }

    private function clearCache(): void
    {
        Cache::forget('testimonials');
    }
}
