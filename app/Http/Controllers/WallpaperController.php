<?php

namespace App\Http\Controllers;

use App\Models\wallpaper;
use Illuminate\Http\Request;

class WallpaperController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wallpaper = wallpaper::select('id', 'name', 'image','price')->get();

        return response()->json([
            'status' => true,
            'data'=>$wallpaper
        ],200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|string|max:255',
            'price'=>'required|integer',
            'image'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:15360',
        ]);

        $data=$request->only(['name','price']);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = 'wallpapers/' . $fileName;

            $file->move(public_path('wallpapers'), $fileName);

            $data['image'] = asset($filePath);
        }

      $wallpaper = wallpaper::create($data);

        return response()->json([
            'message'=>'You have successfully upload file.',
            'status'=>true,
            'id'=>$wallpaper->id,
            'name'=>$wallpaper->name,
            'price'=>$wallpaper->price,
            'image'=>asset($wallpaper->image),
        ],200);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'=>'required|string|max:255',
            'price'=>'required|integer',
            'image'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:15360',
        ]);

        $wallpaper = wallpaper::find($id);

        $data=$request->only(['name','price']);

        if ($request->hasFile('image')) {
            if ($wallpaper && $wallpaper->image) {
                $oldPath = public_path('wallpapers/' . basename($wallpaper->image));
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = 'wallpapers/' . $fileName;

            $file->move(public_path('wallpapers'), $fileName);

            $data['image'] = asset($filePath);
        }

        $wallpaper->update($data);

        return response()->json([
            'success'=>'You have successfully update file.',
            'status'=>true,
            'id'=>$wallpaper->id,
            'name'=>$wallpaper->name,
            'price'=>$wallpaper->price,
            'image'=>asset($wallpaper->image),
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
