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
            var date = [], price = [], ma5 = [], ma20 = [], ma60 = [];
            var length = response.length-1;
            //-------------------- 由先而後塞入股價 --------------------
            for(var i=length; i>=0; i--) {
                date.push(response[i]['date']);
                price.push(response[i]['price']);
                ma5.push(response[i]['ma5']); 
                ma20.push(response[i]['ma20']); 
                ma60.push(response[i]['ma60']); 
            }
            //-------------------- 設定折線圖顏色 --------------------
            var ctx = document.getElementById('myChart').getContext("2d");                        
            var gradientFill = ctx.createLinearGradient(0, 0, 0, 700);   
            var trend = "rgba(128,128,128,0.8)";
            //-------------------- 下跌 -----------------------------
            if (parseFloat(price[0]) > parseFloat(price[length])){
                gradientFill.addColorStop(0, "rgba(0, 255, 0, 0.8)");
                gradientFill.addColorStop(1, "rgba(0, 255, 0, 0.2)");                
                trend = "rgba(0,255,0,0.8)";
            }
            //-------------------- 上漲 -------------------------------
            else if (parseFloat(price[0]) < parseFloat(price[length])){
                gradientFill.addColorStop(0, "rgba(255, 0, 0, 0.8)");
                gradientFill.addColorStop(1, "rgba(255, 0, 0, 0.2)");
                trend = "rgba(255,0,0,0.8)";
            }
            //-------------------- 持平 -------------------------------
            else{
                gradientFill.addColorStop(0, "rgba(128, 128, 128, 0.8)");
                gradientFill.addColorStop(1, "rgba(128, 128, 128, 0.2)");
            }
            //-------------------------------------------------
            var chartdata = {
                labels: date,
                datasets: [{ 
                        label: 'price',                 
                        fill: true,
                        lineTension: 0.1,
                        backgroundColor: gradientFill,
                        borderColor: trend,
                        pointRadius: 10,
                        borderWidth: 5,
                        data: price,
                    },{
                        label: '週線',
                        fill:false,
                        lineTension: 0.1,
                        borderColor: '#6666FF',
                        pointRadius: 1,
                        borderWidth: 5,
                        data:ma5
                    },{
                        label: '月線',
                        fill:false,
                        lineTension: 0.1,
                        borderColor: '#4C0099',
                        pointRadius: 1,
                        borderWidth: 5,
                        data:ma20
                    },{
                        label: '季線',
                        fill:false,
                        lineTension: 0.1,
                        borderColor: '#202020',
                        pointRadius: 1,
                        borderWidth: 5,
                        data:ma60
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

