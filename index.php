<html>
<head>
</head>
<body>
<figure class="highcharts-figure">
  <div id="container"></div>
  <p class="highcharts-description">
    This force directed graph shows an example of a network graph, where
    the nodes represent languages and the language families they belong to.
    The nodes can be dragged around and will be repositioned dynamically.
    Network graphs are typically used to show relations in data. In this
    case, we are showing a hierarchical structure.
  </p>
</figure>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/networkgraph.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<style>
.highcharts-figure, .highcharts-data-table table {
  min-width: 320px; 
  max-width: 800px;
  margin: 1em auto;
}

.highcharts-data-table table {
	font-family: Verdana, sans-serif;
	border-collapse: collapse;
	border: 1px solid #EBEBEB;
	margin: 10px auto;
	text-align: center;
	width: 100%;
	max-width: 500px;
}
.highcharts-data-table caption {
  padding: 1em 0;
  font-size: 1.2em;
  color: #555;
}
.highcharts-data-table th {
	font-weight: 600;
  padding: 0.5em;
}
.highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
  padding: 0.5em;
}
.highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
  background: #f8f8f8;
}
.highcharts-data-table tr:hover {
  background: #f1f7ff;
}
</style>
<script>
// Add the nodes option through an event call. We want to start with the parent
// item and apply separate colors to each child element, then the same color to
// grandchildren.
Highcharts.addEvent(
  Highcharts.Series,
  'afterSetOptions',
  function (e) {
    var colors = Highcharts.getOptions().colors,
      i = 0,
      nodes = {};

    if (
      this instanceof Highcharts.seriesTypes.networkgraph &&
      e.options.id === 'lang-tree'
    ) {
      e.options.data.forEach(function (link) {

        if (link[0] === 'Learning Skills Tree') {
          nodes['Learning Skills Tree'] = {
            id: 'Learning Skills Tree',
            marker: {
              radius: 10
            }
          };
          nodes[link[1]] = {
            id: link[1],
            marker: {
              radius: 5
            },
            color: colors[i++]
          };
        } else if (nodes[link[0]] && nodes[link[0]].color) {
          nodes[link[1]] = {
            id: link[1],
            color: nodes[link[0]].color
          };
        }
      });

      e.options.nodes = Object.keys(nodes).map(function (id) {
        return nodes[id];
      });
    }
  }
);

Highcharts.chart('container', {
  chart: {
    type: 'networkgraph',
    height: '100%'
  },
  title: {
    text: 'Academic Fields Tree'
  },
  subtitle: {
    text: 'Based on Wikipedias Outline of Academic Fields'
  },
  plotOptions: {
    networkgraph: {
      keys: ['from', 'to'],
      layoutAlgorithm: {
        enableSimulation: true,
        friction: -0.9
      }
    }
  },
  series: [{
    dataLabels: {
      enabled: true,
      linkFormat: ''
    },
    id: 'lang-tree',
    data: [
      <?php include 'data.php'; ?>
    ]
  }]
});
</script>
</body>
</html>