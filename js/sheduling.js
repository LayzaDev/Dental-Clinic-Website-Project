
async function selectProfessional(specialtyValue) {

  let professionalField = document.querySelector("#professional");
  professionalField.innerHTML = '<option value=""> Selecione </option>';
  
  try {
    let response = await fetch(`catchProfessionals.php?specialtyValue=${specialtyValue}`);

    if(!response.ok) throw new Error(`Erro na resposta do servidor: ${response.statusText}`);

    const data = await response.json();

    data.forEach(professional => {
      const option = document.createElement("option");
      
      option.value = professional.id;
      option.textContent = professional.name;
      professionalField.appendChild(option);
      
    });
  } catch (error) {
    console.error(`Erro ao tentar carregar profissionais: ${error}`);
    return;
  }
}

let specialty = document.querySelector("#specialty");

specialty.onchange = () => {
  let specialtyValue = specialty.value;  
  selectProfessional(specialtyValue);
}
