   $.ajax({         
        url: "info/share_ratio.php",
        <?php
            if (empty($_GET))
                echo "data:{'company':'2330'},";
            else
                echo "data:{'company':'".$_GET['company']."'},"
        ?>        
        contentType: "application/json",
        dataType: "json",         
        success: function(response) {         
            var date=[], p_400=[], r_400=[], price=[];
            var length = response.length-1;
            var ctx = document.getElementById('shareRatioChart').getContext("2d");
            for(var i=length; i>=0; i--) 
            {
                date.push(response[i]['date']);
                p_400.push(response[i]['p_400']);
                r_400.push(response[i]['r_400']);
                price.push(response[i]['price']);
            }            
            var chartdata = {
                labels: date,
                datasets: [{ 
                        label: '股價',                 
                        lineTension: 0.1,
                        fill:false,
                        hidden: true,
                        borderColor: '#00cc66',
                        backgroundColor: '#00cc66',
                        pointRadius: 5,
                        borderWidth: 5,
                        data: price,
                        yAxisID: 'y-axis-1'
                    },{
                        label: '400張股東持股比例',
                        fill:false,
                        hidden: false,
                        lineTension: 0.1,
                        borderColor: '#312B73',
                        backgroundColor: '#312B73',
                        pointRadius: 5,
                        borderWidth: 5,
                        data:r_400,
                        yAxisID: 'y-axis-1'
                    },{
                        label: '400張股東人數',
                        fill:false,
                        hidden: true, 
                        lineTension: 0.1,
                        borderColor: '#99BD51',
                        backgroundColor: '#99BD51',
                        pointRadius: 5,
                        borderWidth: 5,
                        data:p_400,
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

