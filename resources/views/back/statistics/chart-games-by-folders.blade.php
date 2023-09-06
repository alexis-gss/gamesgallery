<div class="charts w-100" id="chart-games-by-folders"></div>
<script>
    document.addEventListener("DOMContentLoaded", function(event) {
        /** chart-games-by-folders */
        var chartGamesByFolders = window.Echarts.init(document.getElementById('chart-games-by-folders'), 'royal');
        optionGamesByFolders = {
            title: {
                text: 'Games by folder',
                left: 'center',
                textStyle: {
                    fontSize: '16px',
                    color: '#000',
                },
            },
            tooltip: {
                trigger: 'item',
                backgroundColor: 'rgba(15,15,15,0.90)',
                borderColor: 'rgba(0,0,0,0)',
                textStyle: {
                    color: '#FFF',
                },
                formatter: (params) => {
                    return `<strong>${params.name}</strong><br/>
                        <span class="px-2" style="background-color:${params.color}"></span>&nbsp;
                        ${params.seriesName}&nbsp;:&nbsp;<strong>${params.data.value}</strong>&nbsp;(${params.percent}%)`;
                },
            },
            toolbox: {
                show : true,
                feature : {
                    dataView : {show: true, readOnly: false},
                    restore : {show: true},
                    saveAsImage : {show: true},
                }
            },
            legend: {
                type: 'scroll',
                orient: 'vertical',
                left: 'left',
                icon: 'rect',
            },
            series: [
                {
                    name: 'Game',
                    type: 'pie',
                    radius: '70%',
                    label: {
                        color: '#000',
                        formatter: (params) => {
                            return `${params.name}`;
                        },
                        fontSize: 14
                    },
                    data: @json($globalFolders->map(function ($folder) { return ["value" => count($folder->games),"name" => $folder->name]; })),
                    color: @json($globalFolders->map(function ($folder) { return $folder->color; })),
                    percentPrecision: 2,
                    emphasis: {
                        label: { show: true },
                        itemStyle: {
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowColor: 'rgba(0, 0, 0, 0.5)'
                        }
                    }
                },
            ]
        };
        chartGamesByFolders.setOption(optionGamesByFolders);
    });
</script>
