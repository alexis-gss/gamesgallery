<div class="row">
    <div class="col-12">
        <form class="input-group mb-3" action="{{ route('bo.statistics.update') }}" method="POST">
            <label class="input-group-text" for="date_start">{{ str(__('validation.custom.date_start'))->ucFirst() }}</label>
            <input class="form-control" id="date_start" name="date_start" type="date"
                value="{{ !empty($dateLastDays->first()) ? $dateLastDays->first()->format('Y-m-d') : Carbon::now()->subDays(29)->format('Y-m-d') }}"
                required>
            @csrf
            <label class="input-group-text" for="date_end">{{ str(__('validation.custom.date_end'))->ucFirst() }}</label>
            <input class="form-control" id="date_end" name="date_end" type="date"
                value="{{ !empty($dateLastDays->last()) ? $dateLastDays->last()->format('Y-m-d') : Carbon::now()->format('Y-m-d') }}"
                required>
            <button class="btn btn-primary" data-bs-tooltip="tooltip" type="submit" title="{{ __('bo_other_stats_show_activities') }}">
                {{ __('bo_other_stats_visualize') }}
            </button>
        </form>
    </div>
    <div class="col-12 mt-4">
        <div class="charts-sm w-100" id="chart-activities"></div>
    </div>
</div>
<script nonce="{{ $nonce }}">
    document.addEventListener("DOMContentLoaded", function(event) {
        /** chart-activities */
        var chartActivities = window.Echarts.init(document.getElementById('chart-activities'), 'royal');
        var optionActivities = {
            title: {
                text: @json(str(__('bo_other_stats_latest_activities'))->ucFirst()),
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
                    name: @json(str(trans_choice('models.game', \INF))->ucFirst()),
                    type: 'line',
                    smooth: true,
                    data: @json($activityModels['App\Models\Game']),
                    color: '#0D6EFD',
                },
                {
                    name: @json(str(__('models.folder'))->plural()->ucFirst()),
                    type: 'line',
                    smooth: true,
                    data: @json($activityModels['App\Models\Folder']),
                    color: '#dc3545',
                },
                {
                    name: @json(str(__('models.tag'))->plural()->ucFirst()),
                    type: 'line',
                    smooth: true,
                    data: @json($activityModels['App\Models\Tag']),
                    color: '#0dcaf0',
                },
                {
                    name: @json(str(__('models.user'))->plural()->ucFirst()),
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
