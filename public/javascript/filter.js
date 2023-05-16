const targetPokemonSelect = document.querySelector('#create_trading_form_pokemon')
const pokemonBuyerOptions = document.querySelectorAll('#create_trading_form_capturedPokemonBuyer option')

const updateList = () => {
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
if (targetPokemonSelect) {
    targetPokemonSelect.addEventListener("change", updateList);
}
