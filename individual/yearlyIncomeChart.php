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
            var month = [], income = [];
            var length = response.length-1;
            var ctx = document.getElementById('yearlyChart').getContext("2d");
            for(var i=length; i>=0; i--) 
            {
                month.push(response[i]['month']);
                income.push(response[i]['income']);
            }            
            var chartdata = {
                labels: month,
                datasets: [{ 
                        label: '年營收',                 
                        lineTension: 0.1,
                        fill:false,
                        borderColor: 'black',
                        backgroundColor: 'black',
                        pointRadius: 5,
                        borderWidth: 5,
                        data: income,
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

