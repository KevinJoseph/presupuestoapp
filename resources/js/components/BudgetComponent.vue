<template>
<div class="container">
        <!-- Formulario para añadir pacientes -->
        <section class="form">
                <form @submit.prevent="editBudget(budget)" v-if="modoEditar">
                <h3>Editar Partida Presupuestaria</h3>
                <input type="text" class="form-control mb-2" 
                    placeholder="Nombre de la Partida" v-model="budget.name">
                <button class="btn btn-success" type="submit">Guardar</button>
                <button class="btn btn-default" type="submit" 
                    @click="cancelarEdicion">Cancelar</button>
                </form>
                <form @submit.prevent="addBudget" v-else>
                <h3>Agregar Partida Presupuestaria</h3>
                <input type="text" class="form-control mb-2" placeholder="Nombre de la Partida Presupuestaria" v-model="budget.name">
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
                        <th scope="col">Partida</th>  
                        <th scope="col">Operaciones</th>         
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(budget, index) in budgets" v-bind:key="index">
                        <td>{{budget.id }}</td>
                        <td>{{index}}</td>
                        <td>{{budget.name}}</td>
                        <td>
                                <!-- Botón para mostrar el formulario de actualizar -->
                                <button @click="editarFormulario(budget)" class="btn btn-warning">Editar</button>
                                <!-- Botón para borrar -->
                                <button @click="deleteBudget(budget,index)" class="btn btn-danger">Borrar</button>
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
            axios.get('/agroapp/public/budgets').then((response) => {
                this.budgets = response.data;
            });
        },
        data() {
            return{
                budgets: [] ,
                budget:{name:''},
                modoEditar:false
            }
        },
        methods:{
            addBudget: function() {
                const params = this.budget; 
                axios.post('/agroapp/public/budgets', params)
                .then((response) => {
                this.budgets.push(response.data);
                console.log(this.budgets);
                });    
                this.budget = {name:''};      
            },
            editarFormulario(budget){
                this.budget.name = budget.name;
                this.budget.id = budget.id;
                this.modoEditar = true;
            },
            editBudget: function (budget) {
                const params = {name: budget.name};
                axios.put(`/agroapp/public/budgets/${budget.id}`, params)
                    .then(response => {
                        console.log(response.data);
                         this.modoEditar = false;
                         const index = this.budgets.findIndex(item => item.id === budget.id);
                         this.budgets[index] = response.data;
                            this.budget = {name:''};
                            axios.get('/agroapp/public/budgets')
                            .then( response => {
                               this.budgets = response.data;     
                            });
                    });
            },
            deleteBudget: function (budget, index) {
                const confirmation = confirm(`Se eliminara la Partida: ${budget.name}`);
                if(confirmation){
                    axios.delete(`/agroapp/public/budgets/${budget.id}`)
                    .then(()=>{
                        this.budgets.splice(index,1)
                    });
                }
            },
            cancelarEdicion: function () {
                this.modoEditar = false;
                this.budget = {name:''};
            }
        }
    }
</script>