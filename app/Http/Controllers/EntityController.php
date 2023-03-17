<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Benchmark;
use Illuminate\Support\Collection;

use App\Http\Resources\EntityResource;

use App\Models\Entity;

class EntityController
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'entities' => EntityResource::collection(
                Entity::query()->with('user')->get()
            ),
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $data = [];
        $benchmark = [];
        if ($request->isMethod('get')) {
            $data = json_decode($request->input('data', ''), true);
        }
        if ($request->isMethod('post')) {
            $data = $request->input('data', []);
        }
        /** @var \App\Models\User $user */
        $user = $request->user();
        $entity = new Entity();

        try {
            \DB::beginTransaction();

            $benchmark = Benchmark::measure([
                'load_data' => fn() => $entity->data = $data,
                'save' => fn() => $user->entities()->save($entity),
            ]);

            \DB::commit();

        } catch (\Throwable) {
            \DB::rollBack();
        }

        return response()->json([
            'id' => $entity->id,
            'benchmark' => $benchmark,
        ]);
    }

    /**
     * @param \App\Models\Entity $entity
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Entity $entity, Request $request): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            // 'json' => Entity::find($request->query('entity_id'))->data,
            'json' => $entity->data,
        ]);
    }

    /**
     * @param \App\Models\Entity $entity
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Entity $entity, Request $request): \Illuminate\Http\JsonResponse
    {
        $data = [];
        if ($request->isMethod('get')) {
            $data = json_decode($request->input('data', ''), true);
        }
        if ($request->isMethod('post')) {
            $data = $request->input('data', []);
        }
        $entity->update(['data' => $data]);

        return response()->json([
            'entity' => EntityResource::make($entity),
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOptions(Request $request): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'entity_ids' => $request->user()->entities->map(
                fn($item) => [
                    'label' => $item->id,
                    'value' => $item->id,
                ]
            ),
        ]);
    }

    public function showTree(Entity $entity)
    {
        $result = [];
        foreach ($entity->data as $item) {
            
        }
        $result = $this->loadChildren($entity->data);
        dd($result);
    }

    /**
     * @param array $data
     *
     * @return array
     */
    public function loadChildren(array $data): array
    {
        $result = [];
        // foreach ($data as $item) {
            foreach ($data as $key => $value) {
                if (is_array($value)) {
                    $result[] = [
                        'label' => $key,
                        'children' => $value,
                    ];
                    $this->loadChildren($value);
                } else {
                    $result[] = [
                        'label' => $key,
                        'children' => []
                    ];
                }
            }
        // }

        return $result;
    }
}
