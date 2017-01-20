<div class="row">
<div class="col-md-1"></div>
<div class="col-md-10">
<div class="graph" id="graph1"></div>
<h3>Two Weeks Invoices</h3>
</div>
<div class="col-md-1"></div>
</div>
<br><br><br>
<div class="row">
<div class="col-md-1"></div>
<div class="col-md-7">
<div class="graph" id="graph3"></div>
<h3>Highest Payments</h3>
</div>
<div class="col-md-3">
<div class="graph" id="graph2"></div>
<h3>Top Customers</h3>
</div>
<div class="col-md-1"></div>
</div>
<pre id="code" class="prettyprint linenums">
// Use Morris.Bar
Morris.Line({
  element: 'graph1',
  data: [
  	{x: '08 Aug 2016', y: 7},
    {x: '09 Aug 2016', y: <?php echo '4'; ?>},
    {x: '10 Aug 2016', y: 0},
    {x: '11 Aug 2016', y: 2},
    {x: '12 Aug 2016', y: 3},
    {x: '13 Aug 2016', y: 5},
    {x: '14 Aug 2016', y: 2},
    {x: '15 Aug 2016', y: 3},
    {x: '16 Aug 2016', y: 2},
    {x: '17 Aug 2016', y: 0},
    {x: '18 Aug 2016', y: 2},
    {x: '19 Aug 2016', y: 3},
    {x: '20 Aug 2016', y: 5},
    {x: '21 Aug 2016', y: 2},
  ],
  xkey: 'x',
  ykeys: ['y'],
  labels: ['Invioces']
}).on('click', function(i, row){
  console.log(i, row);
});

Morris.Donut({
  element: 'graph2',
  data: [
    {value: 70, label: 'Rahat Bakers'},
    {value: 15, label: 'Lahori Nashta'},
    {value: 10, label: 'Ali Medicals'},
    {value: 5, label: 'MCC'}
  ],
  formatter: function (x) { return x + "%"}
}).on('click', function(i, row){
  console.log(i, row);
});

// Use Morris.Bar
Morris.Bar({
  element: 'graph3',
  data: [
    {x: 'Rahat Backers | 03 Jan 2016', y: 115000},
    {x: 'Ali Medicals | 23 Feb 2016', y: 102000},
    {x: 'Lahori Nashta | 25 Jul 2016', y: 95000},
    {x: 'Tandoori Nights | 30 Dec 2015', y: 87000}
  ],
  xkey: 'x',
  ykeys: ['y'],
  labels: ['Payment']
}).on('click', function(i, row){
  console.log(i, row);
});
</pre>
