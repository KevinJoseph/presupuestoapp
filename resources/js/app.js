
require('./bootstrap');

window.Vue = require('vue');


Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('goal-component', require('./components/GoalComponent.vue').default);
Vue.component('budget-component', require('./components/BudgetComponent.vue').default);
Vue.component('budgettogoal-component', require('./components/BudgetToGoalComponent.vue').default);
Vue.component('office-component', require('./components/OfficeComponent.vue').default);
Vue.component('officetogoal-component', require('./components/OfficeToGoalComponent.vue').default);

const app = new Vue({
    el: '#app',
});
