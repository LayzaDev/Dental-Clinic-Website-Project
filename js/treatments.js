window.onload = () => {
  const modals = document.querySelectorAll('.modal');

  for (let modal of modals) {
    let span = modal.parentNode.querySelector('span');
    span.onclick = () => modal.classList.add('showModal');
    span.ondblclick = () => modal.classList.remove('showModal');
    modal.onclick = () => modal.classList.remove('showModal');
  }
};
