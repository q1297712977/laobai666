define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'robot/robotinforun/index',
                    add_url: 'robot/robotinforun/add',
                    edit_url: 'robot/robotinforun/edit',
                    del_url: 'robot/robotinforun/del',
                    multi_url: 'robot/robotinforun/multi',
                    table: 'robot_info_run',
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
                        {field: 'dumpenergy', title: __('Dumpenergy'), operate:'BETWEEN'},
                        {field: 'alarm_type', title: __('Alarm_type')},
                        {field: 'alarm_content', title: __('Alarm_content')},
                        {field: 'total_distance', title: __('Total_distance'), operate:'BETWEEN'},
                        {field: 'azimuthangle', title: __('Azimuthangle'), operate:'BETWEEN'},
                        {field: 'elevation', title: __('Elevation'), operate:'BETWEEN'},
                        {field: 'latitude', title: __('Latitude')},
                        {field: 'longitude', title: __('Longitude')},
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