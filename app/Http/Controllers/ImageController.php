<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ImageController extends Controller
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
     */
    public function get(Request $request, $id)
    {
        /** @var Image $image */
        $image = Image::query()->where('id', $id)->first();

        if (!$image) {
            abort(404);
        }

        return response()->make($image->getRaw(), 200, [
            'Content-Type'   => $image->mime,
            'Content-Length' => $image->size,
        ]);
    }
}
