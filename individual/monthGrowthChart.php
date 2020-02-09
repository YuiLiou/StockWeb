   $.ajax({         
        url: "info/monthGrowth.php",
        <?php
            if (empty($_GET))
                echo "data:{'company':'2330'},";
            else
                echo "data:{'company':'".$_GET['company']."'},"
        ?>        
        contentType: "application/json",
        dataType: "json",         
        success: function(response) {         
            var month=[], growth1=[], growth3=[], growth12=[];
            var length = response.length-1;
            var ctx = document.getElementById('monthGrowthChart').getContext("2d");
            for(var i=length; i>=0; i--) 
            {
                month.push(response[i]['month']);
                growth1.push(response[i]['growth1']);
                growth3.push(response[i]['growth3']);
                growth12.push(response[i]['growth12']);
            }            
            var chartdata = {
                labels: month,
                datasets: [{ 
                        label: '當月營收成長率',                 
                        lineTension: 0.1,
                        fill:false,
                        //hidden: true,
                        borderColor: '#00cc66',
                        backgroundColor: '#00cc66',
                        pointRadius: 5,
                        borderWidth: 5,
                        data: growth1,
                        //yAxisID: 'y-axis-1'
                    },{
                        label: '短期營收成長率',
                        fill:false,
                        //hidden: true,
                        lineTension: 0.1,
                        borderColor: '#312B73',
                        backgroundColor: '#312B73',
                        pointRadius: 5,
                        borderWidth: 5,
                        data:growth3,
                        //yAxisID: 'y-axis-2'
                    },{
                        label: '長期營收成長率',
                        fill:false,
                        lineTension: 0.1,
                        borderColor: '#99BD51',
                        backgroundColor: '#99BD51',
                        pointRadius: 5,
                        borderWidth: 5,
                        data:growth12,
                        //yAxisID: 'y-axis-2'
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
			    ticks: {
                                fontColor: 'black',
                                fontSize: '20'
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

