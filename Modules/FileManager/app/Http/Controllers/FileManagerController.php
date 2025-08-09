<?php

namespace Modules\FileManager\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponseFormatTrait;
use Illuminate\Support\Facades\Storage;
use Modules\FileManager\Http\Requests\FileRequest;

class FileManagerController extends Controller
{
    use ApiResponseFormatTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        return response()->json([]);
    }

    /**
     * Upload files to the server.
     */
    public function upload(FileRequest $request)
    {
        $request->validated(); // Validate the request using the FileRequest rules

        // Handle file upload
        $file = $request->file('file');
        $fileName = 'items.'.$file->getClientOriginalExtension(); 
        //$path = Storage::disk('public')->putFile('uploads', $file); // Store in 'storage/app/public/uploads'
        $filePath = $file->storeAs('uploads', $fileName, 'public'); // 'public' is the disk name

        // Optionally, save file path or other details to a database
        // e.g., File::create(['name' => $file->getClientOriginalName(), 'path' => $path]);

        return response()->json(['message' => 'File uploaded successfully', 'path' => $filePath]);
            
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        //

        return response()->json([]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //

        return response()->json([]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //

        return response()->json([]);
    }
}
