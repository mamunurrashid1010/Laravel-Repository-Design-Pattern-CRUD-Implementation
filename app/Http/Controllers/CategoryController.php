<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    // index
    public function index(){
        $categories = $this->categoryRepository->allCategories();
        return view('categories.index', compact('categories'));
    }

    // create
    public function create(){
        return view('categories.create');
    }

    // store
    public function store(Request $request){
        $data = $request->validate([
            'name' => 'required',
        ]);
        $this->categoryRepository->storeCategory($data);
        return redirect()->route('category.index')->with('message', 'create successfully');
    }

    // show
    public function show($id){
        $category = $this->categoryRepository->findCategory($id);
        return view('categories.details', compact('category'));
    }

    // edit
    public function edit($id){
        $category = $this->categoryRepository->findCategory($id);
        return view('categories.edit', compact('category'));
    }

    // update
    public function update(Request $request, $id){
        $data = $request->validate([
            'name' => 'required',
        ]);
        $this->categoryRepository->updateCategory($data, $id);
        return redirect()->route('category.index')->with('message','update successfully');
    }

    // delete
    public function delete($id){
        $this->categoryRepository->destroyCategory($id);
        return redirect()->route('category.index')->with('message', 'Category Delete Successfully');
    }
}
