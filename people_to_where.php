<?php include_once "header.php"?>
<?php include_once "nav_sider.php"?>

<div class="layui-body">
    <!-- 内容主体区域 -->
    <div style="padding: 15px;">
        <blockquote class="layui-elem-quote layui-text">
            请假已审批
        </blockquote>
        <div class="layui-card layui-panel">
            <div class="layui-card-header"><div id="hint-msg" style="padding: 5px">人员去处：<span style="color:green">在校</span></div></div>
            <div class="layui-card-body">
                <table class="layui-hide" id="test" lay-filter="test"></table>
            </div>
        </div>
        <br><br>
    </div>
</div>
<script type="text/html" id="toolbarDemo">
    <div class="layui-btn-container">
        <button class="layui-btn layui-btn-sm layui-bg-blue" id="reloadTest">
            人员去处
            <i class="layui-icon layui-icon-down layui-font-12"></i>
        </button>
    </div>
</script>
<script type="text/html" id="barDemo">
    <div class="layui-btn-container">
        <a class="layui-btn layui-btn-xs" lay-event="edit">详情</a>
        <a class="layui-btn layui-btn-xs" lay-event="more">
            通知
            <i class="layui-icon layui-icon-down"></i>
        </a>
    </div>
</script>

<script>
    layui.use(['table', 'dropdown','jquery','form'], function(){
        var table = layui.table;
        var dropdown = layui.dropdown;
        var $ = layui.jquery;
        var form = layui.form;
        // 创建渲染实例
        table.render({
            elem: '#test'
            ,url:'./controller.php?sign=getToWhereAsk&approve=1'
            ,toolbar: '#toolbarDemo'
            ,defaultToolbar: ['filter', 'exports', 'print', {
                title: '提示'
                ,layEvent: 'LAYTABLE_TIPS'
                ,icon: 'layui-icon-tips'
            }]
            ,css: [ // 重设当前表格样式
                '.layui-table-tool-temp{padding-right: 155px;}'
            ].join('')
            ,cellMinWidth: 80
            ,limit: 6
            ,limits:[5,6,7,8,9,10]
            ,totalRow: true // 开启合计行
            ,page: true
            ,cols: [[
                {type: 'checkbox', fixed: 'left'}
                ,{field:'UID', fixed: 'left', width:80, title: 'UID', sort: true}
                ,{field:'username', width:80, title: '用户'}
                ,{field:'sex', width:80, title: '性别', sort: true}
                ,{field:'phone', title:'手机 <i class="layui-icon layui-icon-tips layui-font-14" title="该字段开启了编辑功能" style="margin-left: 5px;"></i>', fieldTitle: '邮箱', hide: 0, width:115}
                ,{field:'hometown', width:100, title: '家乡'}
                ,{field:'asktype', title: '类型', minWidth: 80},
                ,{field:'destination', width:80, title: '目的地'}
                ,{field:'leavetime', title:'请假时间', width: 120}
                ,{field:'returntime', title:'返回时间', width: 120}
                ,{field:'totalask', title:'次数', width: 80}
                ,{fixed: 'right', title:'操作', width: 134, minWidth: 125, toolbar: '#barDemo'}
            ]]
            ,done: function() {
                var id = this.id;
                dropdown.render({
                    elem: '#reloadTest' // 可绑定在任意元素中，此处以上述按钮为例
                    , data: [{
                        id: 'atschool',
                        title: '在校'
                    },{
                        id: 'leaveschool',
                        title: '离校'
                    }]
                    // 菜单被点击的事件
                    , click: function (obj) {
                        switch (obj.id) {
                            case 'atschool':
                                // 重载 - 默认（参数重置）
                                table.reload('test', {
                                    where: {
                                        atschool:1,

                                    }
                                });
                                //当前类型：<span >允许请假</span>
                                $("#hint-msg").html('人员去处：<span style="color:green">在校</span>');
                                break;
                            case 'leaveschool':
                                table.reload('test', {
                                    where: {
                                        atschool:0,
                                    }
                                });
                                $("#hint-msg").html('人员去处：<span style="color:red">离校</span>');
                                break;
                        }
                        layer.msg('数据重载成功');
                    }
                });
            }
            ,error: function(res, msg){
                console.log(res, msg)
            }
        });
        // 触发单元格工具事件
        table.on('tool(test)', function(obj){ // 双击 toolDouble
            var data = obj.data; // 获得当前行数据
            //console.log(data.username);
            if(obj.event === 'edit'){
                form.val('show_form', {
                    "username": data.username
                    ,"phone": data.phone
                    ,"hometown": data.hometown
                    ,"sex": data.sex
                    ,"destination":data.destination
                    ,"leavetime":data.leavetime
                    ,"returntime":data.returntime
                    ,"reason":data.reason
                });
                layer.open({
                    title: '查看请假详情 - UID:'+ data.UID,
                    type: 1,
                    area: ['80%','80%'],
                    content: $('#create_table_from')
                });

            }else if(obj.event === 'more'){
                // 更多 - 下拉菜单
                dropdown.render({
                    elem: this, // 触发事件的 DOM 对象
                    show: true, // 外部事件触发即显示
                    data: [{
                        title: '邮件通知',
                        id: 'sendmail'
                    },{
                        title: '短信通知',
                        id: 'sendsms'
                    }],
                    click: function(menudata){
                        if(menudata.id === 'sendmail'){
                            $.post('./controller.php?sign=sendmsg', {UID:data.UID,sendtype:'email',notice:1}, function(str){
                                console.log(str);
                                if(str.code == 200){
                                    layer.msg(str.msg);
                                }
                                if(str.code == 500){
                                    layer.msg(str.msg);
                                    table.reload('test', {
                                        where: {
                                            reload: 'true'
                                        }
                                    });
                                }
                            },"json");

                        } else if(menudata.id === 'sendsms'){
                            layer.confirm('确定要发送短信通知 <b>'+ data.username +'</b> 的请假审批状态么?【运营商可能会收取一定费用】', function(index){
                                $.post('./controller.php?sign=sendmsg', {UID:data.UID,sendtype:'sms',notice:1}, function(str){
                                    console.log(str);
                                    if(str.code == 200){
                                        layer.msg(str.msg);
                                    }
                                    if(str.code == 500){
                                        layer.msg(str.msg);
                                        table.reload('test', {
                                            where: {
                                                reload: 'true'
                                            }
                                        });
                                    }
                                },"json");
                                layer.close(index);
                                // 向服务端发送删除指令
                            });
                        }
                    },
                    align: 'right', // 右对齐弹出
                    style: 'box-shadow: 1px 1px 10px rgb(0 0 0 / 12%);' // 设置额外样式
                })
            }
        });
        // 触发表格复选框选择
        table.on('checkbox(test)', function(obj){
            layer.msg("复选框就是单纯为了好看的~");
        });
    });
</script>
<?php include_once "footer.php"?>
