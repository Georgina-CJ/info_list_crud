'use strict';

$(document).ready(function () {

    var actable = $('#accountInfoTable').DataTable({
        processing: true,
        serverSide: true,
        paging: true,
        searching: true,
        ordering: true,
        responsive: true,
        language: {
            "processing": "處理中...",
            "loadingRecords": "載入中...",
            "lengthMenu": "顯示 _MENU_ 項結果",
            "zeroRecords": "沒有符合的結果",
            "info": "顯示第 _START_ 至 _END_ 項結果，共 _TOTAL_ 項",
            "infoEmpty": "顯示第 0 至 0 項結果，共 0 項",
            "infoFiltered": "(從 _MAX_ 項結果中過濾)",
            "infoPostFix": "",
            "search": "搜尋:",
            "paginate": {
                "first": "第一頁",
                "previous": "上一頁",
                "next": "下一頁",
                "last": "最後一頁"
            },
            emptyTable: '查無資料'
        },
        ajax: {
            'url': 'api/accountInfo',
            'dataType': 'json',
            'data': function (d) { },
            'dataSrc': function (json) {
                for (var i = 0, ien = json.data.length; i < ien; i++) {
                    if (json.data[i]['sex'] == 0) {
                        json.data[i]['sex'] = '男';
                    } else if (json.data[i]['sex'] == 1) {
                        json.data[i]['sex'] = '女';
                    }
                    var birth = json.data[i]['birthday'].split('-');
                    json.data[i]['birthday'] = birth[0] + '年' + birth[1] + '月' + birth[2] + '日';
                }
                return json.data;
            }
        },
        "lengthMenu": [[10, 20, 50, 75, -1], [10, 20, 50, 75, "全部"]],
        "pageLength": 20,
        "columnDefs": [
            { "orderable": false, "targets": 0 }
        ],
        'columns': [
            {
                data: 'id',
                name: 'id',
                'className': 'text-center',
                'fnCreatedCell': function (nTd, sData, oData, iRow, iCol) {
                    $(nTd).html('<input type="checkbox" id="listChecked' + oData.id + '" name="listChecked" value="' + oData.id + '">');
                }
            },
            { data: 'account', name: 'account' },
            { data: 'name', name: 'name' },
            { data: 'sex', name: 'sex' },
            { data: 'birthday', name: 'birthday' },
            { data: 'email', name: 'email' },
            { data: 'memo', name: 'memo' },
            { data: 'created_at', name: 'created_at' },
            {
                data: 'id',
                name: 'id',
                'className': 'text-center',
                'fnCreatedCell': function (nTd, sData, oData, iRow, iCol) {
                    $(nTd).html('<button type="button" class="btn btn-info" data-action="edit" data-id="' + oData.id + '">編輯</button>');
                }
            }
        ],
        'drawCallback': function (settings, json) {
            $('[data-action="edit"]').on('click', ({ target }) => {
                var id = $(target).data('id');
                axios.get(`api/accountInfo/${id}`)
                    .then(({ data }) => {
                        $('#createModal .modal-title').html('編輯帳號');
                        $('#inputAccount').val(data[0]['account']);
                        $('#inputName').val(data[0]['name']);
                        $('#inputBirthday').val(data[0]['birthday']);
                        $('#inputEmail').val(data[0]['email']);
                        $('#inputMemo').val(data[0]['memo']);
                        $('[name="inputSex"][value="' + data[0]['sex'] + '"]').prop("checked", true);
                        $('#createModal .modal-footer').append(`<button type="button" class="btn btn-primary" data-action="update" data-id="${data[0]['id']}">更新</button>`);
                        $('#createModal [data-action="create"]').hide();
                        $('#createModal').modal('show');

                        $('#createModal [data-action="update"]').on('click', ({ target }) => {
                            const uid = $(target).data('id');
                            const account = $('#inputAccount').val();
                            const name = $('#inputName').val();
                            const sex = $('[name="inputSex"]:checked').val();
                            const birthday = $('#inputBirthday').val();
                            const email = $('#inputEmail').val();
                            const memo = $('#inputMemo').val();
                            if (!account || !name || !sex || !birthday || !email) {
                                return alert('請輸入必填欄位');
                            }
                            axios.put(`/api/accountInfo/${uid}`, {
                                account: account,
                                name: name,
                                sex: sex,
                                birthday: birthday,
                                email: email,
                                memo: memo
                            })
                                .then(({ status }) => {
                                    if (status == 200) {
                                        $('#createModal').modal('hide');
                                        actable.draw();
                                        alert('更新完成！');
                                    }
                                })
                                .catch(err => {
                                    if (err.response.status == 422) {
                                        alert(err.response.data);
                                    }
                                });
                        });
                    })
                    .catch(err => {
                        if (err.response.status == 422) {
                            alert(err.response.data);
                        }
                    });
            });
        }
    });

    $('[data-action="show"]').on('click', () => {
        $('#createModal .modal-title').html('新增帳號');
    });

    $('[data-action="create"]').on('click', () => {
        const account = $('#inputAccount').val();
        const name = $('#inputName').val();
        const sex = $('[name="inputSex"]:checked').val();
        const birthday = $('#inputBirthday').val();
        const email = $('#inputEmail').val();
        const memo = $('#inputMemo').val();
        if (!account || !name || !sex || !birthday || !email) {
            return alert('請輸入必填欄位');
        }
        axios.post('/api/accountInfo', {
            params: {
                account: account,
                name: name,
                sex: sex,
                birthday: birthday,
                email: email,
                memo: memo
            }
        }).then(res => {
            // handle success
            if (res.status == 200) {
                $('#createModal').modal('hide');
                actable.draw();
            };
        }).catch(err => {
            // handle error
            if (err.response.status == 422) {
                alert(err.response.data);
            }
        });
    });

    $('[data-action="delete"]').on('click', () => {
        var ids = [];
        $('[name="listChecked"]:checked').map(function () { ids.push($(this).val()); });
        if (ids.length > 0) {
            if (confirm('確定要刪除此 ' + ids.length + ' 筆帳號')) {
                axios.delete('/api/accountInfo', {
                    params: {
                        ids
                    }
                }).then(() => {
                    actable.draw();
                }).catch(err => {
                    if (err.response.status == 422) {
                        alert(err.response.data);
                    }
                });
            };
        } else {
            alert('請至少勾選一筆帳號');
        };
    });
});

$('#createModal').on('hidden.bs.modal', function (e) {
    $('#inputAccount,#inputName,#inputEmail,#inputMemo').val('');
    $('#createModal [data-action="create"]').show();
    if ($('[data-action="update"]').length > 0) {
        $('[data-action="update"]').remove();
    }
});

