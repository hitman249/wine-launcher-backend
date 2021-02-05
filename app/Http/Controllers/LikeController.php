<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Models\Image;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LikeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * @param Request $request
     * @param int     $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function likeConfig(Request $request, $id)
    {
        /** @var Config $config */
        $config = Config::find($id);

        $this->authorize('like-config', $config);

        $like            = new Like();
        $like->user_id   = $request->user()->id;
        $like->config_id = $config->id;

        if ($config->like()->save($like)) {
            $config->updateLikes();

            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error']);
    }

    /**
     * @param Request $request
     * @param int     $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function unlikeConfig(Request $request, $id)
    {
        /** @var Config $config */
        $config = Config::find($id);

        $this->authorize('unlike-config', $config);

        if ($config->like()->where('likes.user_id', $request->user()->id)->delete()) {
            $config->updateLikes();

            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error']);
    }

    /**
     * @param Request $request
     * @param int     $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function likeImage(Request $request, $id)
    {
        /** @var Image $image */
        $image = Image::find($id);

        $this->authorize('like-image', $image);

        $like           = new Like();
        $like->user_id  = $request->user()->id;
        $like->image_id = $image->id;

        if ($image->like()->save($like)) {
            $image->updateLikes();

            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error']);
    }

    /**
     * @param Request $request
     * @param int     $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function unlikeImage(Request $request, $id)
    {
        /** @var Image $image */
        $image = Image::find($id);

        $this->authorize('unlike-image', $image);

        if ($image->like()->where('likes.user_id', $request->user()->id)->delete()) {
            $image->updateLikes();

            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error']);
    }
}
