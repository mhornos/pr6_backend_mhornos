// preview de la imatge en temps real als formularis d'inserir i modificar

document.addEventListener("DOMContentLoaded", () => {
  const inputImatge = document.getElementById("imatge");
  const previewImatge = document.getElementById("preview-imatge");

  // si no existeixen els elements, no fa res
  if (!inputImatge || !previewImatge) return;

  function actualitzarPreview() {
    const url = inputImatge.value.trim();

    if (url === "") {
      previewImatge.removeAttribute("src");
      return;
    }

    previewImatge.src = url;
  }

  inputImatge.addEventListener("input", actualitzarPreview);

  actualitzarPreview();
});