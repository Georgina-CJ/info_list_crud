<?php

namespace App\Http\Controllers\api;

use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

use App\Models\AccountInfo;

class AccountInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = AccountInfo::select('*');
        return datatables()->of($list)->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $query = $request['params'];
        $validator = Validator::make($query, [
            'account' => 'required|string',
            'name' => 'required|string',
            'sex' => 'required|boolean',
            'birthday' => 'required|date',
            'email' => 'required|email:rfc,dns'
        ]);

        if ($validator->fails()) {
            return response('必填欄位錯誤，無法新增', 422);
        };

        $query['account'] = strtolower($query['account']);
        AccountInfo::create($query);
        return response('', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = AccountInfo::where('id', '=', $id);
        if ($result->count() !== 1) {
            return response('資料查訊錯誤', 422);
        }
        return $result->get();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $query = $request->all();
        $validator = Validator::make($query, [
            'account' => 'required|string',
            'name' => 'required|string',
            'sex' => 'required|boolean',
            'birthday' => 'required|date',
            'email' => 'required|email:rfc,dns'
        ]);

        if ($validator->fails()) {
            return response('必填欄位錯誤，無法更新', 422);
        };

        try {
            AccountInfo::where('id', '=', $id)->update([
                'account' => $query['account'],
                'name' => $query['name'],
                'sex' => $query['sex'],
                'birthday' => $query['birthday'],
                'email' => $query['email'],
                'memo' => $query['memo'] ?? ''
                ]);

            return response('', 200);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response('更新失敗', 422);
        };
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $query = $request->all();
        $validator = Validator::make($query, [
            'ids' => 'required'
        ]);
        if ($validator->fails()) {
            return response('錯誤，請重新選取帳號', 422);
        };

        AccountInfo::whereIn('id', $query['ids'])->delete();
        return response('', 200);
    }
}
