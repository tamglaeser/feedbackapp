<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        try {
            $data = Feedback::create($request->all());
            return response()->json(['status' => true, 'data' => $data], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    public function index(): JsonResponse
    {
        $data = Feedback::all();
        return response()->json(['status' => true, 'data' => $data], 201);
    }
}
