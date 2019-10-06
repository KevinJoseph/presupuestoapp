<template>
<div class="container">
        <!-- Formulario para añadir pacientes -->
        <section class="form">
                <form @submit.prevent="editOfficeGoal(officeToGoal)" v-if="modoEditar">
                <h3>Editar Oficina o Meta</h3>
               <div class="form-group">
                    <label for="exampleFormControlSelect1">Metas:</label>
                    <select class="form-control" v-model="officeToGoal.goal_id">
                        <option v-for="(goal,index) in goals" v-bind:key="index" :value="goal.id" >{{goal.name}}</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Oficinas:</label>
                    <select class="form-control" v-model="officeToGoal.office_id">
                        <option v-for="(office,index) in offices" v-bind:key="index" :value="office.id" >{{office.name}}</option>
                    </select>
                </div>
                <button class="btn btn-success" type="submit">Guardar</button>
                <button class="btn btn-default" type="submit" 
                    @click="cancelarEdicion">Cancelar</button>
                </form>
     
                <form @submit.prevent="addOfficeToGoal" v-else>
                
                <h3>Asignar oficina a una Meta</h3>
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Metas:</label>
                    <select class="form-control" v-model="officeToGoal.goal_id">
                        <option>Seleccionar una Meta</option>    
                        <option v-for="(goal,index) in goals" v-bind:key="index" :value="goal.id" >{{goal.name}}</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Oficinas:</label>
                    <select class="form-control" v-model="officeToGoal.office_id">
                        <option>Seleccionar una Oficinas</option>    
                        <option v-for="(office,index) in offices" v-bind:key="index" :value="office.id" >{{office.name}}</option>
                    </select>
                </div>
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
                        <th scope="col">Metas</th>
                        <th scope="col">Oficinas</th>  
                        <th scope="col">Acciones</th>          
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(officeToGoal, index) in officesGoals" v-bind:key="index">
                        <td>{{officeToGoal.id }}</td>
                        <td>{{index}}</td>
                        <td>{{officeToGoal.goal_name}}</td>
                        <td>{{officeToGoal.office_name}}</td>
                        <td>
                                <!-- Botón para mostrar el formulario de actualizar -->
                                <button @click="editarFormulario(officeToGoal)" class="btn btn-warning">Editar</button>
                                <!-- Botón para borrar -->
                                <button @click="deleteOfficeGoal(officeToGoal,index)" class="btn btn-danger">Borrar</button>
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
                this.goals = response.data;
            });
            axios.get('/agroapp/public/offices').then((response) => {
                this.offices = response.data;
            });
            axios.get('/agroapp/public/officesToGoals').then((response) => {
                this.officesGoals = response.data;
            });
        },
        data() {
            return{
                goals: [] ,
                goal:{id:'',name:''},
                offices:[],
                office:{id:'',name:''},
                officesGoals:[],
                officeToGoal:{id:'',goal_id:'',office_id:'',goal_name:'',office_name:''},
                modoEditar:false
            }
        },
        methods:{
            addOfficeToGoal: function() {
                const params = this.officeToGoal; 
                axios.post('/agroapp/public/officesToGoals', params)
                .then((response) => {
                        this.officesGoals.push(response.data);
                        axios.get('/agroapp/public/officesToGoals').then((response) => {
                        this.officesGoals = response.data;
                         });
                }); 
                this.officeToGoal = {id:'',goal_id:'',office_id:''};      
            },
            editarFormulario(officeToGoal){
                this.officeToGoal.id = officeToGoal.id;
                this.officeToGoal.goal_id = officeToGoal.goal_id;
                this.officeToGoal.office_id = officeToGoal.office_id;
                console.log(this.officeToGoal);
                this.modoEditar = true;
            },
            editOfficeGoal: function (officeToGoal) {
                console.log("editar: "+officeToGoal.id);
                const params = {goal_id: officeToGoal.goal_id, office_id:officeToGoal.office_id}; 
                console.log(params);
                axios.put(`/agroapp/public/officesToGoals/${officeToGoal.id}`, params)
                    .then(response => {
                        console.log(response.data);
                         this.modoEditar = false;
                         const index = this.officesGoals.findIndex(item => item.id === officeToGoal.id);
                         this.officesGoals[index] = response.data;
                            this.officeToGoal = {goal_id:'',office_id:''};

                            axios.get('/agroapp/public/goals').then((response) => {
                                this.goals = response.data;
                            });
                            axios.get('/agroapp/public/offices').then((response) => {
                                this.offices = response.data;
                            });
                            axios.get('/agroapp/public/officesToGoals').then((response) => {
                                this.officesGoals = response.data;
                            });
     
                    });
            },
            deleteOfficeGoal: function (officeToGoal, index) {
                const confirmation = confirm(`Se eliminara la Meta: ${officeToGoal.id}`);
                if(confirmation){
                    axios.delete(`/agroapp/public/officesToGoals/${officeToGoal.id}`)
                    .then(()=>{
                        this.officesGoals.splice(index,1)
                    });
                }
            },
            cancelarEdicion: function () {
                this.modoEditar = false;
                this.officeToGoal = {goal_id:'',office_id:''};
            }
        }
    }
</script>