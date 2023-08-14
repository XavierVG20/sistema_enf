<template>
    <main class="main">
        <section class="content-header">
            <h1>
                Modulo
                <small>de Reportes</small>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="/home"><i class="fa fa-dashboard"></i> Dashboard</a>
                </li>
                <li class="active">Reportes</li>
            </ol>
        </section>
        <section class="content">

            <!-- Ejemplo de tabla Listado -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Reportes</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip"
                            title="Remove">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>

                <!-- Listado-->

                <template>

                    <div class="box-body">
                     
                        <!-- Date range -->
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Desde:</label>

                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="date"  v-model="criterio" class="form-control pull-right" id="reservation">
                                    </div>
                                    <!-- /.input group -->
                                </div>
                                <div class="col-md-4">
                                    <label>Hasta:</label>

                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="date" v-model="buscar" @keyup.enter="listarVenta(1, buscar, criterio)"
                                         class="form-control pull-right" id="reservation">
                                    </div>
                                    <!-- /.input group -->
                                </div>
                                <div class="col-md-4">
                                    <label for=""> </label>
                                    <div class="input-group">
                                       
                                        <button type="submit" @click="listarVenta(1, buscar, criterio)" class="btn btn-primary"><i
                                        class="fa fa-search"></i> Buscar</button>
                                    </div>
                                   
                                  
                                </div>
                            </div>
                        </div>
                        <!-- /.form group -->
                      
                        <br>


                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>Usuario</th>
                                        <th>Cliente</th>
                                        <th>Tipo Comprobante</th>
                                        <th>Serie Comprobante</th>
                                        <th>Número Comprobante</th>
                                        <th>Fecha Hora</th>
                                        <th>Total</th>
                                        <th>Impuesto</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="venta in arrayVenta" :key="venta.id">
                                        <td>
                                            <button type="button" @click="verVenta(venta.id)"
                                                class="btn btn-success btn-sm">
                                                <i class="fa fa-eye"></i>
                                            </button> &nbsp;
                                            <button type="button" @click="pdfVenta(venta.id)" class="btn btn-info btn-sm">
                                                <i class="fa fa-sticky-note-o"></i>
                                            </button> &nbsp;
                                            
                                        </td>
                                        <td v-text="venta.name"></td>
                                        <td v-text="venta.nombre"></td>
                                        <td v-text="venta.tipo_comprobante"></td>
                                        <td v-text="venta.serie_comprobante"></td>
                                        <td v-text="venta.num_comprobante"></td>
                                        <td v-text="venta.fecha_hora"></td>
                                        <td v-text="venta.total"></td>
                                        <td v-text="venta.impuesto"></td>
                                        <td v-text="venta.estado"></td>
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

                        <div class="row">
        <!-- accepted payments column -->
       
        <!-- /.col -->
        <div class="col-xs-6">
          <p class="lead">Total ventas regitradas</p>

          <div class="table-responsive">
            <table v-for="ventas in arrayVentas_Registradas"  class="table">
              <tr>
                <th style="width:50%">Ventas Registradas:</th>
                <td v-text="ventas.numero_ventas"></td>
              </tr>
              <tr>
                <th>Total Ventas</th>
                <td v-text="ventas.total_ventas"></td>
              </tr>
            
            </table>
          </div>
        </div>
        <!-- /.col -->
         <!-- /.col -->
         <div class="col-xs-6">
          <p class="lead">Total Ventas Anuladas</p>

          <div class="table-responsive">
            <table v-for="v in arrayVentas_Anuladas"  class="table">
              <tr>
                <th style="width:50%">Ventas Registradas:</th>
                <td v-text="v.numero_ventas"></td>
              </tr>
              <tr>
                <th>Total Ventas</th>
                <td v-text="v.total_ventas"></td>
              </tr>
             
            </table>
          </div>
        </div>
        <!-- /.col -->
      </div>
                    </div>
     
      <!-- /.row -->
                </template>
                <!--Fin Listado-->
          
            </div>
            <!-- Fin ejemplo de tabla Listado -->
        </section>
        <!--Inicio del modal agregar/actualizar-->

      

        <!--Fin del modal-->
    </main>
</template>

