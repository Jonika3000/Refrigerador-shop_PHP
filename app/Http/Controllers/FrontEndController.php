<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\item;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Validator;
use Storage;
class FrontEndController extends Controller
{
    /**
     * @OA\Get(
     *     tags={"Category"},
     *     path="/api/category",
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         ),
     *         description="Page number default 1"
     *     ),
     *     @OA\Response(response="200", description="List Categories.")
     * )
     */
    public function index()
    {
        $list = Category::paginate(2);
        return response()->json($list,200);
    }
    public function indexWithoutPagginate()
    {
        $list = Category::All();
        return response()->json($list,200);
    }
    public function ItemsWithoutPagginate()
    {
        $list = item::All();
        return response()->json($list,200);
    }
    /**
     * @OA\Post(
     *     tags={"Category"},
     *     path="/api/category",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"image", "name", "description"},
     *                 @OA\Property(
     *                     property="image",
     *                     type="string",
     *                     format="binary"
     *                 ),
     *                 @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="description",
     *                     type="string"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="Add Category.")
     * )
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $messages = array(
            'name.required' => 'Вкажіть назву категорії!',
            'description.required' => 'Вкажіть опис категорії!'
        );
        $validator = Validator::make($input, [
            'name' => 'required',
            'description' => 'required'
        ], $messages);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }
        $filename = uniqid(). '.' .$request->file("image")->getClientOriginalExtension();
        Storage::disk('local')->put("public/uploads/".$filename,file_get_contents($request->file("image")));
        $input["image"] = $filename;
        $category = Category::create($input);
        return response()->json($category);
    }
    public function AddItem(Request $request)
    {
        $input = $request->all();
        if (!$request->has('image')) {
            return response()->json(['message' => 'Missing file'], 422);
        }
        $filename = uniqid(). '.' .$request->file("image")->getClientOriginalExtension();
        Storage::disk('local')->put("public/uploads/".$filename,file_get_contents($request->file("image")));
        //$file = $request->file('image');
        //$name = Str::random(10);
        //$url = Storage::putFileAs('images', $file, $name . '.' . $file->extension());

        $product =  item::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'categoryId' => $request->categoryId,
            'imagePrev' =>  $filename
        ]);
        return $product;
    }
    public function updateItem($id ,Request $request )
    {
        $item = item::findOrFail($id);
        if($request->imagePrev != ''){
            $path = public_path().'/uploads/images/';

            //code for remove old file
            if($item->imagePrev != ''  && $item->imagePrev != null){
                $file_old = $path.$item->file;
                unlink($file_old);
            }

            //upload new file
            $file = $request->file;
            $filename = $file->getClientOriginalName();
            $file->move($path, $filename);

            //for update in table
            $item->update(['imagePrev' => $filename]);
        }
        else
        {
            return response()->json(['message' => 'Missing file'], 422);
        }

       // if (!$request->has('image')) {
         //   return response()->json(['message' => 'Missing file'], 422);
        //}
          //  $filename = uniqid(). '.' .$request->file("image")->getClientOriginalExtension();
            //Storage::disk('local')->put("public/uploads/".$filename,file_get_contents($request->file("image")));
            //$item->imagePrev = $filename;

        $item->name = $request->input('name', $item->name);
        $item->description = $request->input('description', $item->description);
        $item->price = $request->input('price', $item->price);
        $item->categoryId = $request->input('categoryId', $item->categoryId);

        $item->save();

        return response()->json($item);
    }

    public function product($slug)
    {
        $category = Category::where('slug', $slug)->first();

        if ($category) {
            $item = item::where('categoryId', $category->id)->get();
            if ($item) {
                return response()->json([
                    'status'=>200,
                    'items_data'=>[
                        'item'=>$item,
                        'category'=>$category
                    ]
                ]);
            }
            else{
                return response()->json([
                    'status'=>400,
                    'message'=>'no such items'
                ]);
            }
        }
        else{
            return response()->json([
                'status'=>404,
                'message'=>'no category'
            ]);
        }
    }
    public function DeleteItem($id)
    {
        $item = Item::where('id', $id)->first();
        if (Storage::disk('public')->exists('uploads/' . $item['imagePrev'])) {
            Storage::disk('public')->delete('uploads/' . $item['imagePrev']);
        }
        else{
            return response()->json(['message' => 'Missing file'], 422);
        }
        $item->delete();
        return redirect()->back()->with('success', 'Item Delete!');
    }
}
