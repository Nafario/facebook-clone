<?php

namespace App\Http\Resources;
use App\Http\Resources\Friend as ResourceFriend;
use App\Http\Resources\UserImage as ResourceUserImage;
use App\Models\Friend;
use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => [
                'type' => 'users',
                'user_id' => $this->id,
                'attributes' => [
                    'name' => $this->name,
                    'friendship' => new ResourceFriend(
                        Friend::friendship($this->id)
                    ),
                    'cover_image' => new ResourceUserImage($this->coverImage),
                    'profile_image' => new ResourceUserImage($this->profileImage),
                ],
            ],
            'links' => [
                'self' => url('/users/' . $this->id),
            ],
        ];
    }
}
