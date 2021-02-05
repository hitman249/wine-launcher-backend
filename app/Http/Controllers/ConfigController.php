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
            'q' => 'required',
        ]);

        $search = implode('%', prepare_name($request->q));

        $items = Config::query()
            ->with(['icon', 'background'])
            ->where('name', 'like', "%{$search}%")
            ->limit(100)
            ->get()
            ->map(static function (Config $item) {
                if ($item->icon) {
                    $item->icon_url = $item->icon->getBase64();
                }

                if ($item->background) {
                    $item->background_url = $item->background->getBase64();
                }

                return $item;
            });

        return response()->json([
            'status' => 'success',
            'data'   => $items->toArray(),
        ]);
    }
}
