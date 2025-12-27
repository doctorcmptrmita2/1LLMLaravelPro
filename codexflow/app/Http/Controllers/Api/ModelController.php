<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AiModel;
use Illuminate\Http\Request;

class ModelController extends Controller
{
    public function index(Request $request)
    {
        $models = AiModel::where('availability', true)
            ->orderBy('name')
            ->get();
        
        return response()->json($models);
    }

    public function favorite(Request $request)
    {
        $request->validate([
            'model_id' => 'required|exists:models,id',
        ]);

        // TODO: Implement favorite model logic (user_model_favorites table)
        
        return response()->json([
            'message' => 'Model favorited successfully',
        ]);
    }
}
