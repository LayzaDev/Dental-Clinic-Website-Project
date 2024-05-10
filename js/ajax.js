let cep = document.querySelector("#cep");

cep.onkeyup = () => {
  searchAddress();
}

async function searchAddress() {
  let cepValue = cep.value;

  if(cepValue.length != 9) return;

  const url = `https://viacep.com.br/ws/${cepValue}/json/`;

  let request = await fetch(url);
  let {logradouro, bairro, localidade, uf} = await request.json();

  let street = document.querySelector("#street");
  let neighborhood = document.querySelector("#neighborhood");
  let locality = document.querySelector("#locality");
  let state = document.querySelector("#state");

  street.value = logradouro;
  neighborhood.value = bairro;
  locality.value = localidade;
  state.value = uf;
}
