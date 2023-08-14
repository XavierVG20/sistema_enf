<template>
    <main class="main">
       
        <section class="content">

            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header with-border">
                    <h3 class="card-title">Informe medico</h3>
                </div>

                <!-- Listado-->

                <template v-if="listado == 1">

                    <div class="card-body">
                            <button type="button" @click="mostrarDetalle()" class="btn btn-primary">
                                <i class="fa fa-plus"></i>&nbsp;Nuevo
                            </button>
                            <button type="submit"  @click="$event => cargarPdf( buscar, criterio)" class="btn btn-primary"><i
                                        class="fa fa-download"></i> Descargar reportes</button>
                        <br> <br>
                        <div class="row">
                            <div class=" col-md-3">
                                
                                <select class="form-control" v-model="criterio">
                                    <option value="nombre">Estudante</option>
                                    <option value="fecha_hora">Fecha-Hora</option>
                                    <option value="num_documento">CI</option>

                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="text" v-model="buscar" @keyup.enter="listarInforme_m(1, buscar, criterio)"
                                    class="form-control" placeholder="Texto a buscar">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" @click="listarInforme_m(1, buscar, criterio)" class="btn btn-primary"><i
                                        class="fa fa-search"></i> Buscar</button>
                                        

                            </div>
                           
                        </div>

                        <br>


                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        
                                        <th>Estudiante</th>
                                        <th>CI</th>

                                        <th>Curso</th>
                                        <th>Motivo de emergencia</th>
                                        
                                        <th>Fecha Hora</th>
                                        <th>Responsable de la antencion</th>
                                    
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="informe_m in arrayInforme_m" :key="informe_m.id">
                                        <td>
                                            <button type="button" @click="verInforme_m(informe_m.id)"
                                                class="btn btn-success btn-sm">
                                                <i class="fa fa-eye"></i>
                                            </button> &nbsp;
                                            <button type="button" @click="pdfInforme_m(informe_m.id)" class="btn btn-info btn-sm">
                                                <i class="fa fa-sticky-note-o"></i>
                                            </button> &nbsp;
                                           
                                        </td>
                                     
                                        <td v-text="informe_m.nombre"></td>
                                        <td v-text="informe_m.num_documento"></td>

                                        <td v-text="informe_m.curso"></td>
                                        <td v-text="informe_m.motivo_emergencia"></td>
                                        <td v-text="informe_m.created_at"></td>
                                        <td v-text="informe_m.name"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#"
                                        @click.prevent="cambiarPagina(pagination.current_page - 1, buscar, criterio)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page"
                                    :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page, buscar, criterio)"
                                        v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#"
                                        @click.prevent="cambiarPagina(pagination.current_page + 1, buscar, criterio)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </template>
                <!--Fin Listado-->
                <!-- Detalle-->
                <template v-else-if="listado == 0">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card box-primary">
                                
                                <div class="card-body">
                                    <div class="form-group row border">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label for="">Estudiante(*)</label>
                                                <v-select :on-search="selectEstudiante" label="nombre" :options="arrayEstudiante"
                                                    placeholder="Buscar Estudiante..." :onChange="getDatosEstudiante">

                                                </v-select>
                                            </div>
                                        </div>
                                        
                                       
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <label>Motivo de emergencia</label>
                                                <input type="text" class="form-control" v-model="motivo_emergencia"
                                                    placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                            
                                
                                    <div class="form-group row border">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="form-inline">
                                                    <button @click="abrirModal()" class="btn btn-primary">Agregar
                                                        Insumo</button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <br><br>
                                    <div class="form-group row border">
                                        <div class="table-responsive col-md-12">
                                            <table class="table table-bordered table-striped table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>Opciones</th>
                                                        <th>Insumo</th>
                                                        <th>Unidad</th>
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody v-if="arrayDetalle.length">
                                                    <tr v-for="(detalle, index) in arrayDetalle" :key="detalle.id">
                                                        <td>
                                                            <button @click="eliminarDetalle(index)" type="button"
                                                                class="btn btn-danger btn-sm">
                                                                <i class="fa fa-close"></i>
                                                            </button>
                                                        </td>
                                                        <td v-text="detalle.insumo">
                                                        </td>
                                                       
                                                        <td>
                                                            <span style="color:red;"
                                                                v-show="detalle.unidad > detalle.unidad">Cantidad:
                                                                {{ detalle.unidad }}</span>
                                                            <input v-model="detalle.unidad" type="number"
                                                                class="form-control">
                                                        </td>
                                                      

                                                    
                                                   
                                                    </tr>
                                                </tbody>
                                                <tbody v-else>
                                                    <tr>
                                                        <td colspan="6">
                                                            No hay insumos agregados
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <div class="col-xs-12">
                                            <a @click="ocultarDetalle()" class="btn btn-danger">
                                                Cerrar</a>
                                            <button type="button" class="btn btn-success pull-right"
                                                @click="registrarVenta()"> Registrar Informe
                                            </button>


                                        </div>
                                    </div>

                               
                           
                        </div>
                                        <div class="col-md-12">
                                            <div v-show="errorInforme_m" class="form-group row div-error">
                                                <div class="text-center text-error">
                                                    <div v-for="error in errorMostrarMsjInforme_m" :key="error" v-text="error">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                       
                    </div>



                </template>
                <!-- Fin Detalle-->
                <!--Ver ingreso-->
                <template v-else-if="listado == 2">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title"> Informacion Generar</h3>
                                </div>
                                <div class="box-body">
                                    <div class="form-group row border">
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <label for="">Estudiante</label>
                                                <p v-text="estudiante"></p>
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Motivo de mergencia</label>
                                                <p v-text="motivo_emergencia"></p>
                                            </div>
                                        </div>
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
    <div class="box box-success">
    <div class="box-header">
        <h3 class="box-title"> Articulos</h3>
    </div>
    <div class="box-body">
                        <div class="form-group row border">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label for="">Estudiante</label>
                                    <p v-text="estudiante"></p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="">Motivo de emergencia</label>
                                <p v-text="motivo_emergencia"></p>
                            </div>
                            
                        </div>
                        <div class="form-group row border">
                            <div class="table-responsive col-md-12">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Artículo</th>
                                            <th>Precio</th>
                                            <th>Cantidad</th>
                                            <th>Descuento</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="arrayDetalle.length">
                                        <tr v-for="detalle in arrayDetalle" :key="detalle.id">
                                            <td v-text="detalle.articulo">
                                            </td>
                                            <td v-text="detalle.precio">
                                            </td>
                                            <td v-text="detalle.cantidad">
                                            </td>
                                            <td v-text="detalle.descuento">
                                            </td>
                                           
                                       
                                        
                                        </tr>
                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="5">
                                                No hay articulos agregados
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <button type="button" @click="ocultarDetalle()" class="btn btn-danger">Cerrar</button>
                            </div>
                        </div>
                    </div>
   </div>
