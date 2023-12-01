<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $this->validate($request, [
            'review' => 'required|string',
            'rating' => 'required|integer|min:1|max:10',
            'start_date' => 'required|string',
            'address' => 'required|string',
            'appartments' => 'required|string',
            'source' => 'required|string'
        ]);
        $data = Feedback::create($request->all());
        return response()->json(['status' => true, 'data' => $data], 201);
    }

    public function index(): JsonResponse
    {
        $data = Feedback::all();
        return response()->json(['status' => true, 'data' => $data], 201);
    }
}
