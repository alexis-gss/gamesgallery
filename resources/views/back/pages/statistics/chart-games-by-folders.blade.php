<div class="charts-md w-100" id="chart-games-by-folders"></div>
<script>
    document.addEventListener("DOMContentLoaded", function(event) {
        /** chart-games-by-folders */
        var chartGamesByFolders = window.Echarts.init(document.getElementById('chart-games-by-folders'), 'royal');
        optionGamesByFolders = {
            title: {
                text: @json(Str::of(__('bo_other_stats_model_by_model', [
                    'model1' => Str::of(trans_choice('models.game', 2))->plural()->ucFirst()->value(),
                    'model2' => Str::of(__('models.folder'))->plural()->ucFirst()->value()
                ]))->ucFirst()->value()),
                left: 'center',
                textStyle: {
                    fontSize: '16px',
                    color: getComputedStyle(document.body).getPropertyValue('--bs-body-color'),
                },
            },
            tooltip: {
                trigger: 'item',
                backgroundColor: 'rgb(' + getComputedStyle(document.body).getPropertyValue('--bs-emphasis-color-rgb') + ', .9)',
                borderColor: 'rgba(0,0,0,0)',
                borderRadius: 6,
                textStyle: {
                    color: getComputedStyle(document.body).getPropertyValue('--bs-body-bg'),
                },
                formatter: (params) => {
                    return `<p class="fw-bold m-0">${params.name}</p>
                        <div class="d-flex justify-content-start align-items-center">
                            <span class="card-pellet rounded-5" style="background-color:${params.color}"></span>&nbsp;&nbsp;
                            <p class="m-0" style="color:${getComputedStyle(document.body).getPropertyValue('--bs-body-bg')}">${params.seriesName}&nbsp;:&nbsp;<span class="fw-bold">${params.value}</span>&nbsp;
                            (${Math.round((params.value/@json(count($globalGames))*100) * 100) / 100}%)</p>
                        </div>`;
                },
            },
            toolbox: {
                show: true,
                feature: {
                    restore: {
                        show: true
                    },
                    saveAsImage: {
                        show: true
                    },
                }
            },
            legend: {
                type: 'scroll',
                orient: 'vertical',
                left: 'left',
                icon: 'rect',
                textStyle: {
                    color: getComputedStyle(document.body).getPropertyValue("--bs-body-color"),
                }
            },
            calculable: true,
            grid: {
                top: '30%',
                left: '0%',
                right: '0%',
                bottom: '0%',
                containLabel: true
            },
            series: [{
                name: @json(Str::of(trans_choice('models.game', 2))->ucFirst()->value()),
                type: 'pie',
                radius: '70%',
                label: {
                    color: getComputedStyle(document.body).getPropertyValue("--bs-body-color"),
                    formatter: (params) => {
                        return `${params.name}`;
                    },
                    fontSize: 14
                },
                data: @json(
                    $globalFolders->map(function ($folder) {
                        return ['value' => count($folder->games), 'name' => $folder->name];
                    })),
                color: @json(
                    $globalFolders->map(function ($folder) {
                        return $folder->color;
                    })),
                percentPrecision: 2,
                emphasis: {
                    label: {
                        show: true
                    },
                    itemStyle: {
                        shadowBlur: 10,
                        shadowOffsetX: 0,
                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                    }
                }
            }, ]
        };
        chartGamesByFolders.setOption(optionGamesByFolders);
    });
</script>
