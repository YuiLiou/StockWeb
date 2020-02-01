   $.ajax({         
        url: "info/yearlyIncome.php",
        <?php
            if (empty($_GET))
                echo "data:{'company':'2330'},";
            else
                echo "data:{'company':'".$_GET['company']."'},"
        ?>        
        contentType: "application/json",
        dataType: "json",         
        success: function(response) {         
            var month = [], income = [], eps = [];
            var length = response.length-1;
            var ctx = document.getElementById('yearlyChart').getContext("2d");
            for(var i=length; i>=0; i--) 
            {
                month.push(response[i]['month']);
                income.push(response[i]['income']);
                eps.push(response[i]['eps']);
            }            
            var chartdata = {
                labels: month,
                datasets: [{ 
                        label: '年營收',                 
                        lineTension: 0.1,
                        fill:false,
                        borderColor: '#00cc66',
                        backgroundColor: '#00cc66',
                        pointRadius: 5,
                        borderWidth: 5,
                        data: income,
                        yAxisID: 'y-axis-1'
                    },{
                        label: '年EPS',
                        fill:false,
                        lineTension: 0.1,
                        borderColor: '#99BD51',
                        backgroundColor: '#99BD51',
                        pointRadius: 5,
                        borderWidth: 5,
                        data:eps,
                        yAxisID: 'y-axis-2'
                    }
                ],	                 
            };            
            var lineGraph = new Chart(ctx, {
                type: 'line',
                data: chartdata,
                options: {
	            legend: {
                        display: true,                        
                        labels: {
                            fontColor: 'black'
                        }
                    },
                    scales: {
                        yAxes: [{
			    type: 'linear',
                            display: true,
                            position: 'left',
                            id: 'y-axis-1',
                        }, {
			    type: 'linear',
                            display: true,
                            position: 'right',
                            id: 'y-axis-2',
                            // grid line settings
                            gridLines: {
                                drawOnChartArea: false, 
                            },
                        }], 
                        xAxes: [{
                            ticks: {
                                fontColor: 'black',
                                fontSize: '20'
                            },
                        }]
                    },
                    tooltips: {
                         mode: 'index',
                         intersect: false,
         	    }
                } 
            });
        },
        error: function(xhr, ajaxOptions, thrownError) {
            //alert(thrownError);
        }
    });

