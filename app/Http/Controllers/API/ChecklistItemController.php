<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Checklist;
use App\Models\ChecklistItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ChecklistItemController extends Controller
{
    public function index($checklistId)
    {
        $userId = Auth::id();
        
        $checklist = Checklist::where('id', $checklistId)
                              ->where('created_by', $userId)
                              ->first();

        if (!$checklist) {
            return response()->json([
                'success' => false,
                'message' => 'Checklist not found or you do not have permission to access it',
            ], 404);
        }

        $items = ChecklistItem::where('checklist_id', $checklistId)->get();

        return response()->json([
            'success' => true,
            'items' => $items,
        ], 200);
    }

    public function store($checklistId, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'itemName' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $userId = Auth::id();

        $checklist = Checklist::where('id', $checklistId)
                              ->where('created_by', $userId)
                              ->first();

        if (!$checklist) {
            return response()->json([
                'success' => false,
                'message' => 'Checklist not found or you do not have permission to add items to it',
            ], 404);
        }

        $item = ChecklistItem::create([
            'item_name' => $request->input('itemName'),
            'checklist_id' => $checklistId,
            'created_by' => $userId,
            'is_done' => false,
        ]);

        return response()->json([
            'success' => true,
            'item' => $item,
        ], 201);
    }


    public function show($checklistId, $checklistItemId)
    {
        $userId = Auth::id();

        $checklist = Checklist::where('id', $checklistId)
                              ->where('created_by', $userId)
                              ->first();


        if (!$checklist) {
            return response()->json([
                'success' => false,
                'message' => 'Checklist not found or you do not have permission to access it',
            ], 404);
        }

        $item = ChecklistItem::where('checklist_id', $checklistId)
                              ->where('id', $checklistItemId)
                              ->first();

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Checklist item not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'item' => $item,
        ], 200);
    }

    public function update($checklistId, $checklistItemId)
    {

        $userId = Auth::id();

        $checklist = Checklist::where('id', $checklistId)
                              ->where('created_by', $userId)
                              ->first();


        if (!$checklist) {
            return response()->json([
                'success' => false,
                'message' => 'Checklist not found or you do not have permission to update items in it',
            ], 404);
        }

        $item = ChecklistItem::where('checklist_id', $checklistId)
                              ->where('id', $checklistItemId)
                              ->first();

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Checklist item not found',
            ], 404);
        }

        $item->is_done = !$item->is_done;
        $item->save();

        return response()->json([
            'success' => true,
            'item' => $item,
        ], 200);
    }


    public function destroy($checklistId, $checklistItemId)
    {
        $userId = Auth::id();

        $checklist = Checklist::where('id', $checklistId)
                              ->where('created_by', $userId)
                              ->first();

        if (!$checklist) {
            return response()->json([
                'success' => false,
                'message' => 'Checklist not found or you do not have permission to delete items from it',
            ], 404);
        }

        $item = ChecklistItem::where('checklist_id', $checklistId)
                              ->where('id', $checklistItemId)
                              ->first();

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Checklist item not found',
            ], 404);
        }

        $item->delete();

        return response()->json([
            'success' => true,
            'message' => 'Checklist item deleted successfully',
        ], 200);
    }


    public function rename($checklistId, $checklistItemId, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'itemName' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $userId = Auth::id();

        $checklist = Checklist::where('id', $checklistId)
                              ->where('created_by', $userId)
                              ->first();

        if (!$checklist) {
            return response()->json([
                'success' => false,
                'message' => 'Checklist not found or you do not have permission to update items in it',
            ], 404);
        }

        $item = ChecklistItem::where('checklist_id', $checklistId)
                              ->where('id', $checklistItemId)
                              ->first();

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Checklist item not found',
            ], 404);
        }

        $item->item_name = $request->input('itemName');
        $item->save();

        return response()->json([
            'success' => true,
            'item' => $item,
        ], 200);
    }


}
