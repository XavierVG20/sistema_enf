<!DOCTYPE>
<html>

<head>
    <title>Factura</title>
    <link rel="stylesheet" type="text/css" href="css/fac.css">
</head>
<style>
body {
    /*position: relative;*/
    /*width: 16cm;  */
    /*height: 29.7cm; */
    /*margin: 0 auto; */
    /*color: #555555;*/
    /*background: #FFFFFF; */
    font-family: Arial, sans-serif;
    /*font-size: 15px; */
    /*font-family: SourceSansPro;*/
}

#logo {
    float: left;
    margin-top: 1%;
    margin-left: 1%;
    margin-right: 1%;
}

#imagen {
    width: 150px;
}

#datos {
    float: left;
    margin-top: 1%;
    margin-left: 1%;
    margin-right: 1%;
    /*text-align: justify;*/
}

#encabezado {
    text-align: center;
    margin-left: 10px;
    margin-right: 350px;
    font-family: DejaVu Sans;
    font-size: 10px;
    font-weight: normal;
}

#fact {
    /*position: relative;*/
    float: right;
    margin-top: 2%;
    margin-left: 2%;
    margin-right: 2%;
    font-size: 20px;
}



h3,
h4,
h5,
h6,
p,
span,
div {
    font-family: DejaVu Sans;
    font-size: 10px;
    font-weight: normal;
}

th,
td {
    font-family: DejaVu Sans;
    font-size: 10px;
}

.panel {
    margin-bottom: 20px;
    background-color: #fff;
    border: 1px solid transparent;
    border-radius: 4px;
    -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
    box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
}

.panel-default {
    border-color: #ddd;
}

.panel-body {
    padding: 10px;
}

table {
    width: 100%;
    max-width: 100%;
    margin-bottom: 0px;
    border-spacing: 0;
    border-collapse: collapse;
    background-color: transparent;
}

thead {
    text-align: left;
    display: table-header-group;
    vertical-align: middle;
}

th,
td {
    border: 1px solid #ddd;
    padding: 6px;
}

.well {
    min-height: 20px;
    padding: 19px;
    margin-bottom: 20px;
    background-color: #f5f5f5;
    border: 1px solid #e3e3e3;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .05);
    box-shadow: inset 0 1px 1px rgba(0, 0, 0, .05);
}
</style>

<body>

    <header>
      
        <div id="logo">
            <img src="https://i0.wp.com/uecec.edu.ec/wp-content/uploads/2020/09/cropped-logo-cec-por2.png?fit=192%2C192&#038;ssl=1" alt="Compuzoft" id="imagen">
           
           
            
        </div>
        @foreach ($informe_medicos as $i)
        <div id="datos">
            <p id="encabezado">
           
            <h1 > Departamento de Enfermeria</h1>
            <h2>Motivo de emergencia:{{$i->motivo_emergencia}}</h2>
                
            </p>
        </div>
        <div id="fact">
            
        </div>
    </header>

    <main>
    
            <div style="clear:both; position:relative;">
            <div style="position:absolute; left:0pt; width:250pt;">
                <h4>Estudiante:</h4>
                <div class="panel panel-default">
                    <div class="panel-body">
                        Nombre: {{$i->nombre}}<br>
                      
                        Curso: {{$i->curso}}<br>
                        Cedula de identidad: {{$i->num_documento}}<br>
                        Dirección: {{$i->direccion}}<br>

                    </div>
                </div>
            </div>
            <div style="margin-left: 300pt;">
                <h4>Representante:</h4>
                <div class="panel panel-default">
                    <div class="panel-body">

                        Sr(a): {{$i->rep_nombre}}<br>
                        Cedula de identidad: {{$i->rep_documento}}<br>
                        Dirección: {{$i->direccion}}<br>
                        Teléfono: {{$i->telefono}}<br>
                    </div>
                </div>
            </div>
        </div>

        <table class="table table-bordered">
            @endforeach

            <thead>

                <tr>
                    <th>INSUMO</th>
                    <th>DESCRIPCION</th>
                    <th>UNIDAD</th>
                    
                </tr>
            </thead>
            <tbody>
                @foreach ($detalles as $det)
                <tr>
                    <td>{{$det->nombre}}</td>
                    <td>{{$det->descripcion}}</td>
                    <td>{{$det->cantidad}}</td>
                   
                </tr>
            </tbody>
            @endforeach

        </table>
        <div style="clear:both; position:relative;">
            
           
        </div>



    </main>

</body>

</html>