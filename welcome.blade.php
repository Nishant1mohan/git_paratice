<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script type="text/javascript" src="https://cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script>
        <script type="text/javascript" src="https://cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js"></script>
    <script type="text/javascript">
        FusionCharts.ready(function(){
            var chartObj = new FusionCharts({
            type: 'maps/world',
            renderAt: 'chart-container',
            width: '600',
            height: '400',
            dataFormat: 'json',
            dataSource: {
                "chart": {
                    "caption": "User Performance",
                    "theme": "fusion"
                    // "formatNumberScale": "0",
                    // "numberSuffix": "M"
                },
                // "colorrange": {
                //     "color": [{
                //         "minvalue": "0",
                //         "maxvalue": "100",
                //         "code": "#D0DFA3",
                //         "displayValue": "< 100M"
                //     }, {
                //         "minvalue": "100",
                //         "maxvalue": "500",
                //         "code": "#B0BF92",
                //         "displayValue": "100-500M"
                //     }, {
                //         "minvalue": "500",
                //         "maxvalue": "1000",
                //         "code": "#91AF64",
                //         "displayValue": "500M-1B"
                //     }, {
                //         "minvalue": "1000",
                //         "maxvalue": "5000",
                //         "code": "#A9FF8D",
                //         "displayValue": "> 1B"
                //     }]
                // },
                
                "data": [
                {
                    "id": "NA",
                    "value": "515"
                }, 
                // {
                //     "id": "SA",
                //     "value": "373"
                // },
                 // {
                //     "id": "AS",
                //     "value": "3875"
                // }, {
                //     "id": "EU",
                //     "value": "727"
                // }, {
                //     "id": "AF",
                //     "value": "885"
                // }, {
                //     "id": "AU",
                //     "value": "32"
                // }
                ]
            }
        }
        );
            chartObj.render();
        });
    </script>
        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                /*display: flex;*/
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .tes{
                display: inline-flex;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <form action="{{ url('/article_save') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <h1>Import csv</h1>
                     <input type="file" name="file1">
                    <div class="select-image__btn">
                        <input class="si-btn" type="submit" value="Submit">
                    </div>
                </form>

                <div>
                    <div>
                        <h3>Timelapse</h3>
                        <div>
                            <label>1month</label>
                            <input type="radio" name="rd" value="1month" rel="1month" >
                        </div>
                        <div>
                            <label>3month</label>
                            <input type="radio" name="rd" value="3month" rel="3month" >
                        </div>
                        <div>
                            <label>6month</label>
                            <input type="radio" name="rd" value="6month" rel="6month" >
                        </div>
                        <div>
                            <label>1year</label>
                            <input type="radio" name="rd" value="1year" rel="1year" >
                        </div>
                    </div>
                    <h3 style="display: inline-flex;">
                        <label>Select Country</label>
                        <select class="country" name="country">
                            <option>Country</option>
                            @foreach($countries as $key => $value)
                                <option value="{{$value['country']}}" {{ Cookie::get('country') == $value['country'] ? 'selected' : '' }}>{{$value['country']}}</option>
                            @endforeach
                        </select>

                        <label>User Type</label>
                        <select class="user_type">
                            <option>User Type</option>
                            @foreach($user_type as $key => $value)
                                <option value="{{$value['user_type']}}" {{ Cookie::get('user_type') == $value['user_type'] ? 'selected' : '' }}>{{$value['user_type']}}</option>
                            @endforeach
                        </select>

                        <label>Sub User Type</label>
                        <select class="sub_user_types">
                            <option>Sub User Type</option>
                            @foreach($sub_user_type as $key => $value)
                                <option value="{{$value['sub_user_type']}}" {{ Cookie::get('sub_user_type') == $value['sub_user_type'] ? 'selected' : '' }}>{{$value['sub_user_type']}}</option>
                            @endforeach
                        </select>
                        <input type="button" class="sub" name="Submit" value="Submit">
                        
                    </h3>
                </div>
                
                <div id="chart_area" style="width: 1000px; height: 620px;"></div>

                <div id="piechart" style="width: 900px; height: 500px;"></div>

                <div id="piechart1" style="width: 900px; height: 500px;"></div>

                <div id="piechart3" style="width: 900px; height: 500px;"></div>
                <div class="tes">
                    <div>
                        <label>Better</label>
                        <input type="checkbox" id="better" name="better" value="better">
                    </div>

                    <div>
                        <label>Same</label>
                        <input type="checkbox" id="same" name="same" value="same">
                    </div>

                    <div>
                        <label>Worse</label>
                        <input type="checkbox" id="worse" name="worse" value="worse">
                    </div>
                </div>
                <div id="chart-container">FusionCharts XT will load here!</div>
            </div>
        </div>
    </body>
</html>


<script type="text/javascript">
     $(document).ready(function(){
        $('#same').on('click', function() {
        if ($('#same').is(":checked")){
            var same = $('#same').val();

            $.ajax({
            type:'get',
                  url:"{{url('/mapdata/')}}",
                  data : {same:same},
                    dataType:"JSON",
                    success:function(data)
            {
                // drawMonthwiseChart(data, temp_title);
                console.log(data);
            }
        });
        }
     });
    });
</script>

<script type="text/javascript">
     $(document).ready(function(){
        $('#worse').on('click', function() {
        if ($('#worse').is(":checked")){
            var worse = $('#worse').val();

            $.ajax({
            type:'get',
                  url:"{{url('/mapdata/')}}",
                  data : {worse:worse},
                    dataType:"JSON",
                    success:function(data)
            {
                // drawMonthwiseChart(data, temp_title);
                console.log(data);
            }
        });
        }
     });
    });
</script>


<script type="text/javascript">
     $(document).ready(function(){
        $('#better').on('click', function() {
        if ($('#better').is(":checked")){
            var better = $('#better').val();

            $.ajax({
            type:'get',
                  url:"{{url('/mapdata/')}}",
                  data : {better:better},
                    dataType:"JSON",
                    success:function(data)
            {
                // drawMonthwiseChart(data, temp_title);
                console.log(data);
            }
        });
        }
     });
    });
</script>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
    google.charts.load('current', {packages: ['corechart', 'bar']});
    google.charts.setOnLoadCallback();

    function load_monthwise_data(country,user_type,sub_user_type,radio, title)
    {
        var temp_title = title + ' '+country+' ' +user_type+' ' +sub_user_type+' ';
        $.ajax({
            type:'get',
                  url:"{{url('/chart_data/')}}",
                  data : {country:country,user_type:user_type,sub_user_type:sub_user_type,radio:radio},
            dataType:"JSON",
            success:function(data)
            {
                drawMonthwiseChart(data, temp_title);
            }
        });
    }

    function drawMonthwiseChart(chart_data, chart_main_title)
    {
        var jsonData = chart_data;
        console.log(jsonData);
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'country');
        data.addColumn('number', 'Usertype');
        for (var i = 0; i < jsonData.length; i++){
            var country = jsonData[i].date;
            var user_type = parseFloat($.trim(jsonData[i].number));
            var sub_user_type = jsonData[i].sub_user_type;
            data.addRows([[country, user_type]]);
        };
        var options = {
            title:"",
            hAxis: {
                title: chart_main_title
            },
            vAxis: {
                title: 'Usertype'
            }
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_area'));
        chart.draw(data, options);
    }

</script>




<script>
    
    $(document).ready(function(){

         $('.sub').on('click', function() {
            var country = $('.country').find("option:selected").val();
                var user_type = $('.user_type').find("option:selected").val();
                var sub_user_type = $('.sub_user_types').find("option:selected").val();
                var radio = $("input[type='radio']:checked").val();
                // alert(radio);
            if(country != '')
            {
                load_monthwise_data(country,user_type,sub_user_type,radio, 'country wise data');
            }
        });

    });

</script>




<script type="text/javascript">
    $(document).ready(function() {
            $('#cha').on('change', function() {

            var selectedText = $(this).find("option:selected").text();
            if(selectedText == "None"){
                $('#piechart1').hide();
                $('#piechart3').hide();
                $('#piechart').hide();
            }
            })
        })
</script>


<script type="text/javascript">
    $(document).ready(function() {
        $('#cha').on('change', function() {
            var selectedText = $(this).find("option:selected").text();
            if(selectedText == "Country"){
                $('#piechart1').hide();
                $('#piechart3').hide();
                 $('#piechart').show();
            var analytics = <?php echo $all; ?>;
              google.charts.load('current', {'packages':['corechart']}
                );
              google.charts.setOnLoadCallback(drawChart);

              function drawChart() {
                
                // alert(all);
                var data = google.visualization.arrayToDataTable(analytics);

                var options = {
                  title: 'Users By country'
                };

                var chart = new google.visualization.PieChart(document.getElementById('piechart'));

                chart.draw(data, options);
            }}
        })
    })
</script>


    <script type="text/javascript">
        $(document).ready(function() {
            $('#cha').on('change', function() {

            var selectedText = $(this).find("option:selected").text();
            if(selectedText == "User Type"){

                $('#piechart').hide();
                $('#piechart3').hide();
                 $('#piechart1').show();
        var analytics1 = <?php echo $type1; ?>;
      google.charts.load("current", {packages:["corechart"]}
        );
      google.charts.setOnLoadCallback(drawChart1);
      function drawChart1() {
        var data = google.visualization.arrayToDataTable(analytics1);

        var options = {
          title: 'User Types',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart1'));
        chart.draw(data, options);
      }}
  })
        })
    </script>


<script type="text/javascript">
    $(document).ready(function() {
        $('#cha').on('change', function() {

            var selectedText = $(this).find("option:selected").text();
            if(selectedText == "Sub User Type"){

                $('#piechart').hide();
                $('#piechart1').hide();
                $('#piechart3').show();
                var analytics2 = <?php echo $sub_type; ?>;
                google.charts.load("current", {packages:["corechart"]}
                );
                google.charts.setOnLoadCallback(drawChart2);
              function drawChart2() {
                var data = google.visualization.arrayToDataTable(analytics2);

                var options = {
                  title: 'Sub User Types',
                  is3D: true,
                };

                var chart = new google.visualization.PieChart(document.getElementById('piechart3'));
                chart.draw(data, options);
              } 
            }
        })
    })
</script>


