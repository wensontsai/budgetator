<?php
/*** begin our session ***/
session_start();

/*** set a form token ***/
$form_token = md5( uniqid('auth', true) );

/*** set the session form token ***/
$form_token = $_SESSION['form_token'];

require('functions/D3_functions.php');


?>

<!DOCTYPE HTML>
<html ng-app="app">
<head>
<title>PHPRO Login</title>
    <meta charset="utf-8">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/application.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

    <body>
      <div class="container">
          <nav class="navbar navbar-default" role="navigation">
            <div class="container-fluid">
              <!-- Brand and toggle get grouped for better mobile display -->
              <div class="navbar-header">
                <a class="navbar-brand nav_change" href="#">Budgetator</a>
              </div>

              <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                  <li><a class="nav_change" href="#dashboard">Dashboard</a></li>
                  <li><a class="nav_change" href="#addexpense">Add Expenses</a></li>
<!--                   <li><a class="nav_change" href="#addincome">Add Income</a></li>
 -->
                  <?php if ($_SESSION['user_id']){  ?>
                    <li><a href="/budgetator/public/logout.php">Logout</a></li>
                  <?php } ?>

                <li id="update_message">
                    <?php if ($_SESSION['update_message']){  ?>
                        <?php echo $_SESSION['update_message'] ?><br>
                    <?php } unset($_SESSION['update_message']); ?>
                </li>

                </ul>
              </div><!-- /.navbar-collapse -->

            </div>
          </nav><!--nav end -->

        <div id="view" ng-view>  <!--errythin angular here -->




        </div><!-- end angular div -->

    </div><!--end container, bootstrap -->

      <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
      <script src="js/angular.min.js"></script>
      <script src="js/angular-route.js"></script>
      <script src="js/custom.js"></script>
      <script src="js/app.js"></script>
      <script src="http://d3js.org/d3.v3.min.js"></script>

<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>

<script>

  var user_id = "<?php echo $_SESSION['user_id'] ?>";
    $(document).ready(function(){

        $('.nav_change').click(function(){
          $('#update_message').html('');
          runD3();
        });

    });

    // D3 stuff
    function runD3 (){
        var svg = d3.select("#D3_piechart")
          .append("svg")
          .append("g")
          .data(dataset)
          .enter()

        svg.append("g")
          .attr("class", "slices");
        svg.append("g")
          .attr("class", "labels");
        svg.append("g")
          .attr("class", "lines");

        var width = 350,
            height = 250,
            radius = Math.min(width, height) / 2,
            dataset = [1,5,12,25,34];

        var pie = d3.layout.pie()
          .sort(null)
          .value(function(d) {
            return d.value;
          });

        var arc = d3.svg.arc()
          .outerRadius(radius * 0.8)
          .innerRadius(radius * 0.4);

        var outerArc = d3.svg.arc()
          .innerRadius(radius * 0.9)
          .outerRadius(radius * 0.9);


        svg.attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

        var key = function(d){ return d.data.label; };

        var color = d3.scale.ordinal()
          .domain([{"label":"one", "value":20},
                    {"label":"two", "value":50},
                    {"label":"three", "value":30}])
          .range(["#98abc5", "#8a89a6", "#7b6888", "#6b486b", "#a05d56", "#d0743c", "#ff8c00"]);



        function actualData (data){
          var labels = color.domain();
          return labels.map(function(label){
            return {
              label: label,
              value: value }
          });
        }




        function randomData (){
          var labels = color.domain();
          return labels.map(function(label){
            return { label: label, value: Math.random() }
          });
        }


        change(randomData());

        d3.select(".randomize")
          .on("click", function(){
            change(randomData());
          });

        d3.select("#april")
          .on("click", function(){
            change(actualData());
          });


        function change(data) {

          /* ------- PIE SLICES -------*/
          var slice = svg.select(".slices").selectAll("path.slice")
            .data(pie(data), key);

          slice.enter()
            .insert("path")
            .style("fill", function(d) { return color(d.data.label); })
            .attr("class", "slice");

          slice
            .transition().duration(1000)
            .attrTween("d", function(d) {
              this._current = this._current || d;
              var interpolate = d3.interpolate(this._current, d);
              this._current = interpolate(0);
              return function(t) {
                return arc(interpolate(t));
              };
            })

          slice.exit()
            .remove();

          /* ------- TEXT LABELS -------*/

          var text = svg.select(".labels").selectAll("text")
            .data(pie(data), key);

          text.enter()
            .append("text")
            .attr("dy", ".35em")
            .text(function(d) {
              return d.data.label;
            });

          function midAngle(d){
            return d.startAngle + (d.endAngle - d.startAngle)/2;
          }

          text.transition().duration(1000)
            .attrTween("transform", function(d) {
              this._current = this._current || d;
              var interpolate = d3.interpolate(this._current, d);
              this._current = interpolate(0);
              return function(t) {
                var d2 = interpolate(t);
                var pos = outerArc.centroid(d2);
                pos[0] = radius * (midAngle(d2) < Math.PI ? 1 : -1);
                return "translate("+ pos +")";
              };
            })
            .styleTween("text-anchor", function(d){
              this._current = this._current || d;
              var interpolate = d3.interpolate(this._current, d);
              this._current = interpolate(0);
              return function(t) {
                var d2 = interpolate(t);
                return midAngle(d2) < Math.PI ? "start":"end";
              };
            });

          text.exit()
            .remove();

          /* ------- SLICE TO TEXT POLYLINES -------*/

          var polyline = svg.select(".lines").selectAll("polyline")
            .data(pie(data), key);

          polyline.enter()
            .append("polyline");

          polyline.transition().duration(1000)
            .attrTween("points", function(d){
              this._current = this._current || d;
              var interpolate = d3.interpolate(this._current, d);
              this._current = interpolate(0);
              return function(t) {
                var d2 = interpolate(t);
                var pos = outerArc.centroid(d2);
                pos[0] = radius * 0.95 * (midAngle(d2) < Math.PI ? 1 : -1);
                return [arc.centroid(d2), outerArc.centroid(d2), pos];
              };
            });

          polyline.exit()
            .remove();
        };
      }




      //more d3
      function runD50(){
var cScale = d3.scale.linear().domain([0, 100]).range([0, 2 * Math.PI]);

data = [[0,50,"#AA8888"], [50,75,"#88BB88"], [75,100,"#8888CC"]]

var vis = d3.select("#svg_donut");

var arc = d3.svg.arc()
.innerRadius(50)
.outerRadius(100)
.startAngle(function(d){return cScale(d[0]);})
.endAngle(function(d){return cScale(d[1]);});

vis.selectAll("path")
.data(data)
.enter()
.append("path")
.attr("d", arc)
.style("fill", function(d){return d[2];})
.attr("transform", "translate(300,200)");
}




