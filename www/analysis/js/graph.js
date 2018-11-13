$(document).ready(function(){

    var num = [50, 45, 47, 72];
    var ticks = ['10/10', '11/10', '12/10', 'today'];

    $.jqplot(
        'chart',
        [num],
        {
            seriesDefaults: {
                renderer:$.jqplot.BarRenderer,
                pointLabels: { show: true }
            },
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: ticks
                },
                yaxis: {
                    min: 0,
                    max: 500
                }
            }
    });
    $('#chart').bind('jqplotDataHighlight',
        function (ev, seriesIndex, pointIndex, data) {
            $('#info').html(data[1]);
        }
    );

   $('#chart').bind('jqplotDataUnhighlight',
        function (ev) {
            $('#info').html('');
        }
    );
    

    $('#register').click(function() {

       // var clickCount;

       $.ajax({
            url: 'php/query.php',
            success: function(data) {
               console.log(data);
               var num = [50, 45, 47, data];
               var ticks = ['10/10', '11/10', '12/10', 'today'];

                $.jqplot(
                    'chart',
                    [num],
                    {
                    seriesDefaults: {
                        renderer:$.jqplot.BarRenderer,
                        pointLabels: { show: true }
                    },
                    axes: {
                        xaxis: {
                            renderer: $.jqplot.CategoryAxisRenderer,
                            ticks: ticks
                        },
                        yaxis: {
                            min: 0,
                            max: 500
                        }
                    }
                });

            }
       });

   });

   $('#chart').bind('jqplotDataHighlight',
        function (ev, seriesIndex, pointIndex, data) {
            $('#info').html(data[1]);
        }
    );

   $('#chart').bind('jqplotDataUnhighlight',
        function (ev) {
            $('#info').html('');
        }
    );
});