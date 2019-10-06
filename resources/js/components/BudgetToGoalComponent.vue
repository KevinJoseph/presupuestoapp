<template>
<div class="container">
        <!-- Formulario para añadir pacientes -->
        <section class="form">
                <form @submit.prevent="editBudgetGoal(budgetGoal)" v-if="modoEditar">
                <h3>Editar Partida Presupuestaria to Meta</h3>
                <div class="form-group">
                    <label for="exampleFormControlInput1">Metas</label>
                    <select class="form-control" v-model="budgetGoal.goal_id">
                        <option value="budgetGoal.goal.id">{{budgetGoal.goal_name}}</option>    
                        <option v-for="(goal,index) in goals" v-bind:key="index" :value="goal.id" >{{goal.name}}</option>
                    </select>    
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Gerencias/Subgerencias</label>
                     <select class="form-control" v-model="budgetGoal.office_id">
                        <option>Seleccionar una Oficina</option>    
                        <option v-for="(office,index) in offices" v-bind:key="index" :value="office.id" >{{office.name}}</option>
                    </select>  
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Partidas Presupuestarias</label>
                    <select class="form-control" v-model="budgetGoal.budget_id">
                        <option>Seleccionar una Partida</option>    
                        <option v-for="(budget,index) in budgets" v-bind:key="index" :value="budget.id" >{{budget.name}}</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Monto S/ </label>
                    <input type="text" class="form-control mb-2" placeholder="Ingrese el monto asignado a la partida" v-model="budgetGoal.total">
                </div>                
                <button class="btn btn-success" type="submit">Guardar</button>
                <button class="btn btn-default" type="submit" 
                    @click="cancelarEdicion">Cancelar</button>
                </form>

                <form @submit.prevent="addBudgetGoal" v-else>
                <h3>Asignar Partida Presupuestaria to Meta</h3>
                <div class="form-group">
                    <label for="exampleFormControlInput1">Metas</label>
                    <select class="form-control" v-model="budgetGoal.goal_id">
                        <option>Seleccionar una Meta</option>    
                        <option v-for="(goal,index) in goals" v-bind:key="index" :value="goal.id" >{{goal.name}}</option>
                    </select>    
  
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Gerencias/Subgerencias</label>
                     <select class="form-control" v-model="budgetGoal.office_id">
                        <option>Seleccionar una Oficina</option>    
                        <option v-for="(office,index) in offices" v-bind:key="index" :value="office.id" >{{office.name}}</option>
                    </select>  
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Partidas Presupuestarias</label>
                    <select class="form-control" v-model="budgetGoal.budget_id">
                        <option>Seleccionar una Partida</option>    
                        <option v-for="(budget,index) in budgets" v-bind:key="index" :value="budget.id" >{{budget.name}}</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Monto S/ </label>
                    <input type="text" class="form-control mb-2" placeholder="Ingrese el monto asignado a la partida" v-model="budgetGoal.total">
                </div>                
                <button class="btn btn-primary" type="submit">Asignar Partida</button>
                </form>

        </section>
        <hr>
        <!-- Tabla donde se muestran los datos -->
        <section class="data">
            <br>
            <h3>Tabla de Metas y Partidas asignadas</h3>
            <br>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">Meta</th>
                        <th scope="col">Oficina</th>  
                        <th scope="col">Partida</th> 
                        <th scope="col">Monto</th>
                        <th scope="col">Acciones</th>        
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(budgetGoal, index) in budgetsGoals" v-bind:key="index">
                        <td>{{budgetGoal.id }}</td>
                        <td>{{budgetGoal.goal_name}}</td>
                        <td>{{budgetGoal.office_name}}</td>
                        <td>{{budgetGoal.budget_name}}</td>
                        <td>{{budgetGoal.total}}</td>
                        <td>
                                <!-- Botón para mostrar el formulario de actualizar -->
                                <button @click="editarFormulario(budgetGoal)" class="btn btn-warning">Editar</button>
                                <!-- Botón para borrar -->
                                <button @click="deleteBudgetGoal(budgetGoal,index)" class="btn btn-danger">Borrar</button>
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
            axios.get('/agroapp/public/budgets').then((response) => {
                this.budgets = response.data;
            });
            axios.get('/agroapp/public/namesBudgetGoal').then((response) => {
                this.budgetsGoals = response.data;
            });
        },
        data() {
            return{
                goals: [],
                goal:{name:''},
                offices: [],
                office: {name},
                budgets: [] ,
                budget:{name:''},
                budgetsGoals:[],
                budgetGoal:{id:'',goal_id:'',office_id:'',budget_id:'',total:''},
                modoEditar:false
            }
        },
        methods:{
            addBudgetGoal: function() {
                const params = this.budgetGoal; 
                axios.post('/agroapp/public/budgetsToGoals', params)
                .then((response) => {
                    this.budgetsGoals.push(response.data);
                    axios.get('/agroapp/public/namesBudgetGoal').then((response) => {
                    this.budgetsGoals = response.data;
                    });
                });    
                this.budgetGoal = {goal_id:'',office_id:'',budget:'',total:''};      
            },
            editarFormulario(budgetGoal){
                this.budgetGoal.id = budgetGoal.id;
                this.budgetGoal.goal_id = budgetGoal.goal_id;
                this.budgetGoal.office_id = budgetGoal.office_id;
                this.budgetGoal.budget_id = budgetGoal.budget_id;
                this.budgetGoal.total = budgetGoal.total;
                this.modoEditar = true;
            },
            editBudgetGoal: function (budgetGoal) {
                console.log('editar');
                const params = {id:budgetGoal.id,goal_id: budgetGoal.goal_id,office_id:budgetGoal.office_id,budget_id:budgetGoal.budget_id,total:budgetGoal.total};
                console.log('params: '+this.params);
                axios.put(`/agroapp/public/budgetsToGoals/${budgetGoal.id}`, params)
                    .then(response => {
                        console.log('respuesta'+response.data);
                         this.modoEditar = false;
                         const index = this.budgetsGoals.findIndex(item => item.id === budgetGoal.id);
                         this.budgetsGoals[index] = response.data;
                            this.budgetGoal = {id:'',goal_id:'',office_id:'',budget_id:'',total:''};
                            axios.get('/agroapp/public/namesBudgetGoal')
                            .then( response => {
                               this.budgetsGoals = response.data;     
                            });
                    });
            },
            deleteBudgetGoal: function (budgetGoal, index) {
                const confirmation = confirm(`Se eliminara la Asignación: ${budgetGoal.id}`);
                if(confirmation){
                    axios.delete(`/agroapp/public/budgetsToGoals/${budgetGoal.id}`)
                    .then(()=>{
                        this.budgetsGoals.splice(index,1)
                    });
                }
            },
            cancelarEdicion: function () {
                this.modoEditar = false;
                 this.budgetGoal = {id:'',goal_id:'',office_id:'',budget_id:'',total:''};
            }
        }
    }
</script>