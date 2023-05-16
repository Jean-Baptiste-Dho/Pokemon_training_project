const pathLogin = 'https://training.ddev.site:8081/api/login_check'

const pathTest = 'https://training.ddev.site:8081/api/testage/pokemon'
const pathGetPoke = 'https://training.ddev.site:8081/api/capturedPokemon'

let token

// const data = {
//     "username": "Sacha@gmail.com",
//     "password": "Sacha"
// };

const username = document.querySelector('#username')
const password = document.querySelector('#password')
const button = document.querySelector('#connexion')
const buttonDeco = document.querySelector('#deconnexion')
const form = document.querySelector('form')
const spanErr = document.querySelector('#error')
const spanCo = document.querySelector('#co')


/***************** Deconnexion ***********************/
buttonDeco.addEventListener('click', handleDeco)

function handleDeco(event) {
    event.preventDefault()
    if (localStorage.getItem('token')) {
        localStorage.removeItem('token')
        render()
    }
}

/***************** Connexion ***********************/

if (!localStorage.getItem('token')) {
    button.addEventListener('click', handleLogin)
}

function handleLogin(event) {
    event.preventDefault()
    let datas = {
        'username': username.value,
        'password': password.value,

    }
    // login(datas)

    getPokemons(datas);

}


async function login(datas) {
    try {
        const response = await fetch(pathLogin, {
            method: "POST", // or 'PUT'
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json"
            },
            body: JSON.stringify(datas),
        })
            .then(response => {
                // console.log(response.ok)
                if (response.ok === true) {
                    return response.json()
                } else {
                    spanErr.hidden = false
                    throw new Error('Paramères érronés')
                }
            })
            .then(response => {
                spanCo.hidden = false
                localStorage.setItem('token', response.token)
                render()
            })

    } catch (error) {
        console.error("Error:", error);
    }
}

function render() {
    spanErr.hidden = true
    if (localStorage.getItem('token')) {
        form.hidden = true
        buttonDeco.hidden = false
    } else {
        spanCo.hidden = true
        form.hidden = false
        buttonDeco.hidden = true
    }
}


async function getPokemons(datas) {
    await login(datas)
    // TODO get pokemon avec un fetch
    // console.log(token);
    let token = localStorage.getItem('token')
    // console.log(token)
    if (localStorage.getItem('token')) {

        fetch(pathGetPoke, {
            method: "GET", // or 'PUT'
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "Authorization": "Bearer " + token
            },
        })
            .then(response => response.json())
            .then(response => {
                pokemonRender(response)
                console.log(response)
            })
    }
}

const pokemonRender = (pokemons) => {
    // let content = [pokemon]
    const fragment = document.createDocumentFragment();
    const ul = fragment
        .appendChild(document.createElement("section"))
        .appendChild(document.createElement("ul"))
    for (let pokemon of pokemons) {
        const li = ul.appendChild(document.createElement("li"));
        if (pokemon.surname) {
            li.textContent = pokemon.surname;
        } else {
            li.textContent = "pas de surnom";
        }
        document.body.appendChild(fragment);
    }
}

render()
