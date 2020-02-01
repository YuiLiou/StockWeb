   $.ajax({
        url: "info/business.php",
        <?php
            if (empty($_GET))
                echo "data:{'company':'2330'},";
            else
                echo "data:{'company':'".$_GET['company']."'},"
        ?>        
        contentType: "application/json",
        dataType: "json",         
        success: function(response) {         
            var season = [], sale = [], manage = [], research = [], credit = [], total = [];
            var length = response.length-1;
            var ctx = document.getElementById('myChart').getContext("2d");
            for(var i=length; i>=0; i--) 
            {
                season.push(response[i]['season']);
                sale.push(response[i]['sale']); 
                manage.push(response[i]['manage']); 
                research.push(response[i]['research']); 
                credit.push(response[i]['credit']); 
                total.push(response[i]['total']); 
            }            
            var chartdata = {
                labels: season,
                datasets: [{ 
                        label: '推銷費用',                 
                        lineTension: 0.1,
                        fill:false,
                        borderColor: '#7441AA',
                        backgroundColor: '#7441AA',
                        pointRadius: 5,
                        borderWidth: 5,
                        data: sale,
                    },{
                        label: '管理費用',
                        fill:false,
                        lineTension: 0.1,
                        borderColor: '#99BD51',
                        backgroundColor: '#99BD51',
                        pointRadius: 5,
                        borderWidth: 5,
                        data:manage
                    },{
                        label: '研究發展費用',
                        fill:false,
                        lineTension: 0.1,
                        borderColor: '#00cc66',
                        backgroundColor: '#00cc66',
                        pointRadius: 5,
                        borderWidth: 5,
                        data:research
                    },{
                        label: '預期信用減損損失（利益）',
                        fill:false,
                        lineTension: 0.1,
                        borderColor: '#00ff00',
                        backgroundColor: '#00ff00',
                        pointRadius: 5,
                        borderWidth: 5,
                        data:credit
                    },{
                        label: '營業費用率',
                        fill:false,
                        lineTension: 0.1,
                        borderColor: '#ff6600',
                        backgroundColor: '#ff6600',
                        pointRadius: 1,
                        borderWidth: 5,
                        data:total
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

