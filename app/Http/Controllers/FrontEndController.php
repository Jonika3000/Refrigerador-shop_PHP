<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\item;
use Illuminate\Http\Request;
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

        $filename = uniqid(). '.' .$request->file("image")->getClientOriginalExtension();
        Storage::disk('local')->put("public/images/categories/".$filename,file_get_contents($request->file("image")));
        $input["image"] = $filename;
        print($input["image"]);
        if($input["status"])
            $input["status"] = 1;
        else
            $input["status"] = 0;

        $category = item::create($input);
        return response()->json($category);
    }
    public function product($slug)
    {
        $category = Category::where('slug', $slug)->first();

        if ($category) {
            $item = item::where('id', $category->id)->get();
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
}
