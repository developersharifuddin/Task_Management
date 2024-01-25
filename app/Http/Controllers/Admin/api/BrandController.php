<?php

namespace App\Http\Controllers\Admin\api;

use Log;
use Carbon\Carbon;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\BrandCollection;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use Illuminate\Pagination\LengthAwarePaginator;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            DB::beginTransaction();

            $perPage = $request->input('per_page', 10); // Default to 10 records per page, adjust as needed
            $search = $request->input('search');
            $status = $request->input('status'); // 'active', 'inactive', or null
            // $brands =  Brand::select('name_english', 'name_bangla')->whereIn('status', [0, 1])->latest('id')->paginate(10);
            $query = Brand::query()->select('id', 'name_english', 'name_bangla', 'description', 'status')->whereIn('status', [0, 1])->latest('id');
            // Apply status filter
            if ($status) {
                $query->where('status' === $status);
            }
            // Apply search filter
            if ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name_english', 'like', '%' . $search . '%')
                        ->orWhere('name_bangla', 'like', '%' . $search . '%');
                    // Add other fields as needed for searching
                });
            }

            // $brands = [];
            // $query->chunk(500, function ($brandChunk) use (&$brands) {
            //     $brandsChunk = $brandChunk->map(function ($brand) {
            //         return [
            //             'id' => $brand->id,
            //             'name_english' => $brand->name_english,
            //             'name_bangla' => $brand->name_bangla,
            //             'status' => $brand->status,
            //             'description' => $brand->description,
            //         ];
            //     });
            //     $brands[] = $brandsChunk->toArray();
            // });
            // $flatBrands = collect($brands)->flatten(1);
            // $currentPage = $request->input('page', 1);
            // $pagedData = $flatBrands->slice(($currentPage - 1) * $perPage, $perPage)->all();
            // $brands = new LengthAwarePaginator($pagedData, count($flatBrands), $perPage, $currentPage);

            $brands = $query->paginate($perPage);
            return new BrandCollection($brands);

            // $brandContent = [];
            // Brand::select('id','slug','name','name_bangla','image')->chunk(500,function($brands) use(& $brandContent){
            //     foreach($brands as $brand){
            //         $brandContent[] = [
            //             'id' => $brand->id,
            //             'slug' => $brand->slug,
            //             'name' => $brand->name,
            //             'name_bangla' => $brand->name_bangla,
            //             'image' => $brand->image,
            //         ];
            //     }
            // });

            // $brandContent = json_encode($brandContent);
            // Storage::disk('public')->put('brand.json', $brandContent);
            //}


            // Retrieve and return data in chunks
            // $data = [];
            // Brand::chunk(4, function ($brands) use (&$data) {
            //     foreach ($brands as $brand) {
            //         $data[] = $brand;
            //     }
            // });

            // return response()->json($data);
            //  better way to data retrive/ showing
            //$brands = Brand::orderBy('id')->chunk(1000, function ($brands) {
            //     foreach ($brands as $brand) {
            //         // Process each product
            //     }
            //     return false;
            // });

            // better for data edit
            //  use all data showing and operations- not better way
            // $collection = Brand::get();
            // $brands= $collection->each(function ($item, $key) {
            //             if (/* some condition */) {
            //                 return false;
            //             }
            //         });


            // better for data edit
            // $brands= $collection->map(function ($item, $key) {
            //             return $item;
            //         })->all(); 



            //   Brand::when($role, function ($query) use ($role) {
            //             return $query->where('role_id', $role);
            //         })->get();


            // $brands = Brand::with('products')->get();

            // $brands = cache()->remember('brands', now()->addHours(2), function () {
            //     return Brand::all();
            // });

            // return response()->json(['brands' => $brands, 'message' => 'Data processing completed'], 200);

            // return view('admin.brand.index', [
            //     'brands' => Brand::latest()->paginate(10),
            // ]);

            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'error' => 'An error occurred.',
                'message' => $error->getMessage(),
            ], 500);
            // Handle the exception, log it, and return an appropriate error response
        }
    }










    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brand.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBrandRequest $request)
    {

        try {
            Brand::create($request->all());

            return response()->json(['success' => 'data is successfully added'], 200);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }


        $brands =  Brand::chunk(1000, function ($brands) {
            // Process each chunk of data (each chunk contains 1000 records)
            foreach ($brands as $brand) {
                // Your processing logic here
                $brand->update([
                    'processed' => true,
                    'processed_at' => now(),
                ]);
                // Example: Log the brand name
                Log::info('Processing brand: ' . $brand->name);
            }
        });





        $logo = $request->file('logo');
        $slug = $request->sub_title;

        if ($request->hasfile('logo')) {
            $currentDate = Carbon::now()->toDateString();
            $logo_name = $slug . '-' . $currentDate . '-' . '.' . $logo->getClientOriginalExtension();
            if (!file_exists('frontend/image/Brand/')) {
                mkdir('frontend/image/Brand/', 077, true);
            }
            $logo->move('frontend/image/Brand/', $logo_name);
        } else {
            $logo_name = 'default.png';
        }

        $before_image = $request->file('before_image');

        if ($request->hasfile('before_image')) {
            $currentDate = Carbon::now()->toDateString();
            $before_image_name = $slug . '--' . $currentDate . '-' . '.' . $before_image->getClientOriginalExtension();
            if (!file_exists('frontend/image/Brand/')) {
                mkdir('frontend/image/Brand/', 077, true);
            }
            $before_image->move('frontend/image/Brand/', $before_image_name);
        } else {
            $before_image_name = 'default.png';
        }

        $Brand = new Brand();
        $Brand->sub_title = $request->sub_title;
        $Brand->title = $request->title;
        $Brand->description = $request->description;
        $Brand->description2 = $request->description2;
        $Brand->logo = $logo_name;
        $Brand->before_image = $before_image_name;
        $Brand->save();
        Session::flash('message', 'Successfully created Brand!');
        return redirect()->route('admin.Brand.index')->with('Successfully created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        $brand = Brand::find($brand);
        if (!$brand) {
            return response()->json(['message' => 'Brand not found'], 404);
        }
        return response()->json($brand);


        // return view('admin.brand.brand_edit', [
        //     'Brand' => Brand::find($Brand->id),
        // ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        //  dd(Brand::find($id));
        return view('admin.brand.index', [
            'Brand' => Brand::find($brand),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBrandRequest $request, Brand $brand, $id)
    {
        // dd($Brand->id);
        $Brand = Brand::find($id);

        $logo = $request->file('logo');
        $slug = $request->sub_title;
        if ($request->hasfile('logo')) {
            $currentDate = Carbon::now()->toDateString();
            $logo_name = $slug . '-' . $currentDate . '-' . '.' . $logo->getClientOriginalExtension();
            $logo->move('frontend/image/Brand/', $logo_name);
        } else {
            if (isset($Brand->logo)) {
                $logo_name = $Brand->logo;
            } else {
                $logo_name = 'default.png';
            }
        }


        $before_image = $request->file('before_image');
        if ($request->hasfile('before_image')) {
            $currentDate = Carbon::now()->toDateString();
            $before_image_name = $slug . '--' . $currentDate . '-' . '.' . $before_image->getClientOriginalExtension();
            $before_image->move('frontend/image/Brand/', $before_image_name);
        } else {
            if (isset($Brand->before_image)) {
                $before_image_name = $Brand->before_image;
            } else {
                $before_image_name = 'default.png';
            }
        }


        $Brand->title = $request->title;
        $Brand->sub_title = $request->sub_title;
        $Brand->description = $request->description;
        $Brand->description2 = $request->description2;
        $Brand->logo = $logo_name;
        $Brand->before_image = $before_image_name;
        $Brand->save();
        Session::flash('message', 'Successfully created shark!');
        return view('admin.brand.brand', [
            'brands' => Brand::latest()->paginate(10),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand, $id)
    {
        Brand::chunk(1000, function ($brands) {
            foreach ($brands as $brand) {
                $brand->delete();
            }
        });

        return response()->json(['message' => 'Batch deletion completed.']);
        Brand::find($id)->delete();
        return redirect()->back();
    }
}
