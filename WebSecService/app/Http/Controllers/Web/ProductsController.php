<?php
namespace App\Http\Controllers\Web;
use Illuminate\Http\Request;
use App\Models\Product;
use DB;
use App\Http\Controllers\Controller;
class ProductsController extends Controller
{


    // public function list(Request $request)
    // {
    //     $products = (object) [
    //         (object) [
    //             'id' => 1,
    //             'code' => 'TV01',
    //             'name' => 'LG TV 50"',
    //             'model' => 'LG8768787',
    //             'photo' => 'lgtv50.jpg',
    //             'description' => 'lorem ipsum..'
    //         ],
    //         (object) [
    //             'id' => 2,
    //             'code' => 'RF01',
    //             'name' => 'Toshiba Refrigerator 14"',
    //             'model' => 'TS76634',
    //             'photo' => 'tsrf50.jpg',
    //             'description' => 'lorem ipsum..'
    //         ],
    //     ];
    //     return view("products.list", compact('products'));
    // }
    public function list(Request $request)
    {
        $_REQUESTproducts = Product::where('price', '<', 20000)->get();
        $products = Product::where('code', 'like', 'tv%')->get();
        $products = Product::orderBy('price', 'desc')->get();
        $products = Product::where('price', '>', 20000)->where('price', '<', 40000)->get();
        $products = Product::orWhere('price', '>', 40000)
            ->orWhere('price', '<', 20000)->get();
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
        return view("products.list", compact('products'));
    }
    public function edit(Request $request, Product $product = null)
    {
        $product = $product ?? new Product();
        return view("products.edit", compact('product'));
    }
    public function save(Request $request, Product $product = null)
    {
        $request->validate([
            'price' => 'required|numeric|min:0|max:9999999999',
        ]);

        $product = $product ?? new Product();
        $product->fill($request->all());
        $product->price = $request->price; // Ensure price is set
        $product->save();
        return redirect()->route('products.list'); // Update route name to match the defined route
    }
    public function delete(Request $request, Product $product)
    {
        $product->delete();
        return redirect()->route('products.list'); // Update route name to match the defined route
    }
}