// even more d3

function runD74(){
   var w = 300,                        //width
    h = 300,                            //height
    r = 100,                            //radius
    color = d3.scale.ordinal()
          .range(["#98abc5", "#8a89a6", "#7b6888", "#6b486b", "#a05d56", "#d0743c", "#ff8c00"]);    //builtin range of colors

    data = <?php echo $expenses_graph_json_clean ?>

            // [{"label":"food","value":"100.00"},
            // {"label":"unique","value":"200.00"},
            // {"label":"clothing","value":"500.00"}]




            // [{"label":"one", "value":"1"},
            // {"label":"redfish", "value":"2"},
            // {"label":"blufish", "value":"2"},
            // {"label":"octopi", "value":"2"},
            // {"label":"salmon", "value":"2"},
            // {"label":"three", "value":"3"}];


    var vis = d3.select("#svg2")
        .append("svg:svg")              //create the SVG element inside the <body>
        .data([data])                   //associate our data with the document
            .attr("width", w)           //set the width and height of our visualization (these will be attributes of the <svg> tag
            .attr("height", h)
            .append("svg:g")                //make a group to hold our pie chart
            .attr("transform", "translate(" + r + "," + r + ")")    //move the center of the pie chart from 0, 0 to radius, radius

    var arc = d3.svg.arc()              //this will create <path> elements for us using arc data
        .outerRadius(r);

    var pie = d3.layout.pie()           //this will create arc data for us given a list of values
        .value(function(d) { return d.value; });    //we must tell it out to access the value of each element in our data array

    var arcs = vis.selectAll("g.slice")     //this selects all <g> elements with class slice (there aren't any yet)
        .data(pie)                          //associate the generated pie data (an array of arcs, each having startAngle, endAngle and value properties)
        .enter()                            //this will create <g> elements for every "extra" data element that should be associated with a selection. The result is creating a <g> for every object in the data array
            .append("svg:g")                //create a group to hold each slice (we will have a <path> and a <text> element associated with each slice)
                .attr("class", "slice");    //allow us to style things in the slices (like text)

        arcs.append("svg:path")
                .attr("fill", function(d, i) { return color(i); } ) //set the color for each slice to be chosen from the color function defined above
                .attr("d", arc);                                    //this creates the actual SVG path using the associated data (pie) with the arc drawing function

        arcs.append("svg:text")                                     //add a label to each slice
                .attr("transform", function(d) {                    //set the label's origin to the center of the arc
                //we have to make sure to set these before calling arc.centroid
                d.innerRadius = 50;
                d.outerRadius = r;
                return "translate(" + arc.centroid(d) + ")";        //this gives us a pair of coordinates like [50, 50]
            })
            .attr("text-anchor", "middle")                          //center the text on it's origin
            .text(function(d, i) { return data[i].label; });        //get the label from our original data array
}
</script>

    </body>

</html>

