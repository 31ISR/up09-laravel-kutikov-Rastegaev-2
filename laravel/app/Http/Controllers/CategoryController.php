<?php


namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
       /**
        * @var User $user
        */

        $user = Auth::user();
        $categories = $user->categories()
            ->latest()
            ->withCount('tasks')
            ->get();

        return view('categories.index', compact('categories'));
    }

    public function store(Request $request)
    {

        $data = $request->validate([
            "name"=>"required|string|max:255",
            'color' => 'nullable|string|hex_color'
        ]);

        /**
        * @var User $user
        */

        $user = Auth::user();
        $user->categories()->create($data);

        return redirect()->route('categories.index')->with('success', 'Категория создана');
    }

    public function create()
    {
        return view('categories.create');
    }


    public function edit(Request $request, Category $category)
    {
        $this->authorize('update', $category);


        
        return view('categories.edit', compact('category'));


    }

    public function update(Request $request, Category $category)
    {


        $this->authorize('update', $category);

        $data = $request->validate([
            "name"=>"required|string|max:255",
            'color' => 'nullable|string|hex_color'
        ]);

        $category->update($data);
        return redirect()->route('categories.index')->with('success', 'Запись обновлена');


    }


    public function destroy(Category $category)
    {
        // dd($categories);
        $this->authorize('delete', $category);
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Категория удалена');   
    }
}