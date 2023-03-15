<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Benchmark;

use App\Models\Entity;

class EntityController
{
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
            $data = json_decode($request->input('data'), true);
        }
        if ($request->isMethod('post')) {
            $data = $request->input('data');
        }
        $entity = new Entity();

        try {
            \DB::beginTransaction();

            $benchmark = Benchmark::measure([
                'load_data' => fn() => $entity->data = $data,
                'save' => fn() => $entity->save(),
            ]);

            \DB::commit();

        } catch (\Throwable) {
            \DB::rollBack();
        }

        return response()->json([
            'benchmark' => $benchmark,
        ]);
    }
}
