var amChartsChartsDemo = function () {
    var e = function () {
        AmCharts.makeChart("m_amcharts_1", {
            type: "serial",
            theme: "light",
            dataProvider: {},
            valueAxes: [{gridColor: "#FFFFFF", gridAlpha: .2, dashLength: 0}],
            gridAboveGraphs: !0,
            startDuration: 1,
            graphs: [{
                balloonText: "[[category]]: <b>[[value]]</b>",
                fillAlphas: .8,
                lineAlpha: .2,
                type: "column",
                valueField: "sales"
            }],
            chartCursor: {categoryBalloonEnabled: !1, cursorAlpha: 0, zoomable: !1},
            categoryField: "company",
            categoryAxis: {gridPosition: "start", gridAlpha: 0, tickPosition: "start", tickLength: 20},
            export: {enabled: !0}
        })
    }, a = function () {
        AmCharts.makeChart("m_amcharts_2", {
            type: "serial",
            addClassNames: !0,
            theme: "light",
            autoMargins: !1,
            marginLeft: 30,
            marginRight: 8,
            marginTop: 10,
            marginBottom: 26,
            balloon: {adjustBorderColor: !1, horizontalPadding: 10, verticalPadding: 8, color: "#ffffff"},
            dataProvider: [{year: 2009, income: 23.5, expenses: 21.1}, {
                year: 2010,
                income: 26.2,
                expenses: 30.5
            }, {year: 2011, income: 30.1, expenses: 34.9}, {year: 2012, income: 29.5, expenses: 31.1}, {
                year: 2013,
                income: 30.6,
                expenses: 28.2,
                dashLengthLine: 5
            }, {year: 2014, income: 34.1, expenses: 32.9, dashLengthColumn: 5, alpha: .2, additional: "(projection)"}],
            valueAxes: [{axisAlpha: 0, position: "left"}],
            startDuration: 1,
            graphs: [{
                alphaField: "alpha",
                balloonText: "<span style='font-size:12px;'>[[title]] in [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
                fillAlphas: 1,
                title: "Income",
                type: "column",
                valueField: "income",
                dashLengthField: "dashLengthColumn"
            }, {
                id: "graph2",
                balloonText: "<span style='font-size:12px;'>[[title]] in [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
                bullet: "round",
                lineThickness: 3,
                bulletSize: 7,
                bulletBorderAlpha: 1,
                bulletColor: "#FFFFFF",
                useLineColorForBulletBorder: !0,
                bulletBorderThickness: 3,
                fillAlphas: 0,
                lineAlpha: 1,
                title: "Expenses",
                valueField: "expenses",
                dashLengthField: "dashLengthLine"
            }],
            categoryField: "year",
            categoryAxis: {gridPosition: "start", axisAlpha: 0, tickLength: 0},
            export: {enabled: !0}
        })
    }, t = function () {
        AmCharts.makeChart("m_amcharts_3", {
            theme: "light",
            type: "serial",
            dataProvider: [{country: "USA", year2004: 3.5, year2005: 4.2}, {
                country: "UK",
                year2004: 1.7,
                year2005: 3.1
            }, {country: "Canada", year2004: 2.8, year2005: 2.9}, {
                country: "Japan",
                year2004: 2.6,
                year2005: 2.3
            }, {country: "France", year2004: 1.4, year2005: 2.1}, {country: "Brazil", year2004: 2.6, year2005: 4.9}],
            valueAxes: [{unit: "%", position: "left", title: "GDP growth rate"}],
            startDuration: 1,
            graphs: [{
                balloonText: "GDP grow in [[category]] (2004): <b>[[value]]</b>",
                fillAlphas: .9,
                lineAlpha: .2,
                title: "2004",
                type: "column",
                valueField: "year2004"
            }, {
                balloonText: "GDP grow in [[category]] (2005): <b>[[value]]</b>",
                fillAlphas: .9,
                lineAlpha: .2,
                title: "2005",
                type: "column",
                clustered: !1,
                columnWidth: .5,
                valueField: "year2005"
            }],
            plotAreaFillAlphas: .1,
            categoryField: "country",
            categoryAxis: {gridPosition: "start"},
            export: {enabled: !0}
        })
    }, i = function () {
        AmCharts.makeChart("m_amcharts_4", {
            theme: "light",
            type: "serial",
            dataProvider: [{country: "USA", year2004: 3.5, year2005: 4.2}, {
                country: "UK",
                year2004: 1.7,
                year2005: 3.1
            }, {country: "Canada", year2004: 2.8, year2005: 2.9}, {
                country: "Japan",
                year2004: 2.6,
                year2005: 2.3
            }, {country: "France", year2004: 1.4, year2005: 2.1}, {
                country: "Brazil",
                year2004: 2.6,
                year2005: 4.9
            }, {country: "Russia", year2004: 6.4, year2005: 7.2}, {
                country: "India",
                year2004: 8,
                year2005: 7.1
            }, {country: "China", year2004: 9.9, year2005: 10.1}],
            valueAxes: [{stackType: "3d", unit: "%", position: "left", title: "GDP growth rate"}],
            startDuration: 1,
            graphs: [{
                balloonText: "GDP grow in [[category]] (2004): <b>[[value]]</b>",
                fillAlphas: .9,
                lineAlpha: .2,
                title: "2004",
                type: "column",
                valueField: "year2004"
            }, {
                balloonText: "GDP grow in [[category]] (2005): <b>[[value]]</b>",
                fillAlphas: .9,
                lineAlpha: .2,
                title: "2005",
                type: "column",
                valueField: "year2005"
            }],
            plotAreaFillAlphas: .1,
            depth3D: 60,
            angle: 30,
            categoryField: "country",
            categoryAxis: {gridPosition: "start"},
            export: {enabled: !0}
        })
    }, r = function () {
        AmCharts.makeChart("m_amcharts_5", {
            type: "serial",
            theme: "light",
            handDrawn: !0,
            handDrawScatter: 3,
            legend: {useGraphSettings: !0, markerSize: 12, valueWidth: 0, verticalGap: 0},
            dataProvider: {},
            valueAxes: [{minorGridAlpha: .08, minorGridEnabled: !0, position: "top", axisAlpha: 0}],
            startDuration: 1,
            graphs: [{
                balloonText: "<span style='font-size:13px;'>[[title]] in [[category]]:<b>[[value]]</b></span>",
                title: "Total Sale",
                type: "column",
                fillAlphas: .8,
                valueField: "total_sale"
            }, {
                balloonText: "<span style='font-size:13px;'>[[title]] in [[category]]:<b>[[value]]</b></span>",
                bullet: "round",
                bulletBorderAlpha: 1,
                bulletColor: "#FFFFFF",
                useLineColorForBulletBorder: !0,
                fillAlphas: 0,
                lineThickness: 2,
                lineAlpha: 1,
                bulletSize: 7,
                title: "Total Revenue",
                valueField: "total_revenue"
            }],
            rotate: !0,
            categoryField: "company",
            categoryAxis: {gridPosition: "start"},
            export: {enabled: !0}
        })
    }, l = function () {
        function e() {
            a.zoomToIndexes(a.dataProvider.length - 40, a.dataProvider.length - 1)
        }

        var a = AmCharts.makeChart("m_amcharts_6", {
            type: "serial",
            theme: "light",
            marginRight: 40,
            marginLeft: 40,
            autoMarginOffset: 20,
            mouseWheelZoomEnabled: !0,
            dataDateFormat: "YYYY-MM-DD",
            valueAxes: [{id: "v1", axisAlpha: 0, position: "left", ignoreAxisWidth: !0}],
            balloon: {borderThickness: 1, shadowAlpha: 0},
            graphs: [{
                id: "g1",
                balloon: {drop: !0, adjustBorderColor: !1, color: "#ffffff"},
                bullet: "round",
                bulletBorderAlpha: 1,
                bulletColor: "#FFFFFF",
                bulletSize: 5,
                hideBulletsCount: 50,
                lineThickness: 2,
                title: "red line",
                useLineColorForBulletBorder: !0,
                valueField: "b_total",
                balloonText: "<span style='font-size:18px;'>[[value]]</span>"
            }],
            chartScrollbar: {
                graph: "g1",
                oppositeAxis: !1,
                offset: 30,
                scrollbarHeight: 80,
                backgroundAlpha: 0,
                selectedBackgroundAlpha: .1,
                selectedBackgroundColor: "#888888",
                graphFillAlpha: 0,
                graphLineAlpha: .5,
                selectedGraphFillAlpha: 0,
                selectedGraphLineAlpha: 1,
                autoGridCount: !0,
                color: "#AAAAAA"
            },
            chartCursor: {
                pan: !0,
                valueLineEnabled: !0,
                valueLineBalloonEnabled: !0,
                cursorAlpha: 1,
                cursorColor: "#258cbb",
                limitToGraph: "g1",
                valueLineAlpha: .2,
                valueZoomable: !0
            },
            valueScrollbar: {oppositeAxis: !1, offset: 50, scrollbarHeight: 10},
            categoryField: "b_date",
            categoryAxis: {parseDates: !0, dashLength: 1, minorGridEnabled: !0},
            export: {enabled: !0},
            dataProvider: dailyVisitors
        });
        a.addListener("rendered", e), e()
    }, s = function () {
        function e() {
            t.zoomToIndexes(a.length - 40, a.length - 1)
        }

        var a = function () {
            var e = [], a = new Date;
            a.setDate(a.getDate() - 5);
            for (var t = 0; t < 1e3; t++) {
                var i = new Date(a);
                i.setDate(i.getDate() + t);
                var r = Math.round(Math.random() * (40 + t / 5)) + 20 + t;
                e.push({date: i, visits: r})
            }
            return e
        }(), t = AmCharts.makeChart("m_amcharts_7", {
            type: "serial",
            theme: "light",
            marginRight: 80,
            autoMarginOffset: 20,
            marginTop: 7,
            dataProvider: a,
            valueAxes: [{axisAlpha: .2, dashLength: 1, position: "left"}],
            mouseWheelZoomEnabled: !0,
            graphs: [{
                id: "g1",
                balloonText: "[[value]]",
                bullet: "round",
                bulletBorderAlpha: 1,
                bulletColor: "#FFFFFF",
                hideBulletsCount: 50,
                title: "red line",
                valueField: "visits",
                useLineColorForBulletBorder: !0,
                balloon: {drop: !0}
            }],
            chartScrollbar: {autoGridCount: !0, graph: "g1", scrollbarHeight: 40},
            chartCursor: {limitToGraph: "g1"},
            categoryField: "date",
            categoryAxis: {parseDates: !0, axisColor: "#DADADA", dashLength: 1, minorGridEnabled: !0},
            export: {enabled: !0}
        });
        t.addListener("rendered", e), e()
    }, o = function () {
        AmCharts.makeChart("m_amcharts_8", {
            type: "serial",
            theme: "light",
            legend: {equalWidths: !1, useGraphSettings: !0, valueAlign: "left", valueWidth: 120},
            dataProvider: [{
                date: "2012-01-01",
                distance: 227,
                townName: "New York",
                townName2: "New York",
                townSize: 25,
                latitude: 40.71,
                duration: 408
            }, {
                date: "2012-01-02",
                distance: 371,
                townName: "Washington",
                townSize: 14,
                latitude: 38.89,
                duration: 482
            }, {
                date: "2012-01-03",
                distance: 433,
                townName: "Wilmington",
                townSize: 6,
                latitude: 34.22,
                duration: 562
            }, {
                date: "2012-01-04",
                distance: 345,
                townName: "Jacksonville",
                townSize: 7,
                latitude: 30.35,
                duration: 379
            }, {
                date: "2012-01-05",
                distance: 480,
                townName: "Miami",
                townName2: "Miami",
                townSize: 10,
                latitude: 25.83,
                duration: 501
            }, {
                date: "2012-01-06",
                distance: 386,
                townName: "Tallahassee",
                townSize: 7,
                latitude: 30.46,
                duration: 443
            }, {
                date: "2012-01-07",
                distance: 348,
                townName: "New Orleans",
                townSize: 10,
                latitude: 29.94,
                duration: 405
            }, {
                date: "2012-01-08",
                distance: 238,
                townName: "Houston",
                townName2: "Houston",
                townSize: 16,
                latitude: 29.76,
                duration: 309
            }, {
                date: "2012-01-09",
                distance: 218,
                townName: "Dalas",
                townSize: 17,
                latitude: 32.8,
                duration: 287
            }, {
                date: "2012-01-10",
                distance: 349,
                townName: "Oklahoma City",
                townSize: 11,
                latitude: 35.49,
                duration: 485
            }, {
                date: "2012-01-11",
                distance: 603,
                townName: "Kansas City",
                townSize: 10,
                latitude: 39.1,
                duration: 890
            }, {
                date: "2012-01-12",
                distance: 534,
                townName: "Denver",
                townName2: "Denver",
                townSize: 18,
                latitude: 39.74,
                duration: 810
            }, {
                date: "2012-01-13",
                townName: "Salt Lake City",
                townSize: 12,
                distance: 425,
                duration: 670,
                latitude: 40.75,
                dashLength: 8,
                alpha: .4
            }, {
                date: "2012-01-14",
                latitude: 36.1,
                duration: 470,
                townName: "Las Vegas",
                townName2: "Las Vegas"
            }, {date: "2012-01-15"}, {date: "2012-01-16"}, {date: "2012-01-17"}, {date: "2012-01-18"}, {date: "2012-01-19"}],
            valueAxes: [{
                id: "distanceAxis",
                axisAlpha: 0,
                gridAlpha: 0,
                position: "left",
                title: "distance"
            }, {
                id: "latitudeAxis",
                axisAlpha: 0,
                gridAlpha: 0,
                labelsEnabled: !1,
                position: "right"
            }, {
                id: "durationAxis",
                duration: "mm",
                durationUnits: {hh: "h ", mm: "min"},
                axisAlpha: 0,
                gridAlpha: 0,
                inside: !0,
                position: "right",
                title: "duration"
            }],
            graphs: [{
                alphaField: "alpha",
                balloonText: "[[value]] miles",
                dashLengthField: "dashLength",
                fillAlphas: .7,
                legendPeriodValueText: "total: [[value.sum]] mi",
                legendValueText: "[[value]] mi",
                title: "distance",
                type: "column",
                valueField: "distance",
                valueAxis: "distanceAxis"
            }, {
                balloonText: "latitude:[[value]]",
                bullet: "round",
                bulletBorderAlpha: 1,
                useLineColorForBulletBorder: !0,
                bulletColor: "#FFFFFF",
                bulletSizeField: "townSize",
                dashLengthField: "dashLength",
                descriptionField: "townName",
                labelPosition: "right",
                labelText: "[[townName2]]",
                legendValueText: "[[value]]/[[description]]",
                title: "latitude/city",
                fillAlphas: 0,
                valueField: "latitude",
                valueAxis: "latitudeAxis"
            }, {
                bullet: "square",
                bulletBorderAlpha: 1,
                bulletBorderThickness: 1,
                dashLengthField: "dashLength",
                legendValueText: "[[value]]",
                title: "duration",
                fillAlphas: 0,
                valueField: "duration",
                valueAxis: "durationAxis"
            }],
            chartCursor: {
                categoryBalloonDateFormat: "DD",
                cursorAlpha: .1,
                cursorColor: "#000000",
                fullWidth: !0,
                valueBalloonsEnabled: !1,
                zoomable: !1
            },
            dataDateFormat: "YYYY-MM-DD",
            categoryField: "date",
            categoryAxis: {
                dateFormats: [{period: "DD", format: "DD"}, {period: "WW", format: "MMM DD"}, {
                    period: "MM",
                    format: "MMM"
                }, {period: "YYYY", format: "YYYY"}],
                parseDates: !0,
                autoGridCount: !1,
                axisColor: "#555555",
                gridAlpha: .1,
                gridColor: "#FFFFFF",
                gridCount: 50
            },
            export: {enabled: !0}
        })
    }, n = function () {
        AmCharts.makeChart("m_amcharts_9", {
            type: "radar",
            theme: "light",
            dataProvider: [{country: "Czech Republic", litres: 156.9}, {
                country: "Ireland",
                litres: 131.1
            }, {country: "Germany", litres: 115.8}, {country: "Australia", litres: 109.9}, {
                country: "Austria",
                litres: 108.3
            }, {country: "UK", litres: 99}],
            valueAxes: [{axisTitleOffset: 20, minimum: 0, axisAlpha: .15}],
            startDuration: 2,
            graphs: [{
                balloonText: "[[value]] litres of beer per year",
                bullet: "round",
                lineThickness: 2,
                valueField: "litres"
            }],
            categoryField: "country",
            export: {enabled: !0}
        })
    }, u = function () {
        AmCharts.makeChart("m_amcharts_10", {
            type: "radar",
            theme: "light",
            dataProvider: [{direction: "N", value: 8}, {direction: "NE", value: 9}, {
                direction: "E",
                value: 4.5
            }, {direction: "SE", value: 3.5}, {direction: "S", value: 9.2}, {
                direction: "SW",
                value: 8.4
            }, {direction: "W", value: 11.1}, {direction: "NW", value: 10}],
            valueAxes: [{
                gridType: "circles",
                minimum: 0,
                autoGridCount: !1,
                axisAlpha: .2,
                fillAlpha: .05,
                fillColor: "#FFFFFF",
                gridAlpha: .08,
                guides: [{
                    angle: 225,
                    fillAlpha: .3,
                    fillColor: "#0066CC",
                    tickLength: 0,
                    toAngle: 315,
                    toValue: 14,
                    value: 0,
                    lineAlpha: 0
                }, {
                    angle: 45,
                    fillAlpha: .3,
                    fillColor: "#CC3333",
                    tickLength: 0,
                    toAngle: 135,
                    toValue: 14,
                    value: 0,
                    lineAlpha: 0
                }],
                position: "left"
            }],
            startDuration: 1,
            graphs: [{
                balloonText: "[[category]]: [[value]] m/s",
                bullet: "round",
                fillAlphas: .3,
                valueField: "value"
            }],
            categoryField: "direction",
            export: {enabled: !0}
        })
    }, d = function () {
        AmCharts.makeChart("m_amcharts_11", {
            type: "radar",
            theme: "light",
            dataProvider: [],
            valueAxes: [{gridType: "circles", minimum: 0}],
            startDuration: 1,
            polarScatter: {minimum: 0, maximum: 359, step: 1},
            legend: {position: "right"},
            graphs: [{
                title: "Trial #1",
                balloonText: "[[category]]: [[value]] m/s",
                bullet: "round",
                lineAlpha: 0,
                series: [[83, 5.1], [44, 5.8], [76, 9], [2, 1.4], [100, 8.3], [96, 1.7], [68, 3.9], [0, 3], [100, 4.1], [16, 5.5], [71, 6.8], [100, 7.9], [9, 6.8], [85, 8.3], [51, 6.7], [95, 3.8], [95, 4.4], [1, .2], [107, 9.7], [50, 4.2], [42, 9.2], [35, 8], [44, 6], [64, .7], [53, 3.3], [92, 4.1], [43, 7.3], [15, 7.5], [43, 4.3], [90, 9.9]]
            }, {
                title: "Trial #2",
                balloonText: "[[category]]: [[value]] m/s",
                bullet: "round",
                lineAlpha: 0,
                series: [[178, 1.3], [129, 3.4], [99, 2.4], [80, 9.9], [118, 9.4], [103, 8.7], [91, 4.2], [151, 1.2], [168, 5.2], [168, 1.6], [152, 1.2], [149, 3.4], [182, 8.8], [106, 6.7], [111, 9.2], [130, 6.3], [147, 2.9], [81, 8.1], [138, 7.7], [107, 3.9], [124, .7], [130, 2.6], [86, 9.2], [169, 7.5], [122, 9.9], [100, 3.8], [172, 4.1], [140, 7.3], [161, 2.3], [141, .9]]
            }, {
                title: "Trial #3",
                balloonText: "[[category]]: [[value]] m/s",
                bullet: "round",
                lineAlpha: 0,
                series: [[419, 4.9], [417, 5.5], [434, .1], [344, 2.5], [279, 7.5], [307, 8.4], [279, 9], [220, 8.4], [204, 8], [446, .9], [397, 8.9], [351, 1.7], [393, .7], [254, 1.8], [260, .4], [300, 3.5], [199, 2.7], [182, 5.8], [173, 2], [201, 9.7], [288, 1.2], [333, 7.4], [308, 1.9], [330, 8], [408, 1.7], [274, .8], [296, 3.1], [279, 4.3], [379, 5.6], [175, 6.8]]
            }],
            export: {enabled: !0}
        })
    }, c = function () {
        AmCharts.makeChart("m_amcharts_12", {
            type: "pie",
            theme: "light",
            dataProvider: countryWiseVisitors,
            valueField: "total_visitors",
            titleField: "b_country",
            balloon: {fixedPosition: !0},
            export: {enabled: !0}
        })
    },bv = function () {
        AmCharts.makeChart("m_amcharts_browser_12", {
            type: "pie",
            theme: "light",
            dataProvider: browserWiseVisitors,
            valueField: "total_visitors",
            titleField: "browser_name",
            balloon: {fixedPosition: !0},
            export: {enabled: !0}
        })
    }, v = function () {
        var e = {
            1995: [{sector: "Agriculture", size: 6.6}, {
                sector: "Mining and Quarrying",
                size: .6
            }, {sector: "Manufacturing", size: 23.2}, {sector: "Electricity and Water", size: 2.2}, {
                sector: "Construction",
                size: 4.5
            }, {sector: "Trade (Wholesale, Retail, Motor)", size: 14.6}, {
                sector: "Transport and Communication",
                size: 9.3
            }, {sector: "Finance, real estate and business services", size: 22.5}],
            1996: [{sector: "Agriculture", size: 6.4}, {
                sector: "Mining and Quarrying",
                size: .5
            }, {sector: "Manufacturing", size: 22.4}, {
                sector: "Electricity and Water",
                size: 2
            }, {sector: "Construction", size: 4.2}, {
                sector: "Trade (Wholesale, Retail, Motor)",
                size: 14.8
            }, {
                sector: "Transport and Communication",
                size: 9.7
            }, {sector: "Finance, real estate and business services", size: 22}],
            1997: [{sector: "Agriculture", size: 6.1}, {
                sector: "Mining and Quarrying",
                size: .2
            }, {sector: "Manufacturing", size: 20.9}, {
                sector: "Electricity and Water",
                size: 1.8
            }, {sector: "Construction", size: 4.2}, {
                sector: "Trade (Wholesale, Retail, Motor)",
                size: 13.7
            }, {
                sector: "Transport and Communication",
                size: 9.4
            }, {sector: "Finance, real estate and business services", size: 22.1}],
            1998: [{sector: "Agriculture", size: 6.2}, {
                sector: "Mining and Quarrying",
                size: .3
            }, {sector: "Manufacturing", size: 21.4}, {
                sector: "Electricity and Water",
                size: 1.9
            }, {sector: "Construction", size: 4.2}, {
                sector: "Trade (Wholesale, Retail, Motor)",
                size: 14.5
            }, {
                sector: "Transport and Communication",
                size: 10.6
            }, {sector: "Finance, real estate and business services", size: 23}],
            1999: [{sector: "Agriculture", size: 5.7}, {
                sector: "Mining and Quarrying",
                size: .2
            }, {sector: "Manufacturing", size: 20}, {
                sector: "Electricity and Water",
                size: 1.8
            }, {sector: "Construction", size: 4.4}, {
                sector: "Trade (Wholesale, Retail, Motor)",
                size: 15.2
            }, {
                sector: "Transport and Communication",
                size: 10.5
            }, {sector: "Finance, real estate and business services", size: 24.7}],
            2000: [{sector: "Agriculture", size: 5.1}, {
                sector: "Mining and Quarrying",
                size: .3
            }, {sector: "Manufacturing", size: 20.4}, {
                sector: "Electricity and Water",
                size: 1.7
            }, {sector: "Construction", size: 4}, {
                sector: "Trade (Wholesale, Retail, Motor)",
                size: 16.3
            }, {
                sector: "Transport and Communication",
                size: 10.7
            }, {sector: "Finance, real estate and business services", size: 24.6}],
            2001: [{sector: "Agriculture", size: 5.5}, {
                sector: "Mining and Quarrying",
                size: .2
            }, {sector: "Manufacturing", size: 20.3}, {
                sector: "Electricity and Water",
                size: 1.6
            }, {sector: "Construction", size: 3.1}, {
                sector: "Trade (Wholesale, Retail, Motor)",
                size: 16.3
            }, {
                sector: "Transport and Communication",
                size: 10.7
            }, {sector: "Finance, real estate and business services", size: 25.8}],
            2002: [{sector: "Agriculture", size: 5.7}, {
                sector: "Mining and Quarrying",
                size: .2
            }, {sector: "Manufacturing", size: 20.5}, {
                sector: "Electricity and Water",
                size: 1.6
            }, {sector: "Construction", size: 3.6}, {
                sector: "Trade (Wholesale, Retail, Motor)",
                size: 16.1
            }, {
                sector: "Transport and Communication",
                size: 10.7
            }, {sector: "Finance, real estate and business services", size: 26}],
            2003: [{sector: "Agriculture", size: 4.9}, {
                sector: "Mining and Quarrying",
                size: .2
            }, {sector: "Manufacturing", size: 19.4}, {
                sector: "Electricity and Water",
                size: 1.5
            }, {sector: "Construction", size: 3.3}, {
                sector: "Trade (Wholesale, Retail, Motor)",
                size: 16.2
            }, {sector: "Transport and Communication", size: 11}, {
                sector: "Finance, real estate and business services",
                size: 27.5
            }],
            2004: [{sector: "Agriculture", size: 4.7}, {
                sector: "Mining and Quarrying",
                size: .2
            }, {sector: "Manufacturing", size: 18.4}, {
                sector: "Electricity and Water",
                size: 1.4
            }, {sector: "Construction", size: 3.3}, {
                sector: "Trade (Wholesale, Retail, Motor)",
                size: 16.9
            }, {
                sector: "Transport and Communication",
                size: 10.6
            }, {sector: "Finance, real estate and business services", size: 28.1}],
            2005: [{sector: "Agriculture", size: 4.3}, {
                sector: "Mining and Quarrying",
                size: .2
            }, {sector: "Manufacturing", size: 18.1}, {
                sector: "Electricity and Water",
                size: 1.4
            }, {sector: "Construction", size: 3.9}, {
                sector: "Trade (Wholesale, Retail, Motor)",
                size: 15.7
            }, {
                sector: "Transport and Communication",
                size: 10.6
            }, {sector: "Finance, real estate and business services", size: 29.1}],
            2006: [{sector: "Agriculture", size: 4}, {
                sector: "Mining and Quarrying",
                size: .2
            }, {sector: "Manufacturing", size: 16.5}, {
                sector: "Electricity and Water",
                size: 1.3
            }, {sector: "Construction", size: 3.7}, {
                sector: "Trade (Wholesale, Retail, Motor)",
                size: 14.2
            }, {
                sector: "Transport and Communication",
                size: 12.1
            }, {sector: "Finance, real estate and business services", size: 29.1}],
            2007: [{sector: "Agriculture", size: 4.7}, {
                sector: "Mining and Quarrying",
                size: .2
            }, {sector: "Manufacturing", size: 16.2}, {
                sector: "Electricity and Water",
                size: 1.2
            }, {sector: "Construction", size: 4.1}, {
                sector: "Trade (Wholesale, Retail, Motor)",
                size: 15.6
            }, {
                sector: "Transport and Communication",
                size: 11.2
            }, {sector: "Finance, real estate and business services", size: 30.4}],
            2008: [{sector: "Agriculture", size: 4.9}, {
                sector: "Mining and Quarrying",
                size: .3
            }, {sector: "Manufacturing", size: 17.2}, {
                sector: "Electricity and Water",
                size: 1.4
            }, {sector: "Construction", size: 5.1}, {
                sector: "Trade (Wholesale, Retail, Motor)",
                size: 15.4
            }, {
                sector: "Transport and Communication",
                size: 11.1
            }, {sector: "Finance, real estate and business services", size: 28.4}],
            2009: [{sector: "Agriculture", size: 4.7}, {
                sector: "Mining and Quarrying",
                size: .3
            }, {sector: "Manufacturing", size: 16.4}, {
                sector: "Electricity and Water",
                size: 1.9
            }, {sector: "Construction", size: 4.9}, {
                sector: "Trade (Wholesale, Retail, Motor)",
                size: 15.5
            }, {
                sector: "Transport and Communication",
                size: 10.9
            }, {sector: "Finance, real estate and business services", size: 27.9}],
            2010: [{sector: "Agriculture", size: 4.2}, {
                sector: "Mining and Quarrying",
                size: .3
            }, {sector: "Manufacturing", size: 16.2}, {
                sector: "Electricity and Water",
                size: 2.2
            }, {sector: "Construction", size: 4.3}, {
                sector: "Trade (Wholesale, Retail, Motor)",
                size: 15.7
            }, {
                sector: "Transport and Communication",
                size: 10.2
            }, {sector: "Finance, real estate and business services", size: 28.8}],
            2011: [{sector: "Agriculture", size: 4.1}, {
                sector: "Mining and Quarrying",
                size: .3
            }, {sector: "Manufacturing", size: 14.9}, {
                sector: "Electricity and Water",
                size: 2.3
            }, {sector: "Construction", size: 5}, {
                sector: "Trade (Wholesale, Retail, Motor)",
                size: 17.3
            }, {
                sector: "Transport and Communication",
                size: 10.2
            }, {sector: "Finance, real estate and business services", size: 27.2}],
            2012: [{sector: "Agriculture", size: 3.8}, {
                sector: "Mining and Quarrying",
                size: .3
            }, {sector: "Manufacturing", size: 14.9}, {
                sector: "Electricity and Water",
                size: 2.6
            }, {sector: "Construction", size: 5.1}, {
                sector: "Trade (Wholesale, Retail, Motor)",
                size: 15.8
            }, {
                sector: "Transport and Communication",
                size: 10.7
            }, {sector: "Finance, real estate and business services", size: 28}],
            2013: [{sector: "Agriculture", size: 3.7}, {
                sector: "Mining and Quarrying",
                size: .2
            }, {sector: "Manufacturing", size: 14.9}, {
                sector: "Electricity and Water",
                size: 2.7
            }, {sector: "Construction", size: 5.7}, {
                sector: "Trade (Wholesale, Retail, Motor)",
                size: 16.5
            }, {
                sector: "Transport and Communication",
                size: 10.5
            }, {sector: "Finance, real estate and business services", size: 26.6}],
            2014: [{sector: "Agriculture", size: 3.9}, {
                sector: "Mining and Quarrying",
                size: .2
            }, {sector: "Manufacturing", size: 14.5}, {
                sector: "Electricity and Water",
                size: 2.7
            }, {sector: "Construction", size: 5.6}, {
                sector: "Trade (Wholesale, Retail, Motor)",
                size: 16.6
            }, {
                sector: "Transport and Communication",
                size: 10.5
            }, {sector: "Finance, real estate and business services", size: 26.5}]
        }, a = 1995;
        AmCharts.makeChart("m_amcharts_13", {
            type: "pie",
            theme: "light",
            dataProvider: [],
            valueField: "size",
            titleField: "sector",
            startDuration: 0,
            innerRadius: 80,
            pullOutRadius: 20,
            marginTop: 30,
            titles: [{text: "South African Economy"}],
            allLabels: [{y: "54%", align: "center", size: 25, bold: !0, text: "1995", color: "#555"}, {
                y: "49%",
                align: "center",
                size: 15,
                text: "Year",
                color: "#555"
            }],
            listeners: [{
                event: "init", method: function (t) {
                    function i() {
                        var t = e[a];
                        return ++a > 2014 && (a = 1995), t
                    }

                    function r() {
                        l.allLabels[0].text = a;
                        var e = i();
                        l.animateData(e, {
                            duration: 1e3, complete: function () {
                                setTimeout(r, 3e3)
                            }
                        })
                    }

                    var l = t.chart;
                    r()
                }
            }],
            export: {enabled: !0}
        })
    };
    return {
        init: function () {
            e(), a(), t(), i(), r(), l(), s(), o(), n(), u(), d(), c(), bv(), v()
        }
    }
}();
jQuery(document).ready(function () {
    amChartsChartsDemo.init()
});