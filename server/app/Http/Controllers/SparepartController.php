<?php

namespace App\Http\Controllers;

use App\Models\Sparepart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SparepartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $spareparts = Sparepart::with('category')
            ->latest();

        if ($limit = $request->input('limit')){
            $spareparts->limit($limit);
        }
        
        $paginate = $request->input('paginate');
        $data = $paginate ? $spareparts->paginate(5) : $spareparts->get();
        
        return response()->json([
            'message' => 'success get all spareparts',
            'spareparts' => $data, 
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required',
            'stok' => 'required',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|file'
        ]);

        if ($validator->fails())
        {
            return response()->json([
                'message' => 'Invalid fields',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();
        $path = $request->file('image')->store('public/spareparts');
        $data['image'] = env('APP_URL') . Storage::url($path) ;

        $sparepart = Sparepart::create($data);

        return response()->json([
            'message' => 'Success store new spareparts',
            'sparepart' => $sparepart
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Sparepart $sparepart)
    {
        return response()->json([
            'message' => 'Success get spareparts',
            'sparepart' => $sparepart->load('category')
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sparepart $sparepart)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required',
            'stok' => 'required',
            'category_id' => 'required|exists:categories,id',
            'image' => 'file'
        ]);

        if ($validator->fails())
        {
            return response()->json([
                'message' => 'Invalid fields',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();
        if ($request->file('image')){
            // delete old image
            Storage::delete($sparepart->image);

            $path = $request->file('image')->store('public/spareparts');
            $data['image'] = env('APP_URL') . Storage::url($path) ;
        }

        $sparepart->update($data);

        return response()->json([
            'message' => 'Success store new spareparts',
            'sparepart' => $sparepart
        ], 200);       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sparepart $sparepart)
    {
        $sparepart->delete();
        
        return response()->json([
            'message' => 'Success delete spareparts'
        ], 200);
    }
}
