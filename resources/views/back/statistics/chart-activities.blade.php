<div class="charts-sm w-100" id="chart-activities"></div>
<script>
    document.addEventListener("DOMContentLoaded", function(event) {
        /** chart-activities */
        var chartActivities = window.Echarts.init(document.getElementById('chart-activities'), 'royal');
        var optionActivities = {
            title: {
                text: 'Lastest activities',
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
                    listValue = "";
                    params.forEach(element => {
                        listValue += `<li class="list-group-item bg-transparent text-white border-0 p-0">
                                        <div class="d-flex justify-content-start align-items-center">
                                            <span class="card-pellet rounded-5" style="background-color:${element.color}"></span>&nbsp;&nbsp;
                                            <span>${element.seriesName}&nbsp;:&nbsp;<strong>${element.value}</strong></span>
                                        </div>
                                    </li>`;
                    });
                    return `<span class="fw-bold">${params[0].name}</span>
                        <ul class="list-group">
                            ${listValue}
                        </ul>`;
                },
            },
            dataZoom: [
                {
                    xAxisIndex: 0,
                }
            ],
            toolbox: {
                feature: {
                    restore : {show: true},
                    saveAsImage : {show: true},
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
            series: [
                {
                    name: 'Games',
                    type: 'line',
                    smooth: true,
                    data: @json($modelActivities["App\Models\Game"]),
                    color: '#0D6EFD',
                },
                {
                    name: 'Folders',
                    type: 'line',
                    smooth: true,
                    data: @json($modelActivities["App\Models\Folder"]),
                    color: '#dc3545',
                },
                {
                    name: 'Tags',
                    type: 'line',
                    smooth: true,
                    data: @json($modelActivities["App\Models\Tag"]),
                    color: '#0dcaf0',
                },
                {
                    name: 'Users',
                    type: 'line',
                    smooth: true,
                    data: @json($modelActivities["App\Models\User"]),
                    color: '#ffc107',
                },
            ]
        };
        chartActivities.setOption(optionActivities);
    });
</script>
