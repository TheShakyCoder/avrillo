<script setup>
import {onMounted, reactive, ref} from "vue";

const token = ref(null)
const page = ref(1)
const quotes = ref([])

const registerForm = reactive({
    name: '',
    email: '',
    password: ''
})

const loginForm = reactive({
    email: '',
    password: ''
})

async function register() {
    const res = await axios.post('http://avrillo.test/api/register', registerForm)
        // .catch(error => form.error = error.response.data.message)
    localStorage.setItem('token', res.data.token)
    token.value = res.data.token
}

async function login() {
    const res = await axios.post('http://avrillo.test/api/login', loginForm)
        .catch(error => {
            // loginForm.error = error.response.data.message
            // loginForm.processing = false
        })

    localStorage.setItem('token', res.data.token)
    token.value = res.data.token
}

async function moreQuotes(u) {
    const res = await axios.get(u, {
        headers: {
            Authorization: 'Bearer ' + token.value
        }
    })
    quotes.value = res.data
}

async function fetchQuotes() {
    const res = await axios.get('http://avrillo.test/api/quotes?page='+page.value, {
        headers: {
            Authorization: 'Bearer ' + token.value
        }
    })
    quotes.value = res.data
}

function logout() {
    localStorage.removeItem('token')
    token.value = null
}


onMounted(() => token.value = localStorage.getItem('token'))
</script>

<template>
    <div>
        <div>TOKEN: {{ token }}</div>
        <div>CURRENT: {{ quotes.current_page }}</div>
        <div>LAST: {{ quotes.last_page }}</div>

        <div v-if="!token" class="flex flex-col bg-gray-100 max-w-100 p-8 rounded">
            <h2 class="text-xl font-bold">Register</h2>
            <form class="flex flex-col">
                <input type="text" name="name" v-model="registerForm.name" placeholder="name" class="w-80 text-xl p-2" />
                <input type="email" name="email" v-model="registerForm.email" placeholder="email" class="w-80 text-xl p-2" />
                <input type="password" name="password" v-model="registerForm.password" placeholder="password" class="w-80 text-xl p-2" />
                <button @click="register" class="flex justify-center p-2 bg-green-600 text-white w-80 ">Register</button>
            </form>
        </div>

        <div v-if="!token" class="flex flex-col bg-gray-100 max-w-100 p-8 rounded">
            <h2 class="text-xl font-bold">Login</h2>
            <form class="flex flex-col">
                <input type="email" name="email" v-model="loginForm.email" placeholder="email" class="w-80 text-xl p-2" />
                <input type="password" name="password" v-model="loginForm.password" placeholder="password" class="w-80 text-xl p-2" />
                <button @click="login" class="flex justify-center p-2 bg-green-600 text-white w-80 ">Login</button>
            </form>
        </div>

        <div v-if="token" class="flex flex-col bg-gray-100 max-w-100 p-8 rounded">
            <h2 class="text-xl font-bold">Quotes</h2>
            <form @submit.prevent="login" class="flex flex-col">
                <button @click="fetchQuotes" class="flex justify-center p-2 bg-green-600 text-white w-80 ">Fetch</button>
            </form>
            <ul>
                <li v-for="quote in quotes.data" class="my-4 w-80">
                    <div class="bg-gray-200 p-2 px-3">{{ quote.quote }}</div>
                </li>
            </ul>

            <button class="bg-sky-300 p-2 w-80" v-if="quotes.current_page < quotes.last_page" @click="moreQuotes(quotes.next_page_url)">Get another 5</button>
            <button class="mt-8 bg-red-300 p-2 w-80" v-if="token" @click="logout">Log Out</button>
        </div>


    </div>


</template>

<style scoped>

</style>
