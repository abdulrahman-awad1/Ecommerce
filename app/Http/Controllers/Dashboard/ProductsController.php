<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Tag;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            // محاولة التحقق من الصلاحية
             $this->authorize('viewAny', Product::class);



            // جلب المنتجات مع العلاقات (الفئة والمتجر) والصفحات
            $products = Product::with('category', 'store')->paginate();

            // إرجاع البيانات بصيغة JSON مع معلومات الصفحة (مثل الصفحات الحالية وtotal)
            return response()->json([
                'data' => $products->items(), // إرجاع المنتجات في العنصر 'data'
                'pagination' => [
                    'total' => $products->total(),
                    'current_page' => $products->currentPage(),
                    'per_page' => $products->perPage(),
                    'last_page' => $products->lastPage(),
                ]
            ]);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            // في حالة فشل التحقق من الصلاحية، إرجاع رسالة خطأ 403
            return response()->json(['message' => 'Not authorized'], 403);
        } catch (\Exception $e) {
            // في حالة حدوث خطأ آخر غير متوقع
            return response()->json(['message' => 'An error occurred', 'error' => $e->getMessage()], 500);
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->authorize('update', Product::class);

        $product = Product::findOrFail($id);
        $tags = $product->tags;
        return response()->json([
            'product' => $product,
            'tags' => $tags
        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $this->authorize('update', Product::class);

        $product->update($request->all());
      /*  $tags = explode(',',$request->post('tags'));
        $tag_ids =[];
        foreach ($tags as $t_name){
            $slug = Str::slug($t_name);
            $tag = Tag::where('slug',$slug)->first();
            if (!$tag){
                $tag = Tag::create([
                    'tag'=>$t_name,
                    'slug'=>$slug
                ]);
            }
            $tag_ids[] =$tag->id;
        }
        $product->tags()->sync($tag_ids);*/

        return response()->json([
            'message' => 'profile update'
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
