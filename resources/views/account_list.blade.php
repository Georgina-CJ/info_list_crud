<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Account Info - Laravel</title>
        <!-- Style -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker3.min.css">
        <link rel="stylesheet" href="{{ mix('/css/app.css') }}" type="text/css">
    </head>
    <body>
        <div class="account-info p-5" data-section="account-info">
            <div class="content">
                <div class="top-part pb-2 mb-3 text-left">
                    <span class="title" >帳號CRUD表單</span>
                    <div class="operation text-left float-right">
                        <button type="button" class="btn btn-outline-primary mr-2" data-action="show" data-toggle="modal" data-target="#createModal">新增</button>
                        <button type="button" class="btn btn-outline-danger" data-action="delete">刪除</button>
                    </div>
                </div>

                <div class="list">
                    <table id="accountInfoTable" class="table table-striped table-bordered">
                        <thead class="thead-dark">
                          <tr>
                            <th scope="col"></th>
                            <th scope="col">帳號</th>
                            <th scope="col">姓名</th>
                            <th scope="col">性別</th>
                            <th scope="col" style="min-width: 106px;">生日</th>
                            <th scope="col">信箱</th>
                            <th scope="col">備註</th>
                            <th scope="col">建立時間</th>
                            <th scope="col" style="min-width: 50px;">操作</th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>
                </div>
            </div>
            <!-- createModal -->
            <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">新增帳戶</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-2 text-warning">＊：必填</div>
                            <form class="pl-md-2 pr-md-2">
                                <div class="form-group row">
                                    <label for="inputAccount" class="col-sm-2 col-form-label"><b>帳號</b><span class="text-warning">*</span></label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputAccount" placeholder="請輸入小寫英文或數字" onkeyup="value=value.replace(/[\W]/g,'') "
                                        onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputName" class="col-sm-2 col-form-label"><b>姓名</b><span class="text-warning">*</span></label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputName">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label"><b>性別</b><span class="text-warning">*</span></label>
                                    <div class="col-sm-10">
                                        <div class="form-check form-check-inline pt-2">
                                            <input class="form-check-input" type="radio" name="inputSex" id="inputSex0" value="0" checked>
                                            <label class="form-check-label" for="inputSex0">男性</label>
                                        </div>
                                        <div class="form-check form-check-inline pt-2">
                                            <input class="form-check-input" type="radio" name="inputSex" id="inputSex1" value="1">
                                            <label class="form-check-label" for="inputSex1">女性</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputBirthday" class="col-sm-2 col-form-label"><b>生日</b><span class="text-warning">*</span></label>
                                    <div class="col-sm-10">
                                        <input class="datepicker" id="inputBirthday" data-provide="datepicker" data-date-format="yyyy-mm-dd" onkeyup="value=value.replace(/[^\d\-]/g,'')" maxlength="10">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail" class="col-sm-2 col-form-label"><b>信箱</b><span class="text-warning">*</span></label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" id="inputEmail">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputMemo" class="col-sm-2 col-form-label">備註</label>
                                    <div class="col-sm-10">
                                        <input type="text"" class="form-control" id="inputMemo">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary cancel-btn" data-dismiss="modal" >取消</button>
                            <button type="button" class="btn btn-primary" data-action="create">新增</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="{{ mix('/js/app.js') }}"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    </body>
</html>
