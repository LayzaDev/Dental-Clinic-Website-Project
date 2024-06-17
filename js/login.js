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

window.onload = () => {
  const form = document.querySelector("#formLogin");
  form.onsubmit = (event) => {
    event.preventDefault();
    validateForm();
  }
}
