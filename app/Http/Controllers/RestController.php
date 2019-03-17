<?php

namespace App\Http\Controllers;

use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\ResourceInterface;

abstract class RestController extends Controller
{
    protected $manager;

    protected $transformer;

    public function __construct()
    {
        $this->manager = new Manager();
    }

    protected function generateItem($model, $transformer = null)
    {
        if (!is_null($transformer)) {
            return new Item($model, new $transformer);
        }

        return new Item($model, new $this->transformer);
    }

    protected function generateCollection($model, $transformer = null)
    {
        if (!is_null($transformer)) {
            return new Collection($model, new $transformer);
        }

        return new Collection($model, new $this->transformer);
    }

    protected function sendResponse(ResourceInterface $data, $status = 200)
    {
        return response()->json(
            $this->manager->createData($data)->toArray(),
            $status
        );
    }

    protected function sendNotFoundResponse($status)
    {
        return response()->json($status, 404);
    }

    protected function sendIseResponse($status)
    {
        return response()->json($status, 500);
    }
}