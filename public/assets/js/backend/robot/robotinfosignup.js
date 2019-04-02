define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'robot/robotinfosignup/index',
                    add_url: 'robot/robotinfosignup/add',
                    edit_url: 'robot/robotinfosignup/edit',
                    del_url: 'robot/robotinfosignup/del',
                    multi_url: 'robot/robotinfosignup/multi',
                    table: 'robot_info_signup',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'robot_sn', title: __('Robot_sn')},
                        {field: 'robot_model', title: __('Robot_model')},
                        {field: 'robot_catalog', title: __('Robot_catalog')},
                        {field: 'date_manufacture', title: __('Date_manufacture')},
                        {field: 'customer', title: __('Customer')},
                        {field: 'location', title: __('Location')},
                        {field: 'addtime', title: __('Addtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});