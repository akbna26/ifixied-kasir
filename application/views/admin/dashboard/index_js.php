<!-- Resources -->
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>

<script>
    $(document).ready(function() {
        generate_bulat({
            id: 'chartdiv1',
            data: [{
                    value: 10,
                    category: "Kec. Pasar Kliwon"
                },
                {
                    value: 9,
                    category: "Kec. Jebres"
                },
                {
                    value: 6,
                    category: "Kec. Banjarsari"
                },
                {
                    value: 5,
                    category: "Kec. Layweyan"
                },
                {
                    value: 4,
                    category: "Kec. Serengan"
                },
            ]
        });

        generate_batang({
            id: 'chartdiv2',
            data: [{
                country: "Aset tanah bangunan",
                value: 15
            }, {
                country: "Aset tanah jalan",
                value: 21
            }, {
                country: "Aset tanah lapangan",
                value: 81
            }, {
                country: "Aset tanah kosong",
                value: 66
            }, {
                country: "Aset tanah kuburan",
                value: 23
            }, {
                country: "Aset tanah ruang terbuka",
                value: 23
            }, ],
        })

    });

    function generate_bulat(obj) {
        am5.ready(function() {
            var root = am5.Root.new(obj.id);
            root.setThemes([
                am5themes_Animated.new(root)
            ]);

            var chart = root.container.children.push(am5percent.PieChart.new(root, {
                layout: root.verticalLayout
            }));

            var series = chart.series.push(am5percent.PieSeries.new(root, {
                valueField: "value",
                categoryField: "category",
                tooltip: am5.Tooltip.new(root, {
                    labelText: "{value} pengunjung"
                }),
            }));

            series.data.setAll(obj.data);

            series.appear(1000, 100);
        });
    }

    function generate_batang(obj) {
        am5.ready(function() {

            var root = am5.Root.new(obj.id);

            root.setThemes([
                am5themes_Animated.new(root)
            ]);

            var chart = root.container.children.push(am5xy.XYChart.new(root, {
                wheelable: false,
            }));

            var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
            cursor.lineY.set("visible", false);

            var xRenderer = am5xy.AxisRendererX.new(root, {
                minGridDistance: 30
            });

            xRenderer.labels.template.setAll({
                rotation: -45,
                centerY: am5.p50,
                centerX: am5.p100,
                paddingRight: 15,
            });

            var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
                maxDeviation: 0.3,
                categoryField: "country",
                renderer: xRenderer,
                tooltip: am5.Tooltip.new(root, {})
            }));

            var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
                maxDeviation: 0.3,
                renderer: am5xy.AxisRendererY.new(root, {})
            }));

            var series = chart.series.push(am5xy.ColumnSeries.new(root, {
                name: "Series 1",
                xAxis: xAxis,
                yAxis: yAxis,
                valueYField: "value",
                sequencedInterpolation: true,
                categoryXField: "country",
                tooltip: am5.Tooltip.new(root, {
                    labelText: "{valueY} pengunjung"
                })
            }));

            series.columns.template.setAll({
                cornerRadiusTL: 5,
                cornerRadiusTR: 5,

                width: am5.percent(90),
                tooltipY: 0,
                tooltipText: "{valueY} aset",
                showTooltipOn: "always"
            });

            series.columns.template.setup = function(target) {
                target.set("tooltip", am5.Tooltip.new(root, {}));
            }

            series.columns.template.adapters.add("fill", function(fill, target) {
                return chart.get("colors").getIndex(series.columns.indexOf(target));
            });

            series.columns.template.adapters.add("stroke", function(stroke, target) {
                return chart.get("colors").getIndex(series.columns.indexOf(target));
            });

            var data = obj.data;
            xAxis.data.setAll(data);
            series.data.setAll(data);

            series.appear(1000);
            chart.appear(1000, 100);

        });
    }
</script>