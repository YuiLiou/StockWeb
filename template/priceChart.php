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
            var date = [];
            var price = [];
            var length = response.length-1;
            //-------------------- 由先而後塞入股價 --------------------
            for(var i=length; i>=0; i--) {
                date.push(response[i]['date']);
                price.push(response[i]['price']);
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
                datasets: [
                    {     
                        <?php 
                            if (empty($_GET))
                                echo "label:'2330',";
                            else  
                                echo "label:'".$_GET['company']."',";
                        ?>                     
                        fill: true,
                        lineTension: 0.1,
                        backgroundColor: gradientFill,
                        borderColor: trend,
                        pointRadius: 10,
                        borderWidth: 5,
                        data: price,
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
                            fontColor: trend,
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

