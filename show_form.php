<div style="padding: 25px;display: none" id="create_table_from">
    <form lay-filter="show_form" class="layui-form layui-form-pane" action="">
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">姓名</label>
                <div class="layui-input-block">
                    <input type="text" name="username" id="username"  class="layui-input" disabled>
                </div>
            </div>
        </div>
        <div class="layui-form-item" pane>
            <label class="layui-form-label">性别</label>
            <div class="layui-input-block">
                <input type="radio" name="sex" value="男" title="男" >
                <input type="radio" name="sex" value="女" title="女" >
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">手机号</label>
                <div class="layui-input-block">
                    <input type="text" name="phone" id="phone"  class="layui-input" disabled>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">家乡</label>
                <div class="layui-input-block">
                    <input type="text" name="hometown" id="hometown" autocomplete="off" class="layui-input" disabled>
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">目的地</label>
                <div class="layui-input-block">
                    <input type="text"  name="destination" id="destination" autocomplete="off" class="layui-input" disabled>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">请假时间</label>
                <div class="layui-input-inline" style="width: 100px;">
                    <input type="text" name="leavetime"  autocomplete="off" class="layui-input" disabled>
                </div>
                <div class="layui-form-mid">-</div>
                <div class="layui-input-inline" style="width: 100px;">
                    <input type="text" name="returntime" autocomplete="off" class="layui-input" disabled>
                </div>
            </div>
        </div>
        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">请假原因</label>
            <div class="layui-input-block">
                <textarea name="reason" class="layui-textarea" disabled></textarea>
            </div>
        </div>
    </form>