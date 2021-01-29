<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Models\Image;
use App\Models\User;
use Arr;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ConfigController extends Controller
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
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     * @throws ValidationException
     * @throws \Throwable
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'config'     => 'required|game_config',
            'icon'       => 'sometimes|mimes:png',
            'background' => 'sometimes|mimes:jpeg,png',
        ]);

        /** @var User $user */
        $user = $request->user();
        $json = json_decode($request->input('config'), true);

        $config          = new Config();
        $config->user_id = $user->id;
        $config->name    = Arr::get($json, 'app.name');
        $config->version = Arr::get($json, 'app.version');
        $config->config  = $json;

        if ($request->hasFile('icon')) {
            $file = $request->file('icon');

            try {
                $image           = (new Image)->createFileByPath($file->getRealPath());
                $config->icon_id = $image->id;
            } catch (\Exception $exception) {
            }
        }

        if ($request->hasFile('background')) {
            $file = $request->file('background');

            try {
                $image                 = (new Image)->createFileByPath($file->getRealPath());
                $config->background_id = $image->id;
            } catch (\Exception $exception) {
            }
        }

        $config->saveOrFail();

        return response()->json(['status' => true]);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     * @throws ValidationException
     * @throws \Throwable
     */
    public function select(Request $request)
    {
        $this->validate($request, [
            'q' => 'required',
        ]);

        $search = implode('%', array_filter(explode(' ', $request->q)));

        return response()->json([
            'status' => true,
            'data'   => Config::query()
                ->where('name', 'like', "%{$search}%")
                ->limit(500)
                ->get()
        ]);
    }
}
