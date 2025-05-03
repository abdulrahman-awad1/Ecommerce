<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    public function __invoke(Request $request)
    {
        // Your logic here
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Category::query();

        $name = $request->query('name');
        if ($name) {
            $query->where('name', 'LIKE', "%{$name}%");
        }

        $status = $request->query('status');
        if ($status) {
            $query->where('status', '=', $status);
        }

        $categories = $query
            ->with('parent')
            ->withCount('products as product_number')
            ->orderBy('id')
            ->paginate(3);

        return response()->json([
            'data' => $categories->items(),
            'current_page' => $categories->currentPage(),
            'last_page' => $categories->lastPage(),
            'per_page' => $categories->perPage(),
            'total' => $categories->total(),
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parents = Category::all();

        return response()->json([
            'data' => $parents
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //  $request->validate([
        //     'name'=>'required|string|min:3',
        //     'parent_id'=>'nullable|int|exists:categories,id',
        //     'image'=>'nullable|image|max:1048576',/*|dimensions:min_width=10,max_height=100000*/ //image النوع صوره , max عباره عن حجم الصوره ب البايت
        //     'status'=>'in:active,archived',
        //c دي الاسماء الجايه من الفورم مش الداتا بيز
        //blade كدا الايرور مش هيظهر, لازم اعرف متغير اليرور ف صفحة ال  validation  بمجرد ما عملت ال
        // ]);

        $user = new Category;

        $rules = $user->rules();

        $this->validate($request, $rules);

        // merge بتستخدم عشان اضيف داتا مش موجوده ف الفورم
        $request->merge([
            //  'slug'=> '' دا المفروض الشكل الطبيعي ولكن ال تحت دي فانكشن اخري
            'slug'=>Str::slug($request->post('name'))
            //slug دا اسم الحقل ال هيتملي ف الداتا بيز ,
            //v =>  slug  ما بعد العلامه دي كدا انا عملت
        ]);

        $data = $request->except('image'); //b هنا استثنيت ان الصوره تاخد قيمتها من الفورم لان هتاخد القيمه من المسار الجديد

        /*  $image = $request->file('image');//  name كدا روحت ع الفورم دخلت جوه الحقل ال نوعه فيل واسمه
         // $image_name =  $request->file('image')->getClientOriginalName();//m جبت الاسم الاصلي للملف
          $path = $image->store('uploads','public'); //storage كل دا داخل ال  image مكان تخزين الصوره ف ملف  البابلك ف مجلد
          //filesystem دا المسؤل عن مكان التخزين
          //filesystem ادخل*/
        $data['image']=$this->upload_Image($request);

        //  $data['image']=$this->upload_Image($request);
        //upload_image استدعاء فانكشن ال





        $category = Category::create($data);
        return response()->json([
            'message' => 'the product added'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return response()->json([
            'data' => $category
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::findOrFail($id);

        $parents = Category::where('id', '<>', $id)
            ->where(function ($query) use ($id) {
                $query->whereNull('parent_id')
                    ->orWhere('parent_id', '<>', $id);
            })->get();

        return response()->json([
            'category' => $category,
            'available_parents' => $parents
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $request->validate([
            'name'=>'string|min:3',
            'parent_id'=>'nullable|int|exists:categories,id',
            'image'=>'nullable|image|max:1048576',/*|dimensions:min_width=10,max_height=100000*/ //image النوع صوره , max عباره عن حجم الصوره ب البايت
            'status'=>'in:active,archived',
            //c دي الاسماء الجايه من الفورم مش الداتا بيز
            //blade كدا الايرور مش هيظهر لازم اعرف متغير اليرور ف صفحة ال  validation  بمجرد ما عملت ال
        ]);
        $category = Category::findOrFail($id); // x دي بتعمل ابديت

        //  $category =new Category(); دي بتكريت اوبجيكت جديد من الكاتيجوري
        //  $category->fill($request->all())->save(); نفس وظيفة الابديت

        /* $category->name = $request->name; طريقه اخري
         $category->description = $request->description;
         $category->save();*/
        $old_image = $category->image; // f بجيب الصوره القديمه عشان احذفها


        $data = $request->except('image');
        $new_image=$this->upload_Image($request);
        if ($new_image){
            $data['image']= $new_image;
        }
        $category->update($data);


        if ($old_image && $new_image){
            storage::disk('public')->delete($old_image);
        }


        /* $image = $request->file('image');
         $image_name =  $request->file('image')->getClientOriginalName();
         $path = $image->storeAs('uploads',$image_name,'public');*/
        /* $image->getSize();
         $image->getMimeType();
         $image->getClientOriginalExtension();*/




        return response()->json([
            'message' => 'the product updated'
        ], 200);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();


        //   Category::destroy($id);

        return response()->json([
            'message' => 'the product deleted'
        ], 200);


    }
    protected function upload_Image(Request $request){
        // $data = $request->except('image'); //b هنا استثنيت ان الصوره تاخد قيمتها من الفورم لان هتاخد القيمه من المسار الجديد

        if (!$request->hasFile('image')){
            return;
        }

        $image = $request->file('image');//  name كدا روحت ع الفورم دخلت جوه الحقل ال نوعه فيل واسمه
        $image_name =  $request->file('image')->getClientOriginalName();//m جبت الاسم الاصلي للملف
        $path = $image->storeAs('uploads',$image_name,'public');
        return $path;

    }

    public function trash(){
        $categories = Category::onlyTrashed()->paginate();
        return response()->json([
            'data' => $categories
        ]);

    }

    public function restore($id){
        $categories = Category::onlyTrashed()->findOrFail($id);
        $categories->restore();
        return response()->json([
            'message' => 'category restored'
        ], 200);

    }
    public function forceDelete($id){
        $categories = Category::onlyTrashed()->findOrFail($id);
        $categories->restore();

        if ($categories->image){
            storage::disk('public')->delete($categories->image);
        }
        return response()->json([
            'message' => 'category deleted'
        ], 200);

    }


}
