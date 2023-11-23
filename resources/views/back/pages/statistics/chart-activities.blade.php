<div class="charts-sm w-100" id="chart-activities"></div>
<script>
    document.addEventListener("DOMContentLoaded", function(event) {
        /** chart-activities */
        var chartActivities = window.Echarts.init(document.getElementById('chart-activities'), 'royal');
        var optionActivities = {
            title: {
                text: @json(Str::of(__('bo_other_stats_latest_activities'))->ucFirst()->value()),
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
                    listValue = '';
                    params.forEach(element => {
                        listValue += `<li class="list-group-item bg-transparent border-0 p-0">
                                        <div class="d-flex justify-content-start align-items-center">
                                            <span class="card-pellet rounded-5" style="background-color:${element.color}"></span>&nbsp;&nbsp;
                                            <span style="color:${getComputedStyle(document.body).getPropertyValue('--bs-body-bg')}">${element.seriesName}&nbsp;:&nbsp;<strong>${element.value}</strong></span>
                                        </div>
                                    </li>`;
                    });
                    return `<span class="fw-bold">${params[0].name}</span>
                        <ul class="list-group">
                            ${listValue}
                        </ul>`;
                },
            },
            dataZoom: [{
                xAxisIndex: 0,
            }],
            toolbox: {
                feature: {
                    restore: {
                        show: true
                    },
                    saveAsImage: {
                        show: true
                    },
                }
            },
            grid: {
                top: '25%',
                left: '0%',
                right: '1%',
                bottom: '18%',
                containLabel: true
            },
            xAxis: {
                type: 'category',
                boundaryGap: false,
                data: @json($dateLastDaysFormated),
            },
            yAxis: {
                type: 'value'
            },
            series: [{
                    name: @json(Str::of(trans_choice('models.game', 2))->ucFirst()->value()),
                    type: 'line',
                    smooth: true,
                    data: @json($activityModels['App\Models\Game']),
                    color: '#0D6EFD',
                },
                {
                    name: @json(Str::of(__('models.folder'))->plural()->ucFirst()->value()),
                    type: 'line',
                    smooth: true,
                    data: @json($activityModels['App\Models\Folder']),
                    color: '#dc3545',
                },
                {
                    name: @json(Str::of(__('models.tag'))->plural()->ucFirst()->value()),
                    type: 'line',
                    smooth: true,
                    data: @json($activityModels['App\Models\Tag']),
                    color: '#0dcaf0',
                },
                {
                    name: @json(Str::of(__('models.user'))->plural()->ucFirst()->value()),
                    type: 'line',
                    smooth: true,
                    data: @json($activityModels['App\Models\User']),
                    color: '#ffc107',
                },
            ]
        };
        chartActivities.setOption(optionActivities);
    });
</script>
