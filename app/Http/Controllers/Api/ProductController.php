<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        
        return response()->json([
            "status" => true,
            "message" => "Product List",
            "data" => $products
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request_data = $request->all();
        
        $validator = Validator::make($request_data, [
            'isim' => 'required',
            'alis_fiyat' => 'required',
            'satis_fiyat' => 'required',
            'adet' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Eksik Bilgi Girildi.',
                'error' => $validator->errors()
            ]);
        }

        $product = Product::create($request_data);
        
        return response()->json([
            "status" => true,
            "message" => "Ürün Ekleme Başarılı.",
            "data" => $product
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        if (is_null($product)) {
            return response()->json([
                'status' => false,
                'message' => 'Ürün Bulunamadı.'
            ]);
        }

        return response()->json([
            "success" => true,
            "message" => "Ürün Bulundu.",
            "data" => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request_data = $request->all();
        
        $validator = Validator::make($request_data, [
            'isim' => 'required',
            'alis_fiyat' => 'required',
            'satis_fiyat' => 'required',
            'adet' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Eksik Bilgi Girildi.',
                'error' => $validator->errors()
            ]);      
        }

        $product->isim = $request_data['isim'];
        $product->alis_fiyat = $request_data['alis_fiyat'];
        $product->satis_fiyat = $request_data['satis_fiyat'];
        $product->adet = $request_data['adet'];
        $product->save();
        
        return response()->json([
            "status" => true,
            "message" => "Ürün Güncelleme Başarılı.",
            "data" => $product
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json([
            "status" => true,
            "message" => "Ürün Silme Başarılı.",
            "data" => $product
        ]);
    }
}