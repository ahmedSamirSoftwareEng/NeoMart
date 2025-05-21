<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Dashboard;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Http\Requests\CategoryRequest;

class CategoriesController extends Controller
{
    public function index()
    {
        $request = request();
        $categories = Category::leftJoin('categories as parents', 'categories.parent_id', '=', 'parents.id')
            ->select([
                'categories.*',
                'parents.name as parent_name'
            ])->filter($request->all())->paginate(4);

        return view('dashboard.categories.index', compact('categories'));
    }

    public function create()
    {
        $categories = Category::all();
        $category = new Category();
        return view('dashboard.categories.create', compact('category', 'categories'));
    }

    public function store(CategoryRequest $request)
    {
        $data = $request->except('image');
        $data['image'] = $this->uploadImage($request);
        $data['slug'] = Str::slug($request->name);
        Category::create($data);
        return redirect()->route('dashboard.categories.index')->with('success', 'Category created successfully.');
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);
        return view('dashboard.categories.show', compact('category'));
    }
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $categories = Category::where('id', '!=', $id)
            ->where(function ($query) use ($id) {
                $query->whereNull('parent_id')
                    ->orWhere('parent_id', '!=', $id);
            })
            ->get();
        return view('dashboard.categories.edit', compact('category', 'categories'));
    }
    public function update(CategoryRequest $request, $id)
    {
        $category = Category::findOrFail($id);
        $oldImage = $category->image;
        $data = $request->except('image');
        $newImage = $this->uploadImage($request);
        if ($newImage) {
            $data['image'] = $newImage;
        }
        $data['slug'] = Str::slug($request->name);
        if ($oldImage && $newImage) {
            $oldImagePath = public_path('storage/' . $oldImage);
            if (file_exists($oldImagePath)) {
                Storage::disk('public')->delete($oldImage);
            }
        }
        $category->update($data);
        return redirect()->route('dashboard.categories.index')->with('success', 'Category updated successfully.');
    }
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $oldImage = $category->image;
        $category->delete();
        if ($oldImage) {
            $oldImagePath = public_path('storage/' . $oldImage);
            if (file_exists($oldImagePath)) {
                Storage::disk('public')->delete($oldImage);
            }
        }
        return redirect()->route('dashboard.categories.index')->with('success', 'Category deleted successfully.');
    }

    protected function uploadImage(Request $request)
    {
        if (!$request->hasFile('image')) {
            return;
        }
        $file = $request->file('image');
        $path = $file->store('uploads', ['disk' => 'public']);
        return $path;
    }

    public function trash()
    {
        $categories = Category::onlyTrashed()->paginate();
        return view('dashboard.categories.trash', compact('categories'));
    }

    public function restore($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();
        return redirect()->route('dashboard.categories.trash')->with('success', 'Category restored successfully.');
    }

    public function forceDelete($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->forceDelete();
        return redirect()->route('dashboard.categories.trash')->with('success', 'Category deleted permanently.');
    }
}
