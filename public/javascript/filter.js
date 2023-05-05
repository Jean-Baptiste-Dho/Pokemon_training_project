const targetPokemonSelect = document.querySelector('#create_trading_form_pokemon')
// const pokemonBuyerSelect = document.querySelector('#create_trading_form_capturedPokemonBuyer')
const pokemonBuyerOptions = document.querySelectorAll('#create_trading_form_capturedPokemonBuyer option')

const updateList = () => {
    // let pokemonType = targetPokemonSelect.value;
    // let length = (pokemonBuyerSelect.options.length) - 1;
    //
    // for (let i = 1; i <= length; i++) {
    //     let option = pokemonBuyerSelect.options[i]
    //     let capturedPokemonType = option.dataset.pokemonId;
    //     if (pokemonType !== capturedPokemonType) {
    //         option.setAttribute('hidden', '')
    //     } else {
    //         option.removeAttribute('hidden')
    //     }
    // }

    let pokemonType = targetPokemonSelect.value;

    pokemonBuyerOptions.forEach(function (option) {
        let capturedPokemonType = option.dataset.pokemonId;
        if (pokemonType !== capturedPokemonType) {
            option.setAttribute('hidden', '')
        } else {
            option.removeAttribute('hidden')
        }
    })
}
targetPokemonSelect.addEventListener("change", updateList);
