// Load the Visualization API and the corechart package.
google.charts.load('current', { 'packages': ['corechart'] });

// Set a callback to run when the Google Visualization API is loaded.
google.charts.setOnLoadCallback(drawChart);

// Callback that creates and populates a data table,
// instantiates the pie chart, passes in the data and
// draws it.
function drawChart() {

    // Create the data table.
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Topping');
    data.addColumn('number', 'Slices');

    // Agregar filas con los porcentajes
    datosJS.forEach(function (item) {
        var total = item[0];
        var activo = item[1];
        var inactivo = item[2];

        // Calcular porcentajes
        var porcentajeActivo = (activo / total) * 100;
        var porcentajeInactivo = (inactivo / total) * 100;


        // Agregar filas a la tabla
        data.addRows([
            ['Activos', porcentajeActivo],
            ['Cancelados', porcentajeInactivo]
        ]);
    });



    // Set chart options
    var options = {
        'title': 'Estados de prestamos totales de clientes',
        'width': 1500,
        'height': 500
    };

    // Instantiate and draw our chart, passing in some options.
    var chart = new google.visualization.PieChart(document.getElementById('grafico'));
    chart.draw(data, options);

    //console.log(chart.getImageURI());

    document.getElementById("variable").value = chart.getImageURI();
}