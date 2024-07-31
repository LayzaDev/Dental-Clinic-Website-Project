window.onload = () => {
  const spansSaibaMais = document.querySelectorAll(".description span");

  spansSaibaMais.forEach((element) => {
    element.onclick = () => {
      const modal = element.closest(".card").querySelector(".modal");

      if (modal.classList.contains("visible")) {
        modal.classList.remove("visible");
      } else {
        modal.classList.add("visible");
      }
    };
  });
};
