<?php

namespace App\Repositories;

use App\Interfaces\BannerRepositoryInterface;
use App\Models\Banner;

class BannerRepository implements BannerRepositoryInterface
{
    public function getAllBanners()
    {
        return Banner::all();
    }

    public function getBannerById($id)
    {
        return Banner::find($id);
    }

    public function createBanner($data)
    {
        $banner = new Banner($data);
        $banner->image = $data['image']->store('assets/banners', 'public');
        $banner->save();

        return $banner;
    }

    public function updateBanner($data, $id)
    {
        $banner = Banner::find($id);
        $banner->image = $data['image']->store('assets/banners', 'public');
        $banner->save();

        return $banner;
    }

    public function deleteBanner($id)
    {
        return Banner::destroy($id);
    }
}
