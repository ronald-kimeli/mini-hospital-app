<?php

namespace App\Http\Controllers\API;

use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;


class PermissionsController extends Controller
{
    public function index()
    {
        $permissions = Permission::all();
        return response()->json([
            'success' => true,
            'message' => 'Permissions fetched successfully',
            'data' => $permissions
        ], 200);
    }

    public function store(StorePermissionRequest $request)
    {
        $validatedData = $request->validated();
        $permission = Permission::create($validatedData);
        return response()->json([
            'success' => true,
            'message' => 'Permission created successfully',
            'data' => $permission
        ], 201);
    }

    public function show($id)
    {
        try {
            $permission = Permission::findOrFail($id);
            return response()->json([
                'success' => true,
                'message' => 'Permission fetched successfully',
                'data' => $permission
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Permission not found'
            ], 404);
        }
    }

    public function update(UpdatePermissionRequest $request, $id)
    {
        try {
            $permission = Permission::findOrFail($id);
            $validatedData = $request->validated();
            $permission->update($validatedData);
            return response()->json([
                'success' => true,
                'message' => 'Permission updated successfully',
                'data' => $permission
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Permission not found'
            ], 404);
        }
    }

    public function destroy($id)
    {
        try {
            $permission = Permission::findOrFail($id);
            $permission->delete();
            return response()->json([
                'success' => true,
                'message' => 'Permission deleted successfully'
            ], 204);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the permission.'
            ], 500);
        }
    }
}
