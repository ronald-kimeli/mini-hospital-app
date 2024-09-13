<?php

namespace App\Http\Controllers\API;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;


class RolesController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return response()->json([
            'success' => true,
            'message' => 'Roles fetched successfully',
            'data' => $roles
        ], 200);
    }

    public function store(StoreRoleRequest $request)
    {
        $validatedData = $request->validated();
        $role = Role::create($validatedData);
        return response()->json([
            'success' => true,
            'message' => 'Role created successfully',
            'data' => $role
        ], 201);
    }

    public function show($id)
    {
        try {
            $role = Role::findOrFail($id);
            return response()->json([
                'success' => true,
                'message' => 'Role fetched successfully',
                'data' => $role
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Role not found'
            ], 404);
        }
    }

    public function update(UpdateRoleRequest $request, $id)
    {
        try {
            $role = Role::findOrFail($id);
            $validatedData = $request->validated();
            $role->update($validatedData);
            return response()->json([
                'success' => true,
                'message' => 'Role updated successfully',
                'data' => $role
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Role not found'
            ], 404);
        }
    }

    public function destroy($id)
    {
        try {
            $role = Role::findOrFail($id);
            $role->delete();
            return response()->json([
                'success' => true,
                'message' => 'Role deleted successfully'
            ], 204);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the role.'
            ], 500);
        }
    }
}
