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
        //index دا خاص بالسيرش ف ال ف صفحة ال
        $query = Category::query(); //c هتسيرش بالكويري الجاي من الفورم
        $name = $request->query('name'); //name الفورم كان فيها
        if ($name){
            $query->where('name','LIKE',"%{$name}%");
        }
        $status = $request->query('status'); //select الفورم كان فيها
        if ($status){
            $query->where('status','=',"$status");
        }

       // $categories=$query->paginate(3);
        $categories=Category::with('parent') //h دا بديل الجوين عشان اعرض محتوي جدول عن طريق جدول اخر
         //   ->filter($request->query())
            ->withCount('products as product_number')//x استدعيها ف البليد عشان تظهر
         ->orderBy('id')
            ->paginate(3);

        return view('dashboard.categories.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parents = Category::all();
        return view('dashboard.categories.create',compact('parents'));
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
        return redirect()->route('categories.index')
            ->with('success','the product added'); // flash message دي رساله المفروض تظهر بعد عملية الاضافه تسمي
                                                    // index هستقبل الرساله ف
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category )
    {
        return view('dashboard.categories.show',[
            'category'=>$category
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::findOrFail($id);

        $parents = Category::where('id','<>',$id)
            ->where(function ($query) use ($id) {
                $query->whereNull('parent_id')->orWhere('parent_id','<>',$id);
            })->get();
        return view('dashboard.categories.edit',compact('category','parents'));
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





        return redirect()->route('categories.index')
            ->with('success','the product updated');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();


     //   Category::destroy($id);

        return redirect()->route('categories.index')
            ->with('success','the product deleted');

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
        return view('dashboard.categories.trash',compact('categories'));
    }

    public function restore($id){
        $categories = Category::onlyTrashed()->findOrFail($id);
        $categories->restore();
        return redirect('categories.restore')->with('success','category restore');
    }
    public function forceDelete($id){
        $categories = Category::onlyTrashed()->findOrFail($id);
        $categories->restore();

        if ($categories->image){
            storage::disk('public')->delete($categories->image);
        }
        return redirect('categories.restore')->with('success','category deleted');
    }


}
