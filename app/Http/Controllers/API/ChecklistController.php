<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Checklist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChecklistController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $checklists = Checklist::where('created_by', $user->id)->get();

        return response()->json([
            'success' => true,
            'checklists' => $checklists,
        ], 200);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = auth()->user();

        $checklist = Checklist::create([
            'name' => $request->input('name'),
            'created_by' => $user->id,
        ]);

        return response()->json([
            'success' => true,
            'checklist' => $checklist,
        ], 201);
    }


    public function destroy($checklistId)
    {
        $user = auth()->user();
        $checklist = Checklist::where('id', $checklistId)->where('created_by', $user->id)->first();

        if (!$checklist) {
            return response()->json([
                'success' => false,
                'message' => 'Checklist not found or you do not have permission to delete it',
            ], 404);
        }

        $checklist->delete();

        return response()->json([
            'success' => true,
            'message' => 'Checklist deleted successfully',
        ], 200);
    }

}
