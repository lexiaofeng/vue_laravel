<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function read(Request $request, $id)
    {
        $category = json_decode(Category::find($id));
//        dd($category);
        return response()->json([
            'code' => 0,
            'msg' => 'success',
            'data' => $category,
        ]);
    }
    public function index(Request $request)
    {

        $categories = Category::all();
//        return view('category',['arr'=>$categories]);
        return response()->json([
            'code' => 0,
            'msg' => 'success',
            'data' => $categories,
        ]);
    }

    public function add(Request $request)
    {
        //数据效验
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|min:2|max:30',
            'property' => 'required|string|min:0',
            'sort' => 'required|numeric|min:0',
            'status' => 'required|numeric|min:0|max:2',
        ],
            [
            'required' => ':attribute为必填项',
            'in'       => ':attribute类型错误',
            'min'      => ':attribute长度不符合要求',
            'max'      => ':attribute长度超过限制',
        ],
            [
            'type' => '类型',
            'name' => '分类名称',
            'property' => '属性',
            'sort' => '排序',
            'status' => '状态',
        ]
        );
        if ($validator->fails()){
            return response()->json([
                'code' => -1,
                'msg' => $validator->errors()->first(),
                'data' => [],
            ]);
        }

//
          json_encode($request->input('property'));
        $result = (new CategoryService())->add($request->input());
//        dd($result);

         //保存失败
        if (!$result) {
            return response()->json([
                'code' => -1,
                'msg' => 'fail',
                'data' => [],
            ]);
        }


        // 成功
        return response()->json([
            'code' => 0,
            'msg' => 'success',
            'data' => $result,
        ]);

    }

    public function del(Request $request)
    {
//        dd($request->has('id'));
        if(!$request->has('id')){
            return response()->json([
                'code' => -1,
                'msg' => '参数不正确',
                'data' => [],
            ]);
        }
        $category = Category::find($request->input('id'));
        if($category->delete()){
            return response()->json([
                'code' => 0,
                'msg' => 'success',
                'data' => '删除成功',
            ]);

        }else{
            return response()->json([
                'code' => -1,
                'msg' => 'fail',
                'data' => [],
            ]);

        }

    }

    public function update (Request $request,$id)
    {
//        dd($request->input('id'));
        if(!$id){
            return response()->json([
                'code' => -1,
                'msg' => '参数不正确',
                'data' => [],
            ]);
        }

        if (!$request->isMethod('POST')){
            return response()->json([
                'code' => -1,
                'msg' => '传输方式不正确',
                'data' => [],
            ]);
        }

        //数据效验
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|min:2|max:30',
            'property' => 'required|string|min:0',
            'sort' => 'required|numeric|min:0',
            'status' => 'required|numeric|min:0|max:2',
        ],
            [
                'required' => ':attribute为必填项',
                'in'       => ':attribute类型错误',
                'min'      => ':attribute长度不符合要求',
                'max'      => ':attribute长度超过限制',
            ],
            [
                'type' => '类型',
                'name' => '分类名称',
                'property' => '属性',
                'sort' => '排序',
                'status' => '状态',
            ]
        );
//        dd($validator);
        if ($validator->fails()){
            return response()->json([
                'code' => -1,
                'msg' => $validator->errors()->first(),
                'data' => [],
            ]);
        }
        json_encode($request->input('property'));

        $category = Category::find($id);
        $category->name = $request->input('name');
        $category->property = $request->input('property');
        $category->sort = $request->input('sort');
        $category->status = $request->input('status');
        if ($category->save()){
            return response()->json([
                'code' => 0,
                'msg' => 'success',
                'data' => $category,
            ]);
        }else{
            return response()->json([
                'code' => -1,
                'msg' => 'fail',
                'data' => [],
            ]);
        }



    }
}
