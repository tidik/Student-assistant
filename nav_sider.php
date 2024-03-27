<?php $select = $_GET['select']; ?>
<div class="layui-side layui-bg-black">
    <div class="layui-side-scroll">
        <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
        <ul class="layui-nav layui-nav-tree" lay-filter="test">
            <li class="layui-nav-item layui-nav-itemed">
                <a class="" href="javascript:;">请假管理</a>
                <dl class="layui-nav-child">
                    <dd <?php if($select == 1){echo "class=layui-this";}?>><a href="./ask.php?select=1">申请列表</a></dd>
                    <dd <?php if($select == 2){echo "class=layui-this";}?>><a href="ask_for_read.php?select=2">已批列表</a></dd>
                    <dd <?php if($select == 3){echo "class=layui-this";}?>><a href="people_to_where.php?select=3">人员去处</a></dd>
                </dl>
            </li>
        </ul>
    </div>
</div>


