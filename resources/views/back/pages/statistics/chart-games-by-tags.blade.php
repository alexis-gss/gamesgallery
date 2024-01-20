<div class="charts-sm w-100" id="chart-games-by-tags"></div>
<script nonce="{{ $nonce }}">
    document.addEventListener("DOMContentLoaded", function(event) {
        /** chart-games-by-tags */
        var chartGamesByTags = window.Echarts.init(document.getElementById('chart-games-by-tags'), 'royal');
        var optionGamesByTags = {
            title: {
                text: @json(Str::of(trans_choice('models.game', 2))->ucFirst()->value() .
                        "\u{00A0}" .
                        __('bo_other_stats_by') .
                        "\u{00A0}" .
                        Str::of(__('models.tag'))->plural()->ucFirst()->value()),
                left: 'center',
                textStyle: {
                    fontSize: '16px',
                    color: getComputedStyle(document.body).getPropertyValue('--bs-body-color'),
                },
            },
            tooltip: {
                trigger: 'axis',
                backgroundColor: 'rgb(' + getComputedStyle(document.body).getPropertyValue('--bs-emphasis-color-rgb') + ', .9)',
                borderColor: 'rgba(0,0,0,0)',
                borderRadius: 6,
                textStyle: {
                    color: getComputedStyle(document.body).getPropertyValue('--bs-body-bg'),
                },
                formatter: (params) => {
                    return `<p class="fw-bold m-0">${params[0].name}</p>
                        <div class="d-flex justify-content-start align-items-center">
                            <span class="card-pellet rounded-5" style="background-color:${params[0].color}"></span>&nbsp;&nbsp;
                            <p class="m-0" style="color:${getComputedStyle(document.body).getPropertyValue('--bs-body-bg')}">${params[0].seriesName}&nbsp;:&nbsp;<span class="fw-bold">${params[0].value}</span>&nbsp;
                            (${Math.round((params[0].value/@json(count($globalGames))*100) * 100) / 100}%)</p>
                        </div>`;
                },
            },
            dataZoom: [{
                xAxisIndex: 0,
            }],
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
            calculable: true,
            grid: {
                top: '25%',
                left: '0%',
                right: '1%',
                bottom: '18%',
                containLabel: true
            },
            xAxis: [{
                type: 'category',
                data: @json(
                    $globalTags->map(function ($tag) {
                        return $tag->name;
                    })),
            }],
            yAxis: [{
                type: 'value',
            }],
            series: [{
                name: @json(Str::of(trans_choice('models.game', 2))->ucFirst()->value()),
                type: 'bar',
                data: @json(
                    $globalTags->map(function ($tag) {
                        return count($tag->games);
                    })),
                color: getComputedStyle(document.body).getPropertyValue("--bs-primary"),
                markPoint: {
                    data: [{
                            type: 'max',
                            name: 'Max'
                        },
                        {
                            type: 'min',
                            name: 'Min'
                        },
                    ]
                },
                emphasis: {
                    itemStyle: {
                        shadowBlur: 10,
                        shadowOffsetX: 0,
                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                    }
                }
            }]
        };
        chartGamesByTags.setOption(optionGamesByTags);
    });
</script>