<script>
import vSelect from 'vue-select';
export default {
    data() {
        return {
            venta_id: 0,
           
            arrayVenta: [],
            arrayVentas_Registradas:[],
            arrayVentas_Anuladas:[],
            pagination: {
                'total': 0,
                'current_page': 0,
                'per_page': 0,
                'last_page': 0,
                'from': 0,
                'to': 0,
            },
            offset: 3,
            criterio: '',
            buscar: '',
           
           
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

        calcularTotal: function () {
            var resultado = 0.0;
            for (var i = 0; i < this.arrayDetalle.length; i++) {
                resultado = resultado + (this.arrayDetalle[i].precio * this.arrayDetalle[i].cantidad - this.arrayDetalle[i].descuento)
            }
            return resultado;
        }
    },
    methods: {
        listarVenta(page, buscar, criterio) {
            let me = this;
            var url = '/reportes?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
            axios.get(url).then(function (response) {
                console.log(response.data);
                var respuesta = response.data;
                me.arrayVentas_Registradas =  respuesta.ventas_registradas.data
                me.arrayVentas_Anuladas =  respuesta.ventas_anuladas.data
                
                me.arrayVenta = respuesta.ventas.data;
                me.pagination = respuesta.pagination;
            })
                .catch(function (error) {
                    console.log(error);
                });
        },
        selectCliente(search, loading) {
            let me = this;
            loading(true)
            var url = '/cliente/selectCliente?filtro=' + search;
            axios.get(url).then(function (response) {
                //console.log(response);
                let respuesta = response.data;
                q: search
                me.arrayCliente = respuesta.clientes;
                loading(false)
            })
                .catch(function (error) {
                    console.log(error);
                });
        },
        getDatosCliente(val1) {
            let me = this;
            me.loading = true;
            me.idcliente = val1.id;
        },

        buscarArticulo() {
            let me = this;
            var url = '/articulo/buscarArticuloVenta?filtro=' + me.codigo;

            axios.get(url).then(function (response) {
                var respuesta = response.data;
                me.arrayArticulo = respuesta.articulos;

                if (me.arrayArticulo.length > 0) {
                    me.articulo = me.arrayArticulo[0]['nombre'];
                    me.idarticulo = me.arrayArticulo[0]['id'];
                    me.precio = me.arrayArticulo[0]['precio_venta'];
                    me.stock = me.arrayArticulo[0]['stock'];
                }
                else {
                    me.articulo = 'No existe este articulo';
                    me.idarticulo = 0;
                }
            })
                .catch(function (error) {
                    console.log(error);
                });
        },
        pdfVenta(id) {
            window.open('/venta/pdf/' + id, '_blank');
        },
        cambiarPagina(page, buscar, criterio) {
            let me = this;
            //Actualiza la página actual
            me.pagination.current_page = page;
            //Envia la petición para visualizar la data de esa página
            me.listarVenta(page, buscar, criterio);
        },
        encuentra(id) {
            var sw = 0;
            for (var i = 0; i < this.arrayDetalle.length; i++) {
                if (this.arrayDetalle[i].idarticulo == id) {
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
            if (me.idarticulo == 0 || me.cantidad == 0 || me.precio == 0) {
            } else {
                if (me.encuentra(me.idarticulo)) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'El Articulo ya se encuentra agregado!',
                    })
                } else {
                    if (me.cantidad > me.stock) {
                        Swal.fire({
                            type: 'error',
                            title: 'Error...',
                            text: 'No hay stock disponible!',
                        })
                    } else {
                        me.arrayDetalle.push({
                            idarticulo: me.idarticulo,
                            articulo: me.articulo,
                            cantidad: me.cantidad,
                            precio: me.precio,
                            descuento: me.descuento,
                            stock: me.stock
                        });
                        me.codigo = '';
                        me.idarticulo = 0;
                        me.articulo = '';
                        me.cantidad = 0;
                        me.precio = 0;
                        me.descuento = 0;
                        me.stock = 0
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
                    idarticulo: data['id'],
                    articulo: data['nombre'],
                    cantidad: 1,
                    precio: data['precio_venta'],
                    descuento: 0,
                    stock: data['stock']
                });
            }
        },
        listarArticulo(buscar, criterio) {
            let me = this;
            var url = '/articulo/listarArticuloVenta?buscar=' + buscar + '&criterio=' + criterio;
            axios.get(url).then(function (response) {
                var respuesta = response.data;
                me.arrayArticulo = respuesta.articulos.data;
            })
                .catch(function (error) {
                    console.log(error);
                });
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
                        me.listarVenta(1, '', 'num_comprobante');
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
        this.listarVenta(1, this.buscar, this.criterio);
        this.listarArticulo(this.buscar, this.criterio);

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