<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Nav;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class NavController extends Controller
{
    public function pic(Request $request)
    {

        if ($request->isMethod('POST')) { //判断文件是否是 POST的方式上传

            $tmp = $request->file('picture');

            $path = '/article'; //public下的article
            if ($tmp->isValid()) { //判断文件上传是否有效

                $FileType = $tmp->getClientOriginalExtension(); //获取文件后缀

                $FilePath = $tmp->getRealPath(); //获取文件临时存放位置

                $FileName = date('Y-m-d') . uniqid() . '.' . $FileType; //定义文件名

                Storage::disk('article')->put($FileName, file_get_contents($FilePath)); //存储文件



                return $data = [
                    'code' => 0,
                    'path' => $path . '/' . $FileName //文件路径
                ];
            }
        }
    }


    public function index()
    {
        $navs = json_decode(Nav::all());
//        dd($navs);
        return response()->json([
            'code' => 0,
            'msg' => 'success',
            'data' => $navs,
        ]);

    }
    public function read($id)
    {
        $nav = json_decode(Nav::find($id));
//        dd($navs);
        return response()->json([
            'code' => 0,
            'msg' => 'success',
            'data' => $nav,
        ]);

    }

    public function add(Request $request)
    {
        //数据校验
        $validator = Validator::make($request->all(), [
            'type_id' => 'required|numeric|min:1|max:4',
            'sort' => 'required|numeric|min:0',
            'title' => 'required|string|min:0|max:50',
//                'picture' => 'required|string|min:0|max:255',
            'link_type' => 'required|numeric|min:1',
            'link_target' => 'required|string|min:0|max:255',
            'status' => 'required|string|min:0',

        ],
            [
                'required' => ':attribute为必填项',
                'in' => ':attribute类型错误',
                'min' => ':attribute长度不符合要求',
                'max' => ':attribute长度超过限制',
            ],
            [
                'type_id' => '类型id',
                'title' => '名字',
//                'picture' => '图片',
                'sort' => '排序',
                'status' => '状态',
                'link_type' => '链接类型',
                'link_target' => '链接目标',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'code' => -1,
                'msg' => $validator->errors()->first(),
                'data' => [],
            ]);
        }
//        dd($request->input());
        $nav = new Nav();
        $nav->type_id = $request->input('type_id');
        $nav->sort = $request->input('sort');
        $nav->title = $request->input('title');
        $nav->picture = $request->input('picture');
        $nav->link_type = $request->input('link_type');
        $nav->link_target = $request->input('link_target');
        $nav->status = $request->input('status');
        //保存失败
        if (!$nav->save()) {
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
            'data' => $nav,
        ]);

    }

    public function del(Request $request, $id)
    {
        if (!$id) {
            return response()->json([
                'code' => -1,
                'msg' => '参数不正确',
                'data' => [],
            ]);
        }
        $nav = Nav::find($id);
        if ($nav->delete()) {
            return response()->json([
                'code' => 0,
                'msg' => 'success',
                'data' => '删除成功',
            ]);
        } else {
            return response()->json([
                'code' => -1,
                'msg' => 'fail',
                'data' => [],
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        if (!$id) {
            return response()->json([
                'code' => -1,
                'msg' => '参数不正确',
                'data' => [],
            ]);
        }

        if (!$request->isMethod('POST')) {
            return response()->json([
                'code' => -1,
                'msg' => '传输方式不正确',
                'data' => [],
            ]);
        }

        //数据效验
        $validator = Validator::make($request->all(), [
            'type_id' => 'required|numeric|min:1|max:4',
            'sort' => 'required|numeric|min:0',
            'title' => 'required|string|min:0|max:50',
//            'picture' => 'required|string|min:0|max:255',
            'link_type' => 'required|numeric|min:0',
            'link_target' => 'required|string|min:0',
            'status' => 'required|numeric|min:0|max:2',
        ],
            [
                'required' => ':attribute为必填项',
                'in' => ':attribute类型错误',
                'min' => ':attribute长度不符合要求',
                'max' => ':attribute长度超过限制',
            ],
            [
                'type_id' => '类型id',
                'title' => '名字',
                'picture' => '图片',
                'link_type' => '链接类型',
                'link_target' => '链接目标',
                'status' => '状态',
            ]
        );
//        dd($validator);
        if ($validator->fails()) {
            return response()->json([
                'code' => -1,
                'msg' => $validator->errors()->first(),
                'data' => [],
            ]);
        }

        $nav = Nav::find($id);
        $nav->type_id = $request->input('type_id');
        $nav->title = $request->input('title');
        $nav->picture = $request->input('picture');
        $nav->link_type = $request->input('link_type');
        $nav->link_target = $request->input('link_target');
        $nav->sort = $request->input('sort');
        $nav->status = $request->input('status');
        if ($nav->save()) {
            return response()->json([
                'code' => 0,
                'msg' => 'success',
                'data' => $nav,
            ]);
        } else {
            return response()->json([
                'code' => -1,
                'msg' => 'fail',
                'data' => [],
            ]);
        }

    }
}
