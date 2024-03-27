<?php include_once "header.php"?>
<?php include_once "nav_sider.php"?>

<div class="layui-body">
    <!-- 内容主体区域 -->
    <div style="padding: 15px;">
        <blockquote class="layui-elem-quote layui-text">
            请假人数统计
        </blockquote>
        <div class="layui-card layui-panel">
            <div class="layui-card-header">
                一周请假人数折线统计图
            </div>
            <div class="layui-card-body">
                <div id="echart-container" style="height:430px"></div>
            </div>
        </div>
        <br><br>
    </div>
</div>
<script  src="./asset/echarts.min.js" type="text/javascript" ></script>
<script type="text/javascript">
    var dom = document.getElementById('echart-container');
    var myChart = echarts.init(dom, null, {
        renderer: 'canvas',
        useDirtyRect: false
    });
    var app = {};

    var option;

    option = {
        xAxis: {
            type: 'category',
            data: ['星期一', '星期二', '星期三', '星期四', '星期五' ]
        },
        yAxis: {
            type: 'value'
        },
        series: [
            {
                data: [10, 13, 8, 5, 15],
                type: 'line'
            }
        ]
    };

    if (option && typeof option === 'object') {
        myChart.setOption(option);
    }

    window.addEventListener('resize', myChart.resize);
</script>
<?php include_once "footer.php"?>
