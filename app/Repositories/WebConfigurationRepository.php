<?php

namespace App\Repositories;

use App\Interfaces\WebConfigurationRepositoryInterface;
use App\Models\WebConfiguration;

class WebConfigurationRepository implements WebConfigurationRepositoryInterface
{
    public function getWebConfiguration()
    {
        return WebConfiguration::first();
    }

    public function updateWebConfiguration(array $data)
    {
        $webConfiguration = WebConfiguration::first();
        $webConfiguration->title = $data['title'];
        $webConfiguration->description = $data['description'];
        $webConfiguration->email = $data['email'];
        $webConfiguration->phone = $data['phone'];
        $webConfiguration->logo = $data['logo']->store('assets/web-configurations', 'public');
        $webConfiguration->map = $data['map'];
        $webConfiguration->address = $data['address'];
        $webConfiguration->facebook = $data['facebook'];
        $webConfiguration->instagram = $data['instagram'];
        $webConfiguration->youtube = $data['youtube'];
        $webConfiguration->save();

        return $webConfiguration;
    }
}
