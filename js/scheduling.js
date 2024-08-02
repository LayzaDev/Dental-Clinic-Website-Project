async function getProfessionals(specialtyValue) {
  try {
    let url = `/realsmile/restricted/register/catchProfessionals.php?specialtyValue=${specialtyValue}`;

    let response = await fetch(url);

    if (!response.ok) {
      throw new Error(`Erro na resposta do servidor: ${response.statusText}`);
    }

    let data = await response.json();

    return data;
  } catch (error) {
    console.error(`Erro ao tentar carregar profissionais: ${error}`);
    return;
  }
}
