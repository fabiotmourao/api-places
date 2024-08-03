<?php

namespace App\Http\Controllers;

use App\Models\Place;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Validators\PlaceValidation;

class PlaceController extends Controller
{
    public function index()
    {
        $places = Place::all();

        if ($places->count() > 0) {
            return response()->json([
                'status' => 200,
                'places' => $places,
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Places not found',
            ], 404);
        }
    }

    public function show($id)
    {
        $place = Place::find($id);

        if ($place) {
            return response()->json($place);
        } else {
            return response()->json(['message' => 'Place not found'], 404);
        }
    }

    public function search(Request $request)
    {
        $query = Place::query();

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        $places = $query->get();

        return response()->json($places);
    }

    public function store(Request $request)
    {
        $validator = PlaceValidation::validate($request->all());

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validated = $validator->validated();
        $slug = $this->generateUniqueSlug($validated['name'], $validated['slug']);

        try {
            Place::create([
                'name' => $validated['name'],
                'city' => $validated['city'],
                'slug' => $slug,
            ]);

            return response()->json(['message' => 'Place created successfully'], 201);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error creating data: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $place = Place::find($id);

        if (!$place) {
            return response()->json(['error' => 'Place not found'], 404);
        }

        $validator = PlaceValidation::validate($request->all(), $id);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validated = $validator->validated();

        try {
            $place->update([
                'name' => $validated['name'],
                'city' => $validated['city'],
                'slug' => $validated['slug'],
            ]);

            return response()->json(['message' => 'Place updated successfully'], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error updating data: ' . $e->getMessage()], 500);
        }
    }

    public function delete($id)
    {
        try {
            $place = Place::find($id);

            if (!$place) {
                return response()->json(['error' => 'Place not found'], 404);
            }

            $place->delete();

            return response()->json(['message' => 'successfully deleted', 'data' => $place], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Error during deletion: ' . $e->getMessage()], 500);
        }

    }

    private function generateUniqueSlug($name, $slug = null)
    {
        if ($slug === null) {
            $slug = Str::slug($name);
        }

        $originalSlug = $slug;
        $count = 1;

        while (Place::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        return $slug;
    }
}
