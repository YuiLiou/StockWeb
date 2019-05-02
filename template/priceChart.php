   $.ajax({
        url: "info/price.php",
        <?php
            if (empty($_GET))
                echo "data:{'company':'2330'},";
            else
                echo "data:{'company':'".$_GET['company']."'},"
        ?>        
        contentType: "application/json",
        dataType: "json",         
        success: function(response) {
            // collection
            var date = [];
            var price = [];
            for(var i=response.length-1;i>=0;i--) {
                date.push(response[i]['date']);
                price.push(response[i]['price']);
            }
            // draw graph
            var chartdata = {
                labels: date,
                datasets: [
                    {     
                        <?php 
                            if (empty($_GET))
                                echo "label:'2330',";
                            else  
                                echo "label:'".$_GET['company']."',";
                        ?>                     
                        fill: false,
                        lineTension: 0.1,
                        backgroundColor: 'red',
                        borderColor: 'rgb(255, 0, 0)',
                        pointRadius: 10,
                        borderWidth: 5,
                        data: price,
                    }
                ],	                 
            };
            var ctx = document.getElementById('myChart');
            var lineGraph = new Chart(ctx, {
                type: 'line',
                data: chartdata,
                // Configuration options go here          
                options: {
	            legend: {
                        display: true,                        
                        labels: {
                            fontColor: 'red',
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

