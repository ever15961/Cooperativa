google.charts.load('current', { 'packages': ['bar'] });
google.charts.setOnLoadCallback(drawStuff);

function drawStuff() {
    /*
    var data = new google.visualization.arrayToDataTable([
        ['Move', 'Percentage'],
        ["King's pawn (e4)", 44],
        ["Queen's pawn (d4)", 31],
        ["Knight to King 3 (Nf3)", 12],
        ["Queen's bishop pawn (c4)", 10],
        ['Other', 3]
    ]);*/

    console.log("Estoy en archivo externo");
    console.log(datosJS);

    ////Datos que se mostraran en el grafico

    // Transformar la estructura usando map
    var datosTransformados = datosJS.map(function (subArray) {
        return [subArray[0], subArray[1]];
    });

    // Crear el DataTable
    var data = new google.visualization.arrayToDataTable([
        ['Año', 'Cantidad de Préstamos'],
        ...datosTransformados
    ]);


    var options = {
        width: 800,
        legend: { position: 'none' },
        chart: {
            title: 'Prestamos por año',
            subtitle: 'Linea de tiempo'
        },
        axes: {
            x: {
                0: { side: 'top', label: '' } // Top x-axis.
            }
        },
        bar: { groupWidth: "90%" }
    };

    var chart = new google.charts.Bar(document.getElementById('grafico'));
    chart.draw(data, google.charts.Bar.convertOptions(options));

    // Espera a que el gráfico esté completamente renderizado
    google.visualization.events.addListener(chart, 'ready', function () {
        // Utiliza html2canvas para capturar la imagen del contenedor del gráfico
        html2canvas(document.getElementById('grafico')).then(function (canvas) {
            // Convierte el canvas a una URL de imagen en base64
            var imgData = canvas.toDataURL('image/png');

            console.log(imgData);

            // Asigna la imagen al elemento con id 'imgN'
            //document.getElementById('variable').src = imgData; PARA MOSTRAR EN IMG
            document.getElementById('variable').value = imgData;
        });
    });
}
