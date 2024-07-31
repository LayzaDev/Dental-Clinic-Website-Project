async function searchAddress() {
  let cepValue = cep.value;

  if(cepValue.length != 9) return;

  const url = `https://viacep.com.br/ws/${cepValue}/json/`;

  let request = await fetch(url);
  let {logradouro, bairro, localidade, uf} = await request.json();

  let street = document.querySelector("#street");
  let neighborhood = document.querySelector("#neighborhood");
  let city = document.querySelector("#city");
  let state = document.querySelector("#uf");

  street.value = logradouro;
  neighborhood.value = bairro;
  city.value = localidade;
  state.value = uf;
}

let cep = document.querySelector("#cep");

cep.onkeyup = () => {
  searchAddress();
}
