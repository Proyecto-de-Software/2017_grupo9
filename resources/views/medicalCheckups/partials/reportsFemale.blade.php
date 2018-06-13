<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<div class='row'>
    <div id="chartReportePeso" class='col-md-10 mb-5' ></div>
    <div id="chartReporteTalla" class='col-md-10  mb-5' ></div>
    <div id="chartReportePPC" class='col-md-10  mb-5' ></div>
</div>
<script type="text/javascript">
    $(document).ready(function(){


        Highcharts.chart('chartReportePeso', {
            chart: {
                type: 'spline'
            },
            title: {
                text: 'Curva de Crecimiento Para Niños de hasta 13 semanas'
            },
            subtitle: {
                text: 'Curva de crecimiento por Peso'
            },
            xAxis: {
                type: 'days',
                labels: {
                    overflow: 'justify'
                },
                min:0,
                max:13,
                minorTickInterval:1,
            },
            yAxis: {
                title: {
                    text: 'Peso en gramos'
                },
                minorGridLineWidth: 0,
                gridLineWidth: 0,
                alternateGridColor: null,
                min:0,
                max:8000,
                minorTickInterval:0.1,

            },
            plotOptions: {
                spline: {
                    lineWidth: 1,
                    states: {
                        hover: {
                            lineWidth: 2
                        }
                    },
                    marker: {
                        enabled: false
                    },
                },
            },
            series: [
                        {
                            name: '3rd',
                            data: [ [0, 2500], [1, 2600], [2, 2800], [3, 3100], [4, 3400], [5, 3600], [6, 3800], 
                                    [7, 4100], [8, 4300], [9, 4400], [10, 4600], [11, 4800], [12, 4900], [13, 5100] ]

                        },
                        {
                            name: '15th',
                            data: [ [0, 2900], [1, 3000], [2, 3200], [3, 3500], [4, 3800], [5, 4100], [6, 4300], 
                                    [7, 4500], [8, 4700], [9, 4900], [10, 5100], [11, 5300], [12, 5500], [13, 5600] ]
                        },  
                        {
                            name: '50th',
                            data: [ [0, 3300], [1, 3500], [2, 3800], [3, 4100], [4, 4400], [5, 4700], [6, 4900], 
                                    [7, 5200], [8, 5400], [9, 5600], [10, 5800], [11, 6000], [12, 6200], [13, 6400] ]
                        },
                        {
                            name: '85th',
                            data: [ [0, 3700], [1, 3900], [2, 4100], [3, 4400], [4, 4700], [5, 5000], [6, 5200], 
                                    [7, 5500], [8, 5700], [9, 5900], [10, 6100], [11, 6300], [12, 6500], [13, 6600] ]
                        },
                        {
                            name: '97th',
                            data: [ [0, 4300], [1, 4500], [2, 4900], [3, 5200], [4, 5600], [5, 5900], [6, 6300], 
                                    [7, 6500], [8, 6800], [9, 7100], [10, 7300], [11, 7500], [12, 7700], [13, 7900] ]
                        },{
                            name:'Paciente',
                            data: {{ json_encode($weights) }},
                            lineWidth:2,
                        }
                    ],
            navigation: {
                menuItemStyle: {
                    fontSize: '10px'
                }
            }
        });
        
        Highcharts.chart('chartReporteTalla', {
            chart: {
                type: 'spline'
            },
            title: {
                text: 'Curva de Crecimiento Para Niños de hasta 24 meses'
            },
            subtitle: {
                text: 'Curva de crecimiento por Talla'
            },
            xAxis: {
                type: 'days',
                labels: {
                    overflow: 'justify'
                },
                min:0,
                max:24,
                minorTickInterval:1,
            },
            yAxis: {
                title: {
                    text: 'Talla en centimetros'
                },
                minorGridLineWidth: 0,
                gridLineWidth: 0,
                alternateGridColor: null,
                min:40 ,
                max:100,
                minorTickInterval:0.1,

            },
            plotOptions: {
                spline: {
                    lineWidth: 1,
                    states: {
                        hover: {
                            lineWidth: 2
                        }
                    },
                    marker: {
                        enabled: false
                    },
                },
            },
            series:[{
                name:'Percentil3',
                data:[[0,46.3],[1,51.1],[2,54.7],[3,57.6],[4,60],[5,61.9],[6,63.6],[7,65.1],[8,66.5],[9,67.7],[10,69],[11,70.2],[12,71.3],[13,72.4],[14,73.4],[15,74.4],[16,75.4],[17,76.3],[18,77.2],[19,78.1],[20,78.9],[21,79.7],[22,80.5],[23,81.3],[24,82.1]]
            },{
                name:'Percentil15',
                data:[[0,47.9],[1,52.7],[2,56.4],[3,59.3],[4,61.7],[5,63.7],[6,65.4],[7,66.9],[8,68.3],[9,69.6],[10,70.9],[11,72.1],[12,73.3],[13,74.4],[14,75.5],[15,76.5],[16,77.5],[17,78.5],[18,79.5],[19,80.4],[20,81.3],[21,82.2],[22,83],[23,83.8],[24,84.6]]
            },{
                name:'Percentil50',
                data:[[0,49.9],[1,54.7],[2,58.4],[3,61.4],[4,63.9],[5,65.9],[6,67.6],[7,69.2],[8,70.6],[9,72],[10,73.3],[11,74.5],[12,75.7],[13,76.9],[14,78],[15,79.1],[16,80.2],[17,81.2],[18,82.3],[19,83.2],[20,84.2],[21,85.1],[22,86],[23,86.9],[24,87.8]]
            },{
                name:'Percentil85',
                data:[[0,51.8],[1,56.7],[2,60.5],[3,63.5],[4,66],[5,68.1],[6,69.8],[7,71.4],[8,72.9],[9,74.3],[10,75.6],[11,77],[12,78.2],[13,79.4],[14,80.6],[15,81.8],[16,82.9],[17,84],[18,85.1],[19,86.1],[20,87.1],[21,88.1],[22,89.1],[23,90],[24,91]]
            },{
                name:'Percentil97',
                data:[[0,53.4],[1,58.4],[2,62.2],[3,65.3],[4,67.8],[5,69.9],[6,71.6],[7,73.2],[8,74.7],[9,76.2],[10,77.6],[11,78.9],[12,80.2],[13,81.5],[14,82.7],[15,83.9],[16,85.1],[17,86.2],[18,87.3],[19,88.4],[20,89.5],[21,90.5],[22,91.6],[23,92.6],[24,93.6]]
            },{
                name:'Paciente',
                data: {{ json_encode($heights) }},
                lineWidth:2,
                //color:'rgba(191,0,0,0.8)' 
            }
            ],
            navigation: {
                menuItemStyle: {
                    fontSize: '10px'
                }
            }
        });

        Highcharts.chart('chartReportePPC', {
            chart: {
                type: 'spline'
            },
            title: {
                text: 'Curva de Crecimiento Para Niños de hasta 13 semanas'
            },
            subtitle: {
                text: 'Curva de crecimiento por PPC'
            },
            xAxis: {
                type: 'days',
                labels: {
                    overflow: 'justify'
                },
                min:0,
                max:13,
                minorTickInterval:1,
            },
            yAxis: {
                title: {
                    text: 'PPC'
                },
                minorGridLineWidth: 0,
                gridLineWidth: 0,
                alternateGridColor: null,
                min:28,
                max:45,
                minorTickInterval:0.1,

            },
            plotOptions: {
                spline: {
                    lineWidth: 1,
                    states: {
                        hover: {
                            lineWidth: 2
                        }
                    },
                    marker: {
                        enabled: false
                    },
                },
            },
            series: [
                    {
                        name: '3rd',
                        data: [ [0, 32.1], [1, 32.9], [2, 33.7], [3, 34.3], [4, 34.9], [5, 35.4], [6, 35.9], [7, 36.3], 
                                [8, 36.7], [9, 37], [10, 37.4], [11, 37.7], [12, 38], [13, 38.3] ] 
                    },
                    {
                        name: '15th',
                        data: [ [0, 33.1], [1, 33.9], [2, 34.7], [3, 35.3], [4, 35.9], [5, 36.4], [6, 36.8], [7, 37.3], 
                                [8, 37.7], [9, 38], [10, 38.4], [11, 38.7], [12, 39], [13, 39.3] ] 
                    },
                    {
                        name: '50th',
                        data: [ [0, 34.5], [1, 35.2], [2, 35.9], [3, 36.5], [4, 37.1], [5, 37.6], [6, 38.1], [7, 38.5], 
                                [8, 38.9], [9, 39.2], [10, 39.6], [11, 39.9], [12, 40.2], [13, 40.5] ] 
                    },
                    {
                        name: '85th',
                        data: [ [0, 35.8], [1, 36.4], [2, 37.1], [3, 37.7], [4, 38.3], [5, 38.8], [6, 39.3], [7, 39.7], 
                                [8, 40.1], [9, 40.5], [10, 40.8], [11, 41.1], [12, 41.4], [13, 41.7] ] 
                    },
                    {
                        name: '97th',
                        data: [ [0, 36.9], [1, 37.5], [2, 38.1], [3, 38.7], [4, 39.3], [5, 39.8], [6, 40.3], [7, 40.7], 
                                [8, 41.1], [9, 41.4], [10, 41.8], [11, 42.1], [12, 42.4], [13, 42.7] ] 
                    },{
                        name:'Paciente',
                        data:{{ json_encode($ppc) }},
                        lineWidth:2,
                        //color:'rgba(191,0,0,0.8)' 
                        } 
                ],
            navigation: {
                menuItemStyle: {
                    fontSize: '10px'
                }
            }
        });
    });

</script>
</body>
</html>