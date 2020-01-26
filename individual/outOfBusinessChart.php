   $.ajax({
        url: "info/outOfBusiness.php",
        <?php
            if (empty($_GET))
                echo "data:{'company':'2330'},";
            else
                echo "data:{'company':'".$_GET['company']."'},"
        ?>        
        contentType: "application/json",
        dataType: "json",         
        success: function(response) {         
            var season = [], a = [], b = [], c = [], d = [], e = [];
            var length = response.length-1;
            var ctx = document.getElementById('outOfBusinessChart').getContext("2d");
            for(var i=length; i>=0; i--) 
            {
                a.push(response[i]['a']);
                b.push(response[i]['b']); 
                c.push(response[i]['c']); 
                d.push(response[i]['d']); 
                e.push(response[i]['e']); 
                season.push(response[i]['season']); 
            }            
            var chartdata = {
                labels: season,
                datasets: [{ 
                        label: '其他收入',                 
                        lineTension: 0.1,
                        fill:false,
                        borderColor: 'black',
                        backgroundColor: 'black',
                        pointRadius: 5,
                        borderWidth: 5,
                        data: a,
                    },{
                        label: '其他利益及損失淨額',
                        fill:false,
                        lineTension: 0.1,
                        borderColor: '#00ff00',
                        backgroundColor: '#00ff00',
                        pointRadius: 1,
                        borderWidth: 5,
                        data: b
                    },{
                        label: '財務成本淨額',
                        fill:false,
                        lineTension: 0.1,
                        borderColor: '#00cc66',
                        backgroundColor: '#00cc66',
                        pointRadius: 1,
                        borderWidth: 5,
                        data: c
                    },{
                        label: '採用權益法認列之關聯企業及合資損益之份額淨額',
                        fill:false,
                        lineTension: 0.1,
                        borderColor: '#ffff00',
                        backgroundColor: '#ffff00',
                        pointRadius: 1,
                        borderWidth: 5,
                        data: d
                    },{
                        label: '營業外收入及支出合計',
                        fill:false,
                        lineTension: 0.1,
                        borderColor: '#ff6600',
                        backgroundColor: '#ff6600',
                        pointRadius: 1,
                        borderWidth: 5,
                        data: e
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

