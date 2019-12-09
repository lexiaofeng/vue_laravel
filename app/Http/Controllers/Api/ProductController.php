<?php
namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\Product;

use App\Models\Tag;
use App\Services\ProductService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::all();
//        dd(json_decode($products[0]));
//        dd($products[0]['attributes']);
        $readProducts =[];
        foreach ($products as $ind=>$record){
            $readProducts[$ind]= json_decode($record);


        }
//        dd($readProducts);

        $tags = json_decode(Tag::all());
//        foreach ($tags as $ind =>$record){
//
//        }
        return response()->json([
            'code' => 0,
            'msg' => 'success',
            'data' => $readProducts,
        ]);
    }


    public function params() {

        $params = [
            "product" => [
                "name" => ""
            ],
            "tag" => [
                ["tag_id" => 1, "value" => ''],
                ["tag_id" => 1, "value" => '']
            ],
            "sku" => [
                ["tag_id" => 1, "value" => ''],
                ["tag_id" => 1, "value" => '']
            ],
        ];

    }
    public function add(Request $request)
    {

//        dd($request->input());
//
        $params=[
            'product'=>($request->input('product')),
            'tag'=>($request->input('tag')),
            'sku'=>($request->input('sku'))
        ];
//        dd($params);
        //数据效验
        $validator = Validator::make($request->input('product'),[
            'category_id' => 'required|numeric|min:1',
            'name' => 'required|string|min:1',
//            'sale_num' => 'required|numeric|min:0',
            'content ' => 'string|min:0|max:50',
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
                'name' => '商品名称',
                'sale_num' => '商品销量',
                'content' => '商品的描述',
                'sort' => '排序',
                'status' => '状态',
            ]
        );
        if ($validator->fails()){
            return response()->json([
                'code' => -1,
                'msg' => $validator->errors(),
                'data' => [],
            ]);
        }


//        dd($params);
        $result = (new ProductService())->add($params);
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
        if(!$request->has('id')){
            return response()->json([
                'code' => -1,
                'msg' => '参数不正确',
                'data' => [],
            ]);
        }
        $product = Product::find($request->input('id'));
        if($product->delete()){
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

    public function update(Request $request,$id)
    {
        if (!$id){
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
            'category_id' => 'required|numeric|min:1',
            'name' => 'required|string|min:1|max:30',
            'sale_num' => 'required|numeric|min:0|max:9999',
            'content' => 'required|string|min:1|max:30',
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
                'name' => '商品名称',
                'sale_num' => '商品销量',
                'content' => '商品的描述',
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

        $product = Product::find($id);
        $product->category_id = $request->input('category_id');
        $product->name = $request->input('name');
        $product->sale_num = $request->input('sale_num');
        $product->content = $request->input('content');
        $product->sort = $request->input('sort');
        $product->status = $request->input('status');
        if ($product->save()){
            return response()->json([
                'code' => 0,
                'msg' => 'success',
                'data' => $product,
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
