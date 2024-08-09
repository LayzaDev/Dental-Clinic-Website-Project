async function loadSelectProfessionals() {
  let specialty = document.querySelector("#specialty").value;

  let professionals = await getProfessionals(specialty);

  let inputProfessionals = document.querySelector("#professional");

  inputProfessionals.innerHTML = "";

  professionals.forEach((p) => {
    let option = document.createElement("option");
    option.value = p.id;
    option.innerText = p.name;

    inputProfessionals.appendChild(option);
  });
}

window.onload = () => {
  loadSelectProfessionals();
};
