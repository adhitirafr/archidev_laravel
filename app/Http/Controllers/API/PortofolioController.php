<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PortofolioRequest;
use App\Models\Portofolio;
use App\Http\Resources\PortofolioResource;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Image, DB, Log;

class PortofolioController extends Controller
{
    public function index(Request $request)
    {
        $portofolios = Portofolio::orderByDesc('created_at');
    
        if($request->search) {
            $portofolios = $portofolios->where('title', '%LIKE%', $request->search);
        }

        if($request->home) {
            $portofolios = $portofolios->limit(3)->get();

            return PortofolioResource::collection($portofolios);
        }

        if($request->count) {
            return response()->json([
                'total' => $portofolios->count()
            ]);
        }

        return PortofolioResource::collection($portofolios->simplePaginate(12));
    }

    public function show(Request $request)
    {
        $portofolio = Portofolio::where('slug', $request->portofolio)->firstOrFail();

        return new PortofolioResource($portofolio);
    }
    
    public function store(PortofolioRequest $request)
    {
        DB::beginTransaction();

        if (! File::exists(public_path() . '/image_upload')) {
            File::makeDirectory(public_path() . '/image_upload');
        }

        try {
            $image = $request->file('picture');
            $extenImage = $request->picture->getClientOriginalExtension();
            $nameImage = time().'.'.$extenImage;
    
            $thumbImage = Image::make($image->getRealPath())->resize(1200, 760)->encode($extenImage);
            $thumbPath = public_path() . '/image_upload/' . $nameImage;
            $thumbImage->save($thumbPath);

            $create = Portofolio::create([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'image' => $nameImage,
                'category_id' => $request->category_id,
                'year' => $request->year,
                'youtube' => $request->youtube,
                'description' => $request->description,
                'short_description' => $request->short_description,
                'theme' => $request->theme,
                'softwares' => $request->softwares,
                
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Portofolio is created'
            ], 200);
        }
        catch(\Exception $e) {
            Log::info($e);
            DB::rollback();
            return response()->json([
                'message' => 'Portofolio is failed to create',
                'machine' => $e
            ], 500);
        }
    }

    public function update(Request $request)
    {
        DB::beginTransaction();

        try {
            $portofolio = Portofolio::findOrFail($request->portofolio);

            if($request->hasFile('picture')) {
                //-- unlink the previous image
                unlink(public_path().'/image_upload/'.$portofolio->image);
    
                $image = $request->file('picture');
                $extenImage = $request->picture->getClientOriginalExtension();
                $nameImage = time().'.'.$extenImage;
        
                $thumbImage = Image::make($image->getRealPath())->resize(1200, 760)->encode($extenImage);
                $thumbPath = public_path() . '/image_upload/' . $nameImage;
                $thumbImage->save($thumbPath);
            }

            $portofolio->update([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'image' => $request->hasFile('picture') ? $nameImage : $portofolio->image,
                'category_id' => $request->category_id,
                'year' => $request->year,
                'youtube' => $request->youtube,
                'description' => $request->description,
                'short_description' => $request->short_description,
                'theme' => $request->theme,
                'softwares' => $request->softwares,
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Portofolio is updated'
            ], 200);
        }
        catch(\Exception $e) {
            Log::info($e);
            DB::rollback();
            return response()->json([
                'message' => 'Portofolio is failed to updated',
                'machine' => $e
            ], 500);
        }
    }

    public function destroy(Request $request)
    {
        $portofolio = Portofolio::findOrFail($request->portofolio);

        unlink(public_path('image_upload').'/'.$portofolio->image);

        $portofolio->delete();

        return response()->json([
            'message' => 'Portofolio is deleted'
        ], 200);
    }
}
