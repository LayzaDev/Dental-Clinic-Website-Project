function validateForm(email, password, validationSpan){

  validationSpan.textContent = "";

  if(!email || !password) {
    validationSpan.textContent = "Por favor, preencha todos os campos.";
    return false;
  }

  return true;
}

async function submitForm(email, password, validationSpan){

  const isValid = validateForm(email, password, validationSpan);

  if(!isValid) return;

  const loginData = {email, password};

  const options = {
    method: "POST",
    body: JSON.stringify(loginData),
    headers: {'Content-Type': 'application/json'}
  }

  try {
    const result = await fetch('php/loginControl.php', options);
    const data = await result.json();

    if(!result.ok) throw new Error(`Erro na resposta do servidor: ${result.statusText}`);

    if(data.success){
      window.location.href = 'restricted/home.php';
    } else {
      validationSpan.textContent = "Dados incorretos. Por favor, tente novamente.";
    }
  } catch(error){
    console.error(`Erro ao tentar fazer login: ${error}`);
    validationSpan.textContent = "Erro ao tentar fazer login. Por favor, tente novamente mais tarde.";
  }
}

window.onload = () => {

  const form = document.querySelector("#formLogin");

  form.onsubmit = async (event) => {
    event.preventDefault();
      
    const email = document.querySelector("#email").value;
    const password = document.querySelector("#password").value;
    const validationSpan = document.querySelector(".validationSpan");

    await submitForm(email, password, validationSpan);
  }
}