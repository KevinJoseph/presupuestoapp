<template>
<div class="container">
        <!-- Formulario para añadir pacientes -->
        <section class="form">
                <form @submit.prevent="editOffice(office)" v-if="modoEditar">
                <h3>Editar Oficina</h3>
                <input type="text" class="form-control mb-2" 
                    placeholder="Nombre de la Partida" v-model="office.name">
                <button class="btn btn-success" type="submit">Guardar</button>
                <button class="btn btn-default" type="submit" 
                    @click="cancelarEdicion">Cancelar</button>
                </form>
                <form @submit.prevent="addOffice" v-else>
                <h3>Agregar Nueva Oficina</h3>
                <input type="text" class="form-control mb-2" placeholder="Nombre de la Oficina" v-model="office.name">
                <button class="btn btn-primary" type="submit">Agregar</button>
                </form>
        </section>
        <!-- Tabla donde se muestran los datos -->
        <section class="data">
            <br>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">index</th>
                        <th scope="col">Oficina</th>  
                        <th scope="col">Operaciones</th>         
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(office, index) in offices" v-bind:key="index">
                        <td>{{office.id }}</td>
                        <td>{{index}}</td>
                        <td>{{office.name}}</td>
                        <td>
                                <!-- Botón para mostrar el formulario de actualizar -->
                                <button @click="editarFormulario(office)" class="btn btn-warning">Editar</button>
                                <!-- Botón para borrar -->
                                <button @click="deleteOffice(office,index)" class="btn btn-danger">Borrar</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </section>
    </div>

</template>

<script>
    export default {
        mounted() {
            axios.get('/agroapp/public/offices').then((response) => {
                this.offices = response.data;
            });
        },
        data() {
            return{
                offices: [] ,
                office:{name:''},
                modoEditar:false
            }
        },
        methods:{
            addOffice: function() {
                const params = this.office; 
                 console.log('params: '+this.params);
                axios.post('/agroapp/public/offices', params)
                .then((response) => {
                this.offices.push(response.data);
                console.log(this.offices);
                });    
                this.office = {name:''};      
            },
            editarFormulario(office){
                this.office.name = office.name;
                this.office.id = office.id;
                this.modoEditar = true;
            },
            editOffice: function (office) {
                const params = {name: office.name};
                axios.put(`/agroapp/public/budgets/${budget.id}`, params)
                    .then(response => {
                         this.modoEditar = false;
                         const index = this.offices.findIndex(item => item.id === office.id);
                         this.offices[index] = response.data;
                            axios.get('/agroapp/public/offices')
                            .then( response => {
                               this.offices = response.data;     
                            });
                    });
            },
            deleteOffice: function (office, index) {
                const confirmation = confirm(`Se eliminara la Oficina: ${office.name}`);
                if(confirmation){
                    axios.delete(`/agroapp/public/offices/${office.id}`)
                    .then(()=>{
                        this.offices.splice(index,1)
                    });
                }
            },
            cancelarEdicion: function () {
                this.modoEditar = false;
                this.office = {name:''};
            }
        }
    }
</script>