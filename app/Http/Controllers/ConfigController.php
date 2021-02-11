<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Models\Image;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
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
                /** @var \Intervention\Image\Image $image */
                $image = app('image')->make($file->getRealPath());
                $image->resize(256, 256, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $path = sys_get_temp_dir() . '/icon.png';

                if (file_exists($path)) {
                    @unlink($path);
                }

                $image->save($path);
                $image->destroy();

                $image           = (new Image)->createFileByPath($path);
                $config->icon_id = $image->id;
            } catch (\Exception $exception) {
            }
        }

        if ($request->hasFile('background')) {
            $file = $request->file('background');

            try {
                /** @var \Intervention\Image\Image $image */
                $image = app('image')->make($file->getRealPath());
                $image->resize(1280, null, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $path = sys_get_temp_dir() . '/background.jpg';

                if (file_exists($path)) {
                    @unlink($path);
                }

                $image->save($path);
                $image->destroy();

                $image                 = (new Image)->createFileByPath($path);
                $config->background_id = $image->id;
            } catch (\Exception $exception) {
            }
        }

        $config->saveOrFail();

        return response()->json(['status' => 'success', 'data' => $config]);
    }

    /**
     * @param Request $request
     * @param int     $id
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     * @throws \Throwable
     */
    public function update(Request $request, $id)
    {
        /** @var Config $config */
        $config = Config::find($id);

        if (!$config && $id) {
            return $this->create($request);
        }

        $this->authorize('config-update', $config);

        $config->delete();

        return $this->create($request);
    }

    /**
     * @param Request $request
     * @param int     $id
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     * @throws \Throwable
     */
    public function delete(Request $request, $id)
    {
        /** @var Config $config */
        $config = Config::find($id);

        $this->authorize('config-delete', $config);

        if (!$config) {
            return response()->json(['status' => 'error']);
        }

        if ($config->delete()) {
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error']);
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
            'q'       => 'sometimes',
            'page'    => 'sometimes|integer',
            'user_id' => 'sometimes|integer',
        ]);

        $userId = (int)$request->user_id;
        $with   = [
            'icon',
            'background',
            'user',
        ];

        $with['like'] = function ($query) use ($request) {
            /** @var \Illuminate\Database\Eloquent\Relations\HasMany $query */
            $query->where('user_id', $request->user()->id);
        };

        $search = $request->q ? implode('%', prepare_name($request->q)) : '';
        $query  = Config::query()->with($with);

        if ($search) {
            $query
                ->orderByDesc('likes')
                ->where('name', 'like', "%{$search}%");
        } else {
            $query->orderByDesc('id');
        }

        if ($userId) {
            $query->where('user_id', $userId);
        }

        $items = $query->paginate($page_size = 4);

        foreach ($items->items() as $item) {
            if ($item->icon) {
                $item->icon_url = $item->icon->getBase64();
            }

            if ($item->background) {
                $item->background_url = $item->background->getBase64();
            }
        }

        $data              = $items->toArray();
        $data['page_size'] = $page_size;

        return response()->json([
            'status' => 'success',
            'data'   => $data,
        ]);
    }
}
