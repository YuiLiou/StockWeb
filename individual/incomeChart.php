    $.ajax({
        url: "info/income.php",
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
            var season = [];
            var grossRate = [];
            var operatingRate = [];
            var beforeTaxRate = [];
            var afterTaxRate = [];
            for(var i in response) {
                season.push(response[i]['year'] + response[i]['season']);
                grossRate.push(response[i]['grossRate']);
                operatingRate.push(response[i]['operatingRate']);
                beforeTaxRate.push(response[i]['beforeTaxRate']);
                afterTaxRate.push(response[i]['afterTaxRate']);
            }
            // draw graph
            var chartdata = {
                labels: season,
                datasets: [
                    {    
                        label: '毛利率',                        
                        fill: false,                        
                        backgroundColor: '#7441AA',
                        borderColor: '#7441AA',
                        pointRadius: 10,
                        borderWidth: 5,
                        data: grossRate
                    },{    
                        label: '營業利益率',                        
                        fill: false,                        
                        backgroundColor: '#99BD51',
                        borderColor: '#99BD51',
                        pointRadius: 10,
                        borderWidth: 5,
                        data: operatingRate
                    },{    
                        label: '稅前淨利率',                        
                        fill: false,                        
                        backgroundColor: '#312B73',
                        borderColor: '#312B73',
                        pointRadius: 10,
                        borderWidth: 5,
                        data: beforeTaxRate
                    },{    
                        label: '稅後淨利率',                        
                        fill: false,                        
                        backgroundColor: '#0D2611',
                        borderColor: '#0D2611',
                        pointRadius: 10,
                        borderWidth: 5,
                        data: afterTaxRate
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
                        labels:{
                            
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
            alert(thrownError);
        }
    });