</div>
                    </div>

                    
                </template>
                <!--Fin ver ingreso-->
            </div>
            <!-- Fin ejemplo de tabla Listado -->
        </section>
        <!--Inicio del modal agregar/actualizar-->

        <div class="modal modal-primary" style="overflow: hidden;" tabindex="-1" :class="{ 'mostrar': modal }" role="dialog"
            aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            @click="cerrarModal()"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" v-text="tituloModal"></h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div>
                                    <tr>
                                        <th>
                                            <select class="form-control" v-model="criterioA">
                                                <option value="nombre">Nombre</option>
                                                <option value="descripcion">Descripción</option>
                                                <option value="codigo">Código</option>
                                            </select>
                                        </th>
                                        <th>
                                            <input type="text" v-model="buscarA"
                                                @keyup.enter="listarInsumo(buscarA, criterioA)" class="form-control"
                                                placeholder="Texto a buscar">

                                        </th>
                                        <th>
                                            <button type="submit" @click="listarInsumo(buscarA, criterioA)"
                                                class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>

                                        </th>
                                    </tr>

                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                       
                                        <th>Insumo</th>
                                        <th>Descripcion</th>
                                        <th>Unidad</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="insumo in arrayInsumo" :key="insumo.id">
                                        <td>
                                            <button type="button" @click="agregarDetalleModal(insumo)"
                                                class="btn btn-success btn-sm">
                                                <i class="fa fa-check"></i>
                                            </button>
                                        </td>
                                      
                                        <td v-text="insumo.nombre"></td>
                                        <td v-text="insumo.descripcion"></td>
                                       
                                        <td v-text="insumo.unidad"></td>
                                        <td>
                                            <div v-if="insumo.condicion">
                                                <span class="badge badge-success">Activo</span>
                                            </div>
                                            <div v-else>
                                                <span class="badge badge-danger">Desactivado</span>
                                            </div>

                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline pull-left" @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="tipoAccion == 1" class="btn btn-outline"
                            @click="registrarArticulo()">Guardar</button>
                        <button type="button" v-if="tipoAccion == 1" class="btn btn-primary"
                            @click="registrarPersona()">Guardar</button>
                        <button type="button" v-if="tipoAccion == 2" class="btn btn-primary"
                            @click="actualizarPersona()">Actualizar</button>
                    </div>
                </div>
            </div>
        </div>

        <!--Fin del modal-->
    </main>
</template>

