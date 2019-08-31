   $.ajax({
        url: "info/pe.php",
        <?php
            if (empty($_GET))
                echo "data:{'company':'2330'},";
            else
                echo "data:{'company':'".$_GET['company']."'},"
        ?>        
        contentType: "application/json",
        dataType: "json",         
        success: function(response) {         
            var date = [], price = [], pe8 = [], pe12 = [], pe16 = [];
            var length = response.length-1;
            var ctx = document.getElementById('myChart').getContext("2d");
            for(var i=length; i>=0; i--) {
                date.push(response[i]['date']);
                price.push(response[i]['price']);
                pe8.push(response[i]['pe8']); 
                pe12.push(response[i]['pe12']); 
                pe16.push(response[i]['pe16']); 
            }            
            var chartdata = {
                labels: date,
                datasets: [{ 
                        label: '股價',                 
                        lineTension: 0.1,
                        fill:false,
                        borderColor: 'black',
                        backgroundColor: 'black',
                        pointRadius: 5,
                        borderWidth: 5,
                        data: price,
                    },{
                        label: '8倍',
                        fill:false,
                        lineTension: 0.1,
                        borderColor: '#00ff00',
                        backgroundColor: '#00ff00',
                        pointRadius: 1,
                        borderWidth: 5,
                        data:pe8
                    },{
                        label: '12倍',
                        fill:false,
                        lineTension: 0.1,
                        borderColor: '#ffff00',
                        backgroundColor: '#ffff00',
                        pointRadius: 1,
                        borderWidth: 5,
                        data:pe12
                    },{
                        label: '16倍',
                        fill:false,
                        lineTension: 0.1,
                        borderColor: '#ff0000',
                        backgroundColor: '#ff0000',
                        pointRadius: 1,
                        borderWidth: 5,
                        data:pe16
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

