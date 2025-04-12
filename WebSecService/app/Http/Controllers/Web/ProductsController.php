<?php
namespace App\Http\Controllers\Web;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Purchase;

class ProductsController extends Controller
{

    use ValidatesRequests;

    public function __construct()
    {
        $this->middleware('auth:web')->except('list');
    }

    public function updateStock(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:products,id',
            'stock' => 'required|numeric|min:0',
        ]);

        $product = Product::find($request->id);
        $product->stock = $request->stock;
        $product->save();

        return back()->with('success', 'Stock updated successfully!');
    }

    public function list(Request $request)
    {
        $query = Product::select("products.*");

        $query->when(
            $request->keywords,
            fn($q) => $q->where("name", "like", "%$request->keywords%")
        );

        $query->when(
            $request->min_price,
            fn($q) => $q->where("price", ">=", $request->min_price)
        );

        $query->when($request->max_price, fn($q) =>
            $q->where("price", "<=", $request->max_price));

        $query->when(
            $request->order_by,
            fn($q) => $q->orderBy($request->order_by, $request->order_direction ?? "ASC")
        );

        $products = $query->get();

        return view('products.list', compact('products'));
    }

    public function edit(Request $request, Product $product = null)
    {
        if (!auth()->user()) {
            return redirect('/');
        }

        // Check if user has permission to edit products
        if (!auth()->user()->hasPermissionTo('edit_products')) {
            abort(401);
        }

        $product = $product ?? new Product();

        return view('products.edit', compact('product'));
    }



    public function save(Request $request, $id = null)
    {

        $this->validate($request, [
            'code' => ['required', 'string', 'max:32'],
            'name' => ['required', 'string', 'max:128'],
            'model' => ['required', 'string', 'max:256'],
            'description' => ['required', 'string', 'max:1024'],
            'price' => ['required', 'numeric'],
            'stock' => ['required', 'numeric']
        ]);

        if ($request->input('_method') === 'PUT' && $id) {
            // Update existing product
            $product = Product::findOrFail($id);
            $product->fill($request->all());
            $product->save();
        } else {
            // Create new product
            $product = new Product();
            $product->fill($request->all());
            $product->save();
        }

        return redirect()->route('products_list')->with('success', 'Product saved successfully.');
    }


    public function delete(Request $request, Product $product)
    {

        if (!auth()->user()->hasPermissionTo('delete_products'))
            abort(401);

        $product->delete();

        return redirect()->route('products_list');
    }

    public function buy(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $product = Product::find($request->product_id);
        $user = auth()->user();

        if ($user->credit < $product->price) {
            return redirect()->route('insufficient.credit');
        }

        // Deduct credit and update stock
        $user->credit -= $product->price;
        $user->save();

        $product->stock -= 1;
        $product->save();

        // Add to purchases
        Purchase::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'total_price' => $product->price,
            'purchased_at' => now(),
        ]);

        return back()->with('success', 'Product bought successfully!');
    }

    public function boughtProducts(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $product = Product::find($request->product_id);
        $user = auth()->user();

        if ($user->credit < $product->price) {
            return redirect()->route('insufficient.credit');
        }

        // Deduct credit and update stock
        $user->credit -= $product->price;
        $user->save();

        $product->stock -= 1;
        $product->save();

        // Add to purchases
        Purchase::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'total_price' => $product->price,
            'purchased_at' => now(),
        ]);

        return redirect()->route('purchases')->with('success', 'Product added to bought products list!');
    }
}
