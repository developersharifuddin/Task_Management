<?php

namespace App\Http\Controllers\Admin\HK;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{


    public function index(Request $request)
    {
        try {
            // dd($request->all());
            $perPage = $request->input('per_page', 5);
            $parent_id = $request->input('parent_id');
            $type = $request->input('type');

            $filters = $request->only(['search', 'type', 'status', 'per_page']);


            $query = Category::with('children')
                // ->where('name_english', 'like', "%{$request->input('search')}%")
                ->latest()
                ->filter($filters);

            if ($parent_id) {
                $query->whereIn('parent_id', [$parent_id]);
            }

            if ($type) {
                $query->where('type', $type);
            }

            $data = $query->paginate($perPage);
            // dd($data);

            if ($request->ajax()) {
                return view('admin.categories.index', [
                    'categories' => $data,
                ])->render(); // Render the view for AJAX requests
            } else {
                return view('admin.categories.index', [
                    'categories' => $data,
                ]);
            }

            // dd($categories);

            // // $perPage = $request->input('per_page', 10); // Default to 10 records per page, adjust as needed
            // $search = $request->input('search');
            // $status = $request->input('status'); // 'active', 'inactive', or null
            // // $brands =  Brand::select('name_english', 'name_bangla')->whereIn('status', [0, 1])->latest('id')->paginate(10);
            // $query = Category::query()->select('id', 'name_english', 'name_bangla', 'slug', 'paret', 'meta_title', 'meta_description', 'home_status', 'status')->whereIn('status', [0, 1])->latest('id');
            // // Apply status filter
            // if ($status) {
            //     $query->where('status' === $status);
            // }
            // // Apply search filter
            // if ($search) {
            //     $query->where(function ($query) use ($search) {
            //         $query->where('name_english', 'like', '%' . $search . '%')
            //             ->orWhere('name_bangla', 'like', '%' . $search . '%');
            //         // Add other fields as needed for searching
            //     });
            // }

            // $show = $request->input('show', 10); // Default to 10 entries per page

            // $categories = Category::paginate($show);
            // $totalEntries = Category::count();

            // if ($request->expectsJson()) {
            //     return response()->json([
            //         'showing' => $categories->count(),
            //         'total' => $totalEntries,
            //     ]);
            // }
            // return view('admin.categories.index', compact('categories'));
        } catch (\Exception $e) {
            dd($e->getMessage()); // Output the error message for debugging
        }
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.categories.create', compact('categories', 'categories'));
    }

    public function store(StoreCategoryRequest $request)
    {
        $validatedData = $request->validated();

        // Generate slug from the name_english field
        $slug = Str::slug($validatedData['name_english']);

        // Check if the generated slug is unique; if not, append a number to make it unique
        $count = 1;
        while (Category::where('slug', $slug)->exists()) {
            $slug = Str::slug($validatedData['name_english']) . '-' . $count;
            $count++;
        }

        $validatedData['slug'] = $slug;

        // Handle logo file upload as before
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('category_logos', 'public');
            $validatedData['logo'] = $logoPath;
        } else {
            $validatedData['logo'] = 'default.png';
        }

        Category::create($validatedData);

        Session::flash('message', 'Successfully created Brand!');
        return redirect()->route('admin.categories.index')->with('success', 'Inserted Successfullly');
    }


    public function edit(Category $category)
    {
        // return  $category;
        $categories = Category::all();
        return view('admin.categories.edit', compact('category', 'categories'));
    }

    public function update(StoreCategoryRequest $request, Category $category)
    {
        // return  $category;
        $validatedData = $request->validated();

        // Generate slug from the name_english field
        $slug = Str::slug($validatedData['name_english']);

        // Check if the generated slug is unique; if not, append a number to make it unique
        $count = 1;
        while (Category::where('slug', $slug)->where('id', '!=', $category->id)->exists()) {
            $slug = Str::slug($validatedData['name_english']) . '-' . $count;
            $count++;
        }

        $validatedData['slug'] = $slug;

        // Handle logo file upload and update
        if ($request->hasFile('logo')) {
            // Delete the old logo
            Storage::disk('public')->delete($category->logo);

            // Store the new logo
            $logoPath = $request->file('logo')->store('category_logos', 'public');
            $validatedData['logo'] = $logoPath;
        }

        $category->update($validatedData);

        return redirect()->route('admin.categories.index');
    }

    public function destroy(Category $category)
    {
        // Delete the associated logo when deleting the category
        if ($category->logo !== 'default.png') {
            Storage::disk('public')->delete($category->logo);
        }

        $category->delete();

        return redirect()->route('admin.categories.index');
    }
}
