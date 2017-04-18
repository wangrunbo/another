<html>
<head>
    <meta charset="UTF-8" />
    <title>Highcharts テスト</title>
    <script src="https://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/highcharts-more.js"></script>
</head>
<body>
<div id="container" style="width: 800px; height: 400px; margin: 0 auto"></div>


<script language="JavaScript">
    $(document).ready(function() {
        var title = {
            text: '患者様の情報'
        };
        var subtitle = {
            text: '期日'
        };
        var xAxis = {
            categories: ['１日', '２日', '３日', '４日', '５日', '６日',
                '７日', '８日', '９日', '１０日', '１１日', '１２日','１３日', '１４日', '１５日', '１６日', '１７日',
                '１8日','19日', '20日', '21日', '22日', '23日', '24日','25日', '26日', '27日',
                '28日', '29日', '30日','31日']
        };
        var yAxis = [
            {
                title: {
                    text: '体温 (\xB0C)'
                },
                plotBands:{},
                tickInterval: 0.5,
//                tickAmount: 12,
                allowDecimals: true,
                max: 41.0,
                min: 35.0


                // plotLines: [{
                //    value: 37,
                //    width: 1,
                //    color: '#242620'
                // }]
            },
            {
                title: {
                    text: '脈拍'
                },
                max: 240,
                min: 0,
                allowDecimals: true,
//                tickAmount: 12,
                tickInterval: 20

            },
            {
                title: {
                    text: '体重 (ｋｇ)'
                },
                max: 120,
                min: 0,
                allowDecimals: true,
//                tickAmount: 12,
                tickInterval: 10

            },
            {
                title: {
                    text: '血圧 ()'
                },
                max: 240,
                min: 0,
                allowDecimals: true,
//                tickAmount: 12,
                tickInterval: 20

            }

        ];

        var tooltip = {
            valueSuffix: '\xB0C'
        };

        var legend = {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        };

        var series =  [
            {
                name: '体温',
                valueSuffix: '\xB0C',
                yAxis: 0,
                data: [36.6, 37.0, 35.8, 38.3, 46.0]
            },
            {
                name: '脈拍',
                yAxis: 1,
                data: [79, 80, 100, 93, 85]
            },
            {
                name: '体重',
                valueSuffix: 'kg',
                yAxis: 2,
                data: [40,41,37,38,42]
            },
            {
                type: 'columnrange',
                name: '血圧',
                yAxis: 3,
//                data: [100,120,140,120,90]
                data: [
                    [0, 100, 120],
                    [1, 120, 140]
                ],
                pointWidth: 1,
                tooltip: {
                    pointFormat:
                }
            }
        ];

        var json = {};

        json.title = title;
        json.subtitle = subtitle;
        json.xAxis = xAxis;
        json.yAxis = yAxis;
        json.tooltip = tooltip;
        json.legend = legend;
        json.series = series;

        json.chart = {
            alignTicks: false
        };

        $('#container').highcharts(json);
    });
</script>
</body>
</html>
