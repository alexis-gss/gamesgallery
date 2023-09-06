<div class="charts w-100" id="chart-games-by-tags"></div>
<script>
    document.addEventListener("DOMContentLoaded", function(event) {
        /** chart-games-by-tags */
        var chartGamesByTags = window.Echarts.init(document.getElementById('chart-games-by-tags'), 'royal');
        var optionGamesByTags = {
            title: {
                text: 'Games by tag',
                left: 'center',
                textStyle: {
                    fontSize: '16px',
                    color: '#000',
                },
            },
            tooltip: {
                trigger: 'axis',
                backgroundColor: 'rgba(15,15,15,0.90)',
                borderColor: 'rgba(0,0,0,0)',
                textStyle: {
                    color: '#FFF',
                },
                formatter: (params) => {
                    return `<strong>${params[0].name}</strong><br/>
                        <span class="px-2" style="background-color:${params[0].color}"></span>&nbsp;
                        ${params[0].seriesName}&nbsp;:&nbsp;<strong>${params[0].value}</strong>&nbsp;(${Math.round((params[0].value/@json(count($globalGames))*100) * 100) / 100}%)`;
                },
            },
            dataZoom: [
                {
                    xAxisIndex: 0,
                }
            ],
            toolbox: {
                show : true,
                feature : {
                    dataView : {show: true, readOnly: false},
                    restore : {show: true},
                    saveAsImage : {show: true},
                }
            },
            calculable : true,
            xAxis : [
                {
                    type : 'category',
                    data : @json($globalTags->map(function ($tag) { return $tag->name; })),
                }
            ],
            yAxis : [
                {
                    type : 'value',
                }
            ],
            series : [
                {
                    name: 'Game',
                    type: 'bar',
                    data: @json($globalTags->map(function ($tag) { return count($tag->games); })),
                    color: '#0D6EFD',
                    markPoint : {
                        data : [
                            {type : 'max', name: 'Max'},
                            {type : 'min', name: 'Min'},
                        ]
                    },
                    emphasis: {
                        itemStyle: {
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowColor: 'rgba(0, 0, 0, 0.5)'
                        }
                    }
                }
            ]
        };
        chartGamesByTags.setOption(optionGamesByTags);
    });
</script>
