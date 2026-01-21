# Laravel Product & Rule CRUD (Without Pivot Table)

This document contains **FULL WORKING CODE** for:

- Product CRUD
- Rule CRUD
- Rule-based Tag Apply
- Tags stored as **comma-separated values** in `products.tag`
- Tags are **added only after clicking Apply**
- Existing tags are **preserved**
- **No duplicate tags**

---

## 1. Database Migrations

### products table
```php
Schema::create('products', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->decimal('price',10,2);
    $table->integer('qty');
    $table->string('sku')->unique();
    $table->string('tag')->nullable(); // comma separated
    $table->timestamps();
});
```

### rules table
```php
Schema::create('rules', function (Blueprint $table) {
    $table->id();
    $table->string('field');      // price, qty, sku, name
    $table->string('operator');   // <, >, =
    $table->string('value');
    $table->string('tag');
    $table->timestamps();
});
```

---

## 2. Models

### app/Models/Product.php
```php
class Product extends Model
{
    protected $fillable = [
        'name','price','qty','sku','tag'
    ];
}
```

### app/Models/Rule.php
```php
class Rule extends Model
{
    protected $fillable = [
        'field','operator','value','tag'
    ];
}
```

---

## 3. Controllers

### app/Http/Controllers/ProductController.php
```php
class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        Product::create($request->validate([
            'name'=>'required',
            'price'=>'required|numeric',
            'qty'=>'required|integer',
            'sku'=>'required|unique:products'
        ]));

        return redirect()->route('products.index');
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $product->update($request->validate([
            'name'=>'required',
            'price'=>'required|numeric',
            'qty'=>'required|integer',
            'sku'=>'required|unique:products,sku,'.$product->id
        ]));

        return redirect()->route('products.index');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return back();
    }
}
```

---

### app/Http/Controllers/RuleController.php
```php
class RuleController extends Controller
{
    public function index()
    {
        $rules = Rule::latest()->get();
        return view('rules.index', compact('rules'));
    }

    public function create()
    {
        return view('rules.create');
    }

    public function store(Request $request)
    {
        Rule::create($request->validate([
            'field'=>'required',
            'operator'=>'required',
            'value'=>'required',
            'tag'=>'required'
        ]));

        return redirect()->route('rules.index');
    }

    // APPLY RULE (append tag if exists)
    public function apply($id)
    {
        $rule = Rule::findOrFail($id);

        $products = Product::where(
            $rule->field,
            $rule->operator,
            $rule->value
        )->get();

        foreach ($products as $product) {
            $tags = $product->tag
                ? array_map('trim', explode(',', $product->tag))
                : [];

            if (!in_array($rule->tag, $tags)) {
                $tags[] = $rule->tag;
            }

            $product->update([
                'tag' => implode(',', $tags)
            ]);
        }

        return back()->with('success','Rule applied successfully');
    }

    public function destroy(Rule $rule)
    {
        $rule->delete();
        return back();
    }
}
```

---

## 4. Routes (routes/web.php)
```php
Route::resource('products', ProductController::class);
Route::resource('rules', RuleController::class)->except('show');

Route::post('rules/{id}/apply', [RuleController::class,'apply'])
    ->name('rules.apply');
```

---

## 5. Blade Views

### resources/views/products/index.blade.php
```blade
<a href="{{ route('products.create') }}">Add Product</a>

<table border="1">
<tr>
<th>Name</th><th>Price</th><th>Qty</th><th>SKU</th><th>Tags</th><th>Action</th>
</tr>

@foreach($products as $product)
<tr>
<td>{{ $product->name }}</td>
<td>{{ $product->price }}</td>
<td>{{ $product->qty }}</td>
<td>{{ $product->sku }}</td>
<td>{{ $product->tag }}</td>
<td>
<a href="{{ route('products.edit',$product) }}">Edit</a>
<form method="POST" action="{{ route('products.destroy',$product) }}">
@csrf @method('DELETE')
<button>Delete</button>
</form>
</td>
</tr>
@endforeach
</table>
```

---

### resources/views/rules/index.blade.php
```blade
<a href="{{ route('rules.create') }}">Create Rule</a>

<table border="1">
<tr>
<th>Field</th><th>Condition</th><th>Value</th><th>Tag</th><th>Action</th>
</tr>

@foreach($rules as $rule)
<tr>
<td>{{ $rule->field }}</td>
<td>{{ $rule->operator }}</td>
<td>{{ $rule->value }}</td>
<td>{{ $rule->tag }}</td>
<td>
<form method="POST" action="{{ route('rules.apply',$rule->id) }}">
@csrf
<button>Apply</button>
</form>
</td>
</tr>
@endforeach
</table>
```

---

### resources/views/rules/create.blade.php
```blade
<form method="POST" action="{{ route('rules.store') }}">
@csrf

<select name="field">
<option value="price">Price</option>
<option value="qty">Qty</option>
<option value="sku">SKU</option>
<option value="name">Name</option>
</select>

<select name="operator">
<option value="<"><</option>
<option value=">">></option>
<option value="=">=</option>
</select>

<input name="value" placeholder="Value">
<input name="tag" placeholder="Tag name">

<button>Save Rule</button>
</form>
```

---

## 6. Final Notes

- Tags are added **only when Apply button is clicked**
- Existing tags are preserved
- No duplicate tags
- Suitable for small to medium applications

For large-scale systems, a pivot table is recommended.

---

END OF DOCUMENT

