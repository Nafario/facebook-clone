<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserImage as UserImageResource;
use App\Models\User;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;

class UserImageController extends Controller
{
    public function store(User $user)
    {
        $data = request()->validate([
            'image' => [''],
            'width' => [''],
            'height' => [''],
            'location' => [''],
        ]);
        $image = $data['image']->store('user-images', 'public');
        Image::make($data['image'])
            ->fit($data['width'], $data['height'])
            ->save(
                storage_path(
                    'app/public/user-images/' . $data['image']->hashName()
                )
            );
        $userImage = auth()
            ->user()
            ->images()
            ->create([
                'path' => 'storage/' . $image,
                'width' => $data['width'],
                'height' => $data['height'],
                'location' => $data['location'],
            ]);
        return new UserImageResource($userImage);
    }
}
