<?php

namespace App\Http\Controllers;

use App\Exceptions\FriendRequestNotFoundException;
use App\Exceptions\ValidationErrorException;
use App\Http\Resources\Friend as ResourcesFriend;
use App\Models\Friend;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class FriendRequestResponseController extends Controller
{
    public function store()
    {
        try {
            $data = request()->validate([
                'user_id' => ['required'],
                'status' => ['required'],
            ]);
        } catch (ValidationException $th) {
            throw new ValidationErrorException(json_encode($th->errors()));
        }
        try {
            $friendRequest = Friend::where('user_id', $data['user_id'])
                ->where('friend_id', auth()->user()->id)
                ->firstOrFail();
        } catch (ModelNotFoundException $th) {
            throw new FriendRequestNotFoundException();
        }
        $friendRequest->update(
            array_merge($data, [
                'confirmed_at' => now(),
            ])
        );
        return new ResourcesFriend($friendRequest);
    }
    public function destroy()
    {
        try {
            $data = request()->validate([
                'user_id' => ['required'],
            ]);
        } catch (ValidationException $th) {
            throw new ValidationErrorException(json_encode($th->errors()));
        }

        try {
            Friend::where('user_id', $data['user_id'])
                ->where('friend_id', auth()->user()->id)
                ->firstOrFail()
                ->delete();
        } catch (ModelNotFoundException $th) {
            throw new FriendRequestNotFoundException();
        }
        return response()->json([], 204);
    }
}
