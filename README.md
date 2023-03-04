## Laravel 9 Repository Design Pattern CRUD Implementation
In this project, here i use repository design pattern and make a CRUD application using laravel repository design pattern.

## Implementation Process
##### 1. Create new laravel project via composer
```
composer create-project laravel/laravel Laravel-Repository-Design-Pattern-CRUD-Implementation
```

Go to project directory ```cd Laravel-Repository-Design-Pattern-CRUD-Implementation``` or open project with IDE.

##### 2. Create a new database
Here I'm using my MySQL PHPMyAdmin to create a database.<br>
Open ``` .env ``` file and add your database credentials.
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=testdb
DB_USERNAME=root
DB_PASSWORD=
```
Run migration artisan command
```
php artisan migrate
```

##### 3. Category Model, Migration file, Controller Create 
Now create model, migration file, controller for Category
```
php artisan make:model Categories -mc
```

Then open Categories migration file and add name column
```
public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); //new added
            $table->timestamps();
        });
    }
```
Then run migration artisan command
```
php artisan migrate
```

##### 4. Repository Interface Create for Categories
```App\Repositories\Interfaces\CategoryRepositoryInterface.php```
``` 
<?php
namespace App\Repositories\Interfaces;

Interface CategoryRepositoryInterface{

    public function allCategories();
    public function storeCategory($data);
    public function findCategory($id);
    public function updateCategory($data, $id);
    public function destroyCategory($id);

}
```

##### 5. Repository Class Create and method implement
```App\Repositories\CategoryRepository.php```
``` 
<?php

namespace App\Repositories;

use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;

class CategoryRepository implements CategoryRepositoryInterface{

    public function allCategories(){
        return Category::all();
    }

    public function storeCategory($data){
        return Category::create($data);
    }

    public function findCategory($id){
        return Category::find($id);
    }

    public function updateCategory($data, $id){
        $category = Category::where('id',$id)->first();
        $category->name = $data['name'];
        $category->save();
    }

    public function destroyCategory($id){
        $category = Category::find($id);
        $category->delete();
    }
}

```

##### 6. Bind Repository in ServiceProvider
open ```app/Providers/AppServiceProvider.php```  and bind
``` 
public function register()
    {
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
    }
```

##### 7. Create route for Categories CRUD
open ```routes\web.php```  and add this
```
<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

// Category
Route::group(['prefix'=>'category'],function (){
    Route::get('index',[CategoryController::class,'index'])->name('category.index');
    Route::get('create',[CategoryController::class,'create'])->name('category.create');
    Route::post('store',[CategoryController::class,'store'])->name('category.store');
    Route::get('edit/{id}',[CategoryController::class,'edit'])->name('category.edit');
    Route::post('update/{id}',[CategoryController::class,'update'])->name('category.update');
    Route::get('show/{id}',[CategoryController::class,'show'])->name('category.show');
    Route::post('delete/{id}',[CategoryController::class,'delete'])->name('category.delete');
});
```

##### 8. Categories Controller CRUD method implementation
open ```App\Http\Controllers\CategoryController.php```  and add this
```
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

```

##### 9. Create view file and implement
```resources\views\categories\index.blade.php```
```resources\views\categories\create.blade.php```
```resources\views\categories\edit.blade.php```
```resources\views\categories\details.blade.php```
<br>
Follow source code for view implementation.

Then run  ```php artisan serve``` & you can see the project on ```http://127.0.0.1:8000```
###### Completed.
