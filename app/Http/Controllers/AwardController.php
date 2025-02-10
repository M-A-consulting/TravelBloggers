<?php

namespace App\Http\Controllers;

use AElnemr\RestFullResponse\CoreJsonResponse;
use App\Models\Award;
use App\Http\Requests\StoreAwardRequest;
use App\Http\Requests\UpdateAwardRequest;
use App\Http\Resources\AwardResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AwardController extends Controller
{
    use CoreJsonResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $awards = Award::all();
        return $this->ok(AwardResource::collection($awards)->resolve());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAwardRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'image' => ['required', 'file'],
            'content' => ['required', 'string'],
        ]);

        // if ($validator->fails()) {
        //     return response()->json(['errors' => $validator->errors()], 422);
        // }

        $award = Award::create($request->only(['title', 'image', 'content']));

        return response()->json(['message' => 'Award created successfully', 'award' => $award], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $award = Award::find($id);

        if (!$award) {
            return response()->json(['message' => 'Award not found'], 404);
        }

        return response()->json($award);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Award $award)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $award = Award::find($id);

        if (!$award) {
            return response()->json(['message' => 'Award not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => ['sometimes', 'string', 'max:255'],
            'image' => ['nullable', 'string'],
            'content' => ['sometimes', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $award->update($request->only(['title', 'image', 'content']));

        return response()->json(['message' => 'Award updated successfully', 'award' => $award]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $award = Award::find($id);

        if (!$award) {
            return response()->json(['message' => 'Award not found'], 404);
        }

        $award->delete();

        return response()->json(['message' => 'Award deleted successfully']);
    }
}
