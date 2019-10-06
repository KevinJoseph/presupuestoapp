<template>
<div class="container">
        <!-- Formulario para añadir pacientes -->
        <section class="form">
                <form @submit.prevent="editGoal(goal)" v-if="modoEditar">
                <h3>Editar Meta</h3>
                <input type="text" class="form-control mb-2" 
                    placeholder="Nombre de la meta" v-model="goal.name">
                <button class="btn btn-success" type="submit">Guardar</button>
                <button class="btn btn-default" type="submit" 
                    @click="cancelarEdicion">Cancelar</button>
                </form>
     
                <form @submit.prevent="addGoal" v-else>
                
                <h3>Crear una Nueva Meta</h3>
                <input type="text" class="form-control mb-2" placeholder="Nombre de la meta" v-model="goal.name">
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
                        <th scope="col">Meta</th> 
                        <th scope="col">Acciones</th>          
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(goal, index) in goals" v-bind:key="index">
                        <td>{{goal.id }}</td>
                        <td>{{index}}</td>
                        <td>{{goal.name}}</td>
                        <td>
                                <!-- Botón para mostrar el formulario de actualizar -->
                                <button @click="editarFormulario(goal)" class="btn btn-warning">Editar</button>
                                <!-- Botón para borrar -->
                                <button @click="deleteGoal(goal,index)" class="btn btn-danger">Borrar</button>
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
            axios.get('/agroapp/public/goals').then((response) => {
                console.log('ja'+response.data);
                this.goals = response.data;
              
            });
              console.log('je: '+this.goals);
            axios.get('/agroapp/public/offices').then((response) => {
                this.offices = response.data;
            });
            
        },
        data() {
            return{
                goals: [] ,
                goal:{name:''},
                modoEditar:false
            }
        },
        methods:{
            addGoal: function() {
                const params = this.goal; 
                
                axios.post('/agroapp/public/goals', params)
                .then((response) => {
                        this.goals.push(response.data);
                }); 
                this.goal = {name:''};      
            },
            editarFormulario(goal){
                this.goal.name = goal.name;
                this.modoEditar = true;
            },
            editGoal: function (goal) {
                const params = {name: goal.name};b 
                axios.put(`/agroapp/public/goals/${goal.id}`, params)
                    .then(response => {
                        console.log(response.data);
                         this.modoEditar = false;
                         const index = this.goals.findIndex(item => item.id === goal.id);
                         this.goals[index] = response.data;
                            this.goals = {name:''};
                            axios.get('/agroapp/public/goals')
                            .then( response => {
                               this.goals = response.data;     
                            });
                            this.goals = {name:''};
                    });
                    this.goal = {name:''};
            },  
            deleteGoal: function (goal, index) {
                const confirmation = confirm(`Se eliminara la Meta: ${goal.name}`);
                if(confirmation){
                    axios.delete(`/agroapp/public/goals/${goal.id}`)
                    .then(()=>{
                        this.goals.splice(index,1)
                    });
                }
            },
            cancelarEdicion: function () {
                this.modoEditar = false;
                this.goal = {name:''};
            }
        }
    }
</script>