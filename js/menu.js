document.addEventListener("DOMContentLoaded", () => {
  const currentPath = window.location.pathname;
  const links = document.querySelectorAll("nav ul li a");

  links.forEach(link => {
    const linkPath = new URL(link.href).pathname;

    if (currentPath.startsWith(linkPath)) {
      link.classList.add("active");
    }
  });
});
