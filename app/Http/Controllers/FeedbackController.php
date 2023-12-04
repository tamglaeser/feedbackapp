<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Services\FileProcessingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use function Sentry\captureException;
use function Sentry\captureMessage;

class FeedbackController extends Controller
{
    protected $fileService;

    public function __construct(FileProcessingService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $data = Feedback::create($request->all());
            return response()->json(['status' => true, 'data' => $data], 201);
        } catch (\Exception $e) {
            captureException($e);
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    public function index(): JsonResponse
    {
        $data = Feedback::all();
        return response()->json(['status' => true, 'data' => $data], 201);
    }

    public function uploadFromFile(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            if ($file->extension() === 'csv') {
                $this->fileService->processCSVContent(file_get_contents($file->getRealPath()));
            } elseif ($file->extension() === 'json') {
                $this->fileService->processJSONContent(file_get_contents($file->getRealPath()));
            }
            return response()->json(['message' => 'Feedbacks uploaded from file'], 200);
        } else {
            captureMessage('No file uploaded');
            return response()->json(['error' => 'No file uploaded'], 400);
        }
    }
}