<script>
import vSelect from 'vue-select';
export default {
    data() {
        return {
            informe_m_id: 0,
            idestudiante: 0,
            estudiante: '',
            motivo_emergencia: '',
           
            arrayInforme_m: [],
            arrayEstudiante: [],
            arrayDetalle: [],
            listado: 1,
            modal: 0,
            tituloModal: '',
            tipoAccion: 0,
            errorInforme_m: 0,
            errorMostrarMsjInforme_m: [],
            pagination: {
                'total': 0,
                'current_page': 0,
                'per_page': 0,
                'last_page': 0,
                'from': 0,
                'to': 0,
            },
            offset: 3,
            criterio: 'nombre',
            buscar: '',
            criterioA: 'nombre',
            buscarA: '',
            arrayInsumo: [],
            idinsumo: 0,
            codigo: '',
            insumo: '',
            descripcion: '',
            unidad: 0,
           
        }
    },
    components: {
        vSelect
    },
    computed: {
        isActived: function () {
            return this.pagination.current_page;
        },

        //Calcula los elementos de la paginación
        pagesNumber: function () {
            if (!this.pagination.to) {
                return [];
            }

            var from = this.pagination.current_page - this.offset;
            if (from < 1) {
                from = 1;
            }

            var to = from + (this.offset * 2);
            if (to >= this.pagination.last_page) {
                to = this.pagination.last_page;
            }

            var pagesArray = [];
            while (from <= to) {
                pagesArray.push(from);
                from++;
            }
            return pagesArray;

        },

       
    },
    methods: {
        listarInforme_m(page, buscar, criterio) {
            let me = this;
            var url = '/informe_medico?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
            axios.get(url).then(function (response) {
                var respuesta = response.data;
                console.log(response);
                me.arrayInforme_m = respuesta.informe_medicos.data;
                me.pagination = respuesta.pagination;
            })
                .catch(function (error) {
                    console.log(error);
                });
        },
        selectEstudiante(search, loading) {
            let me = this;
            loading(true)
            var url = '/estudiante/selectEstudiante?filtro=' + search;
            axios.get(url).then(function (response) {
                 console.log(response); 
                let respuesta = response.data;
                q: search
                me.arrayEstudiante = respuesta.estudiantes;
                loading(false)
            })
                .catch(function (error) {
                    console.log(error);
                });
        },
        getDatosEstudiante(val1) {
            let me = this;
            me.loading = true;
            me.idestudiante = val1.id;
        },
        cargarPdf( buscar, criterio) {

            window.open('/informe_medico/listapdf?buscar=' + buscar + '&criterio=' + criterio);
        },
        buscarInsumo() {
            let me = this;
            var url = '/insumo/buscarArticuloVenta?filtro=' + me.codigo;

            axios.get(url).then(function (response) {
                var respuesta = response.data;
                me.arrayArticulo = respuesta.articulos;

                if (me.arrayInsumo.length > 0) {
                    me.insumo = me.arrayArticulo[0]['nombre'];
                    me.idinsumo = me.arrayArticulo[0]['idinsumo'];
                    me.descripcion = me.arrayArticulo[0]['descripcion'];
                    me.unidad = me.arrayArticulo[0]['unidad'];
                }
                else {
                    me.insumo = 'No existe ';
                    me.idinsumo = 0;
                }
            })
                .catch(function (error) {
                    console.log(error);
                });
        },
        pdfInforme_m(id) {
            window.open('/informe_medico/pdf/' + id, '_blank');
        },
        cambiarPagina(page, buscar, criterio) {
            let me = this;
            //Actualiza la página actual
            me.pagination.current_page = page;
            //Envia la petición para visualizar la data de esa página
            me.listarInforme_m(page, buscar, criterio);
        },
        encuentra(id) {
            var sw = 0;
            for (var i = 0; i < this.arrayDetalle.length; i++) {
                if (this.arrayDetalle[i].idinsumo == id) {
                    sw = true;
                }
            }
            return sw;
        },
        eliminarDetalle(index) {
            let me = this;
            me.arrayDetalle.splice(index, 1);
        },
        agregarDetalle() {
            let me = this;
            if (me.idinsumo == 0 || me.unidad == 0 ) {
            } else {
                if (me.encuentra(me.idinsumo)) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'El insumo ya se encuentra agregado!',
                    })
                } else {
                    if (me.cantidad > me.stock) {
                        Swal.fire({
                            type: 'error',
                            title: 'Error...',
                            text: 'No hay unidaddes disponible!',
                        })
                    } else {
                        me.arrayDetalle.push({
                            idinsumo: me.idinsumo,
                            insumo: me.nombre,
                            unidad: me.unidad,
                            descripcion: me.descripcion,
                            
                        });
                        me.idinsumo = '';
                        me.insumo = '';
                        me.unidad = '';
                        me.descripcion= '';
                        
                    }
                }

            }

        },
        agregarDetalleModal(data = []) {
            let me = this;
            if (me.encuentra(data['id'])) {
                Swal.fire({
                    type: 'error',
                    title: 'Error...',
                    text: 'Este Artículo ya se encuentra agregado!',
                })
            } else {
                me.arrayDetalle.push({
                    idinsumo: data['id'],
                    insumo: data['nombre'],
                    
                    unidad: data['unidad']
                });
            }
        },
        listarInsumo(buscar, criterio) {
            let me = this;
            var url = '/insumo/listarInsumosInforme?buscar=' + buscar + '&criterio=' + criterio;
            axios.get(url).then(function (response) {

                var respuesta = response.data;
                console.log(response);
                me.arrayInsumo = respuesta.insumos.data;
                
            })
                .catch(function (error) {
                    console.log(error);
                });
        },
        registrarVenta() {
           
           
            let me = this;

            axios.post('/informe_medico/registrar', {
                'idestudiante': this.idestudiante,
                
                'motivo_emergencia': this.motivo_emergencia,
                'data': this.arrayDetalle

            }).then(function (response) {
                console.log(response.data)
                me.listado = 1;
                me.listarInforme_m(1, '', 'num_comprobante');
                
              
                
                me.idestudiante = 0;
                me.estudiante = '';
                me.motivo_emergencia = '';
              ;
                me.arrayDetalle = [];
                Swal.fire(
                    'Guardado!',
                    'Datos guardados con éxito.',
                    'success'
                )
                window.open('/venta/pdf/' + response.data.id);


            }).catch(function (error) {
                console.log(error);
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Algo salio mas!",
                    footer: error.response.data.message,
                });
            });
        },
        validarVenta() {
            let me = this;
            me.errorInforme_m = 0;
            me.errorMostrarMsjInforme_m = [];
            var art;

            me.arrayDetalle.map(function (x) {
                if (x.unidad > x.unidad) {
                    art = x.insumo + " Stock insuficiente";
                    me.errorMostrarMsjInforme_m.push(art);
                }
            });

            if (me.idestudiante == 0) me.errorMostrarMsjInforme_m.push("Seleccione un Estudiante");
            if (!me.motivo_emergencia == 0) me.errorMostrarMsjInforme_m.push("Ingrese in motivo de mergencia ");
          //  if (!me.num_comprobante) me.errorMostrarMsjInforme_m.push("Ingrese el numero de comprobante");
            

            if (me.errorMostrarMsjInforme_m.length) me.errorInforme_m = 1;

            return me.errorInforme_m;
        },
        mostrarDetalle() {
            let me = this;
            me.listado = 0;

            me.idestudiante = 0;
            
            me.motivo_emergencia = '';
            me.estudiante = '';
            me.arrayDetalle = [];
        },
        ocultarDetalle() {
            this.listado = 1;
        },
        verInforme_m(id) {
            let me = this;
            me.listado = 2;

            //Obtener datos del ingreso
            var informe = [];
            var url = '/informe_medico/obtenerCabecera?id=' + id;

            axios.get(url).then(function (response) {
                var respuesta = response.data;
                informe = respuesta.informe_medicos;
                console.log(respuesta)
                me.estudiante = Informe_m[0]['nombre'];
                me.motivo_emergencia = informe[0]['motivo_emergencia'];
                
           
            })
                .catch(function (error) {
                    console.log(error);
                });

            //obtener datos de los detalles
            var url = '/informe_medico/obtenerDetalles?id=' + id;

            axios.get(url).then(function (response) {
                console.log(response);
                var respuesta = response.data;
                me.arrayDetalle = respuesta.detalles;

            })
                .catch(function (error) {
                    console.log(error);
                });
        },
        cerrarModal() {
            this.modal = 0;
            this.tituloModal = '';
        },
        abrirModal() {
            this.modal = 1;
            this.tituloModal = 'Seleccione los articulos que desee';

        },

        desactivarVenta(id) {

            Swal.fire({
                title: "Esta seguro de anular esta venta?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "Cancelar",
                confirmButtonText: "Aceptar",
            }).then((result) => {
                if (result.value) {
                    let me = this;

                    axios.put('/venta/desactivar', {
                        'id': id
                    }).then(function (response) {
                        me.listarInforme_m(1, '', 'num_comprobante');
                        Swal.fire(
                            'Anulado!',
                            'La venta ha sido anulado con éxito.',
                            'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });


                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {

                }
            })
        },

    },
    mounted() {
        this.listarInforme_m(1, this.buscar, this.criterio);
        this.listarInsumo(this.buscar, this.criterio);

    }
}
</script>
<style>
.modal-content {
    width: 100% !important;
    position: absolute !important;
}

.mostrar {
    display: list-item !important;
    opacity: 1 !important;
    position: absolute !important;
    background-color: #3c29297a !important;
}

.div-error {
    display: flex;
    justify-content: center;
}

.text-error {
    color: red !important;
    font-weight: bold;
}

@media (min-width: 600px) {
    .btnagregar {
        margin-top: 2rem;
    }
}
</style>