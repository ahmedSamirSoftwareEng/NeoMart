<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Dashboard;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('dashboard.categories.index', compact('categories'));
    }

    public function create()
    {
        $categories = Category::all();
        $category = new Category();
        return view('dashboard.categories.create', compact('category', 'categories'));
    }

    public function store(Request $request)
    {
        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('uploads', ['disk' => 'public']);
            $data['image'] = $path;
        }
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
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $oldImage = $category->image;
        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('uploads', ['disk' => 'public']);
            $data['image'] = $path;
        }
        $data['slug'] = Str::slug($request->name);
        if ($oldImage && isset($data['image'])) {
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
}
