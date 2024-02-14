<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card">
                    <div class="card-header">Login</div>

                    <div class="card-body">
                        <form method="POST" action="" @submit.prevent=login($event)>
                            <input type="hidden" name="_token" :value="token_csrf">

                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">Email</label>

                                <div class="col-md-6">
                                    <input
                                        id="email"
                                        v-model="email"
                                        type="email"
                                        class="form-control"
                                        name="email" value="" required autocomplete="email" autofocus>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">Senha</label>

                                <div class="col-md-6">
                                    <input
                                        id="password"
                                        v-model="password"
                                        type="password"
                                        class="form-control" name="password"
                                        required autocomplete="current-password">

                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember">

                                        <label class="form-check-label" for="remember">
                                            Mantenha-me conectado
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Login
                                    </button>

                                    <a class="btn btn-link" href="">
                                        Esqueci a senha
                                    </a>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineProps, ref } from 'vue';
import axios from 'axios'

let props = defineProps({
    token_csrf: {
        type: String,
    },
})

const email = ref("");
const password = ref("");

const login = async (event) => {

    let url = 'http://localhost:8001/api/login';
    let data = {
        email: email.value,
        password: password.value
    }
    try {
        const response = await axios.post(url, data)
        const token = response.data.token;
        if(token){
            document.cookie = "token_jwt="+token+";SameSite=Lax"
        }
        event.target.submit();
    } catch(e) {
        console.log(e)
    }
}

</script>
