function validateForm(){

  const spanEmail = document.querySelector("#email + .validationSpan");
  const spanPassword = document.querySelector("#password + .validationSpan");

  const inputEmail = document.querySelector("#email");
  const inputPassword = document.querySelector("#password");

  spanEmail.textContent = "";
  spanPassword.textContent = "";

  if(inputEmail.value === ""){
    spanEmail.textContent = "O email deve ser preenchido";
  }
  
  if(inputPassword.value === "") {
    spanPassword.textContent = "A senha deve ser preenchida";
  }
}

async function sendForm(form) {
  try {
    const response = await fetch("php/login.php", {method: 'post', body: new FormData(form)});

    if(!response.ok) throw new Error(response.statusText);

    var bodyText = await response.text();
    const result = JSON.parse(bodyText);

    if(result.success)
      window.location = result.detail;
    else {
      document.querySelector("#loginFailMsg").style.display = 'block';
      form.password.value = "";
      form.password.focus();
    }
  } catch (error) {
    console.log(bodyText ?? "");
    console.error(error);
  }
}

window.onload = () => {
  const form = document.querySelector("#formLogin");
  form.onsubmit = (event) => {
    event.preventDefault();
    validateForm();
    sendForm(form);
  }
}
