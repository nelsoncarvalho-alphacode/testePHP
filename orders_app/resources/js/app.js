/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';
import { createPinia } from 'pinia';

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({});
const pinia = createPinia();


import LoginComponent from './components/Login.vue'
import HomeComponent from './components/Home.vue'

import MainClientComponent from './components/modules/clients/MainClientComponent.vue'
import MainProductComponent from './components/modules/products/MainProductComponent.vue'
import MainOrderComponent from './components/modules/orders/MainOrderComponent.vue'

import TableClientsComponent from './components/modules/clients/TableClientComponent.vue'
import TableProductComponent from './components/modules/products/TableProductComponent.vue'
import TableOrderComponent from './components/modules/orders/TableOrderComponent.vue'

import InputSearchComponent from './components/utils/InputSearch.vue'
import InputContainerComponent from './components/utils/inputContainer.vue'
import GenericModalComponent from './components/generics/ModalComponent.vue'
import ButtonNewItem from './components/utils/ButtonNewItem.vue'
import ToastSuccess from './components/utils/ToastSuccess.vue';
import AlertComponent from './components/utils/Alert.vue';
import PaginateComponent from './components/utils/Paginate.vue'

app.component('login-component', LoginComponent);
app.component('home-component', HomeComponent);

app.component('main-client-component', MainClientComponent);
app.component('main-product-component', MainProductComponent);
app.component('main-order-component', MainOrderComponent);

// app.component('generic-card-component', GenericCardComponent);
app.component('table-products-component', TableProductComponent);
app.component('table-clients-component', TableClientsComponent);
app.component('table-orders-component', TableOrderComponent)

app.component('input-search-component', InputSearchComponent);
app.component('input-container-component', InputContainerComponent);
app.component('generic-modal-component', GenericModalComponent);
app.component('button-new-item', ButtonNewItem);
app.component('toast-success', ToastSuccess);
app.component('alert-component', AlertComponent);
app.component('paginate-component', PaginateComponent);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */
app.use(pinia);
app.mount('#app');

