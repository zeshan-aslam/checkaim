var Dashboard = window.Dashboard || {}

Dashboard.DailyChartData = null;
Dashboard.MonthlyChartData = null;
Dashboard.YearlyChartData = null;

Dashboard.Common = function () {
    return {

        Init: function () {

        	function am4themes_myTheme(target) {
			  if (target instanceof am4core.ColorSet) {
			    target.list = [
			      am4core.color("#2278BF"),
			      am4core.color("#EAC435"),
			      am4core.color("#C1292E"),
			      
			    ];
			  }
			}

        	am4core.ready(function() {

				// Themes begin
				am4core.useTheme(am4themes_myTheme);
				// Themes end
				//1BE7FF 6EEB83 E4FF1A FFB800 FF5714

				//29BF12 ABFF4F 08BDBD F21B3F FF9914

				//F6511D FFB400 00A6ED 7FB800 0D2C54

				Dashboard.Common.InitDailyChart();
        		Dashboard.Common.InitMonthlyChart();
        		Dashboard.Common.InitYearlyChart();


			}); // end am4core.ready()


        		

        },
        InitDailyChart: function(){
        	
        	var hasData = false;

        	for(var x in Dashboard.DailyChartData)
        	{
        		if(Dashboard.DailyChartData[x].value > 0)
        		{
        			hasData = true;
        		}
        	}

        	if(hasData)
        	{
	        	var chart = am4core.create("divDailyChart", am4charts.PieChart);

				// Add data
				chart.data = Dashboard.DailyChartData;
				 chart.labelsEnabled = false;
            chart.autoMargins = false;
            chart.marginTop = -20;
            chart.marginBottom = -20;
            chart.marginLeft = -20;
            chart.marginRight = -20;
            chart.pullOutRadius = 0;

				// Add and configure Series
				var pieSeries = chart.series.push(new am4charts.PieSeries());
				pieSeries.dataFields.value = "value";
				pieSeries.dataFields.category = "key";
				pieSeries.slices.template.stroke = am4core.color("#fff");
				pieSeries.slices.template.strokeWidth = 2;
				pieSeries.slices.template.strokeOpacity = 1;

				// This creates initial animation
				pieSeries.hiddenState.properties.opacity = 1;
				pieSeries.hiddenState.properties.endAngle = -120;
				pieSeries.hiddenState.properties.startAngle = -120;

				pieSeries.labels.template.fontSize = 10;

				//pieSeries.ticks.template.radius = 10;
				//pieSeries.alignLabels = false;
				//pieSeries.labels.template.radius = am4core.percent(-10);
				//pieSeries.labels.template.relativeRotation = 90;
				pieSeries.labels.template.disabled = true;

				//pieSeries.labels.template.maxWidth = 100;
				//pieSeries.labels.template.wrap = true;

				
			}
			else
			{
				$("#divDailyChart").css("text-align","center");
				$("#divDailyChart").html("<img src='images/nodataavailable.png' />")
			}

        },
        InitMonthlyChart: function(){

        	var chart = am4core.create("divMonthlyChart", am4charts.XYChart);

			chart.data = Dashboard.MonthlyChartData;

			chart.dateFormatter.inputDateFormat = "yyyy-MM-dd";
			var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
			dateAxis.renderer.minGridDistance = 60;
			dateAxis.startLocation = 0.5;
			dateAxis.endLocation = 0.5;
			dateAxis.baseInterval = {
			  timeUnit: "day",
			  count: 1
			}

			var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
			valueAxis.tooltip.disabled = true;

			
			var series = chart.series.push(new am4charts.LineSeries());
			series.dataFields.dateX = "date";
			series.name = "reports";
			series.dataFields.valueY = "reports";
			series.tooltipHTML = " <span style='font-size:14px; color:#000000;'>Reports <b>{valueY.value}</b></span>";
			series.tooltipText = "[#000]{valueY.value}[/]";
			
			series.tooltip.getStrokeFromObject = true;
			series.tooltip.background.strokeWidth = 3;
			series.tooltip.getFillFromObject = false;
			series.fillOpacity = 0.6;
			series.strokeWidth = 2;
			series.stacked = true;
			series.stroke = am4core.color("#C1292E");
			series.fill = am4core.color("#C1292E");

			var series2 = chart.series.push(new am4charts.LineSeries());
			series2.name = "alerts";
			series2.dataFields.dateX = "date";
			series2.dataFields.valueY = "alerts";
			series2.tooltipHTML = " <span style='font-size:14px; color:#000000;'>Alerts <b>{valueY.value}</b></span>";
			series2.tooltipText = "[#000]{valueY.value}[/]";
			
			series2.tooltip.getFillFromObject = false;
			series2.tooltip.getStrokeFromObject = true;
			series2.tooltip.background.strokeWidth = 3;
			series2.sequencedInterpolation = true;
			series2.fillOpacity = 0.6;
			series2.stacked = true;
			series2.strokeWidth = 2;
			series2.stroke = am4core.color("#EAC435");
			series2.fill = am4core.color("#EAC435");

			

			var series3 = chart.series.push(new am4charts.LineSeries());
			series3.name = "transactions";
			series3.dataFields.dateX = "date";
			series3.dataFields.valueY = "transactions";
			series3.tooltipHTML = " <span style='font-size:14px; color:#000000;'>Transactions <b>{valueY.value}</b></span>";
			series3.tooltipText = "[#000]{valueY.value}[/]";
			
			series3.tooltip.getFillFromObject = false;
			series3.tooltip.getStrokeFromObject = true;
			series3.tooltip.background.strokeWidth = 3;
			series3.sequencedInterpolation = true;
			series3.fillOpacity = 0.6;
			series3.defaultState.transitionDuration = 1000;
			series3.stacked = true;
			series3.strokeWidth = 2;

			series3.stroke = am4core.color("#2278BF");
			series3.fill = am4core.color("#2278BF");
			

			chart.cursor = new am4charts.XYCursor();
			chart.cursor.xAxis = dateAxis;
			chart.scrollbarX = new am4core.Scrollbar();

			// Add a legend
			//chart.legend = new am4charts.Legend();
			//chart.legend.position = "bottom";

        },
        InitYearlyChart: function(){

        	var chart = am4core.create('divYearlyChart', am4charts.XYChart)
			chart.colors.step = 2;

			//chart.legend = new am4charts.Legend()
			//chart.legend.position = 'top'
			//chart.legend.paddingBottom = 20
			//chart.legend.labels.template.maxWidth = 95

			var xAxis = chart.xAxes.push(new am4charts.CategoryAxis())
			xAxis.dataFields.category = 'monthyear'
			xAxis.renderer.cellStartLocation = 0.1
			xAxis.renderer.cellEndLocation = 0.9
			xAxis.renderer.grid.template.location = 0;

			var yAxis = chart.yAxes.push(new am4charts.ValueAxis());
			yAxis.min = 0;

			function createSeries(value, name, color) {
			    var series = chart.series.push(new am4charts.ColumnSeries())
			    series.dataFields.valueY = value
			    series.dataFields.categoryX = 'monthyear'
			    series.name = name
			    series.stroke = am4core.color(color);
				series.fill = am4core.color(color);

			    series.events.on("hidden", arrangeColumns);
			    series.events.on("shown", arrangeColumns);

			    var bullet = series.bullets.push(new am4charts.LabelBullet())
			    bullet.interactionsEnabled = false
			    bullet.dy = 30;
			    bullet.label.text = '{valueY}'
			    bullet.label.fill = am4core.color('#ffffff')

			    return series;
			}

			chart.data = Dashboard.YearlyChartData;


			createSeries('transactions', 'Transactions', "#2278BF");
			createSeries('alerts', 'Alerts',"#EAC435");

			function arrangeColumns() {

			    var series = chart.series.getIndex(0);

			    var w = 1 - xAxis.renderer.cellStartLocation - (1 - xAxis.renderer.cellEndLocation);
			    if (series.dataItems.length > 1) {
			        var x0 = xAxis.getX(series.dataItems.getIndex(0), "categoryX");
			        var x1 = xAxis.getX(series.dataItems.getIndex(1), "categoryX");
			        var delta = ((x1 - x0) / chart.series.length) * w;
			        if (am4core.isNumber(delta)) {
			            var middle = chart.series.length / 2;

			            var newIndex = 0;
			            chart.series.each(function(series) {
			                if (!series.isHidden && !series.isHiding) {
			                    series.dummyData = newIndex;
			                    newIndex++;
			                }
			                else {
			                    series.dummyData = chart.series.indexOf(series);
			                }
			            })
			            var visibleCount = newIndex;
			            var newMiddle = visibleCount / 2;

			            chart.series.each(function(series) {
			                var trueIndex = chart.series.indexOf(series);
			                var newIndex = series.dummyData;

			                var dx = (newIndex - trueIndex + middle - newMiddle) * delta

			                series.animate({ property: "dx", to: dx }, series.interpolationDuration, series.interpolationEasing);
			                series.bulletsContainer.animate({ property: "dx", to: dx }, series.interpolationDuration, series.interpolationEasing);
			            })
			        }
			    }
			}

        }

       
    }
}();